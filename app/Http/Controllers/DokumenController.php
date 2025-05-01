<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DokumenController extends Controller
{
    public function __construct()
    {
        // Allow both admin and mahasiswa to access these methods
        // No strict middleware as we're checking guard in methods
    }
    
    public function index()
    {
        $dokumen = Dokumen::with('pengajuan')->get();
        return view('dokumen.index', compact('dokumen'));
    }
    
    public function create($pengajuanId)
    {
        $pengajuan = Pengajuan::findOrFail($pengajuanId);
        return view('dokumen.create', compact('pengajuan'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_pengajuan' => 'required|exists:pengajuan,id_pengajuan',
            'nama_dokumen' => 'required|string|max:255',
            'dokumen_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
        ]);
        
        $file = $request->file('dokumen_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('dokumen', $fileName, 'public');
        
        $dokumen = Dokumen::create([
            'id_pengajuan' => $request->id_pengajuan,
            'nama_dokumen' => $request->nama_dokumen,
            'file_path' => $filePath,
            'status_verifikasi' => 'belum_diverifikasi',
        ]);
        
        // Redirect based on guard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.pengajuan.show', $request->id_pengajuan)
                ->with('success', 'Dokumen berhasil diunggah.');
        } else {
            return redirect()->route('pengajuan.index')
                ->with('success', 'Dokumen berhasil diunggah.');
        }
    }
    
    public function show($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('dokumen.show', compact('dokumen'));
    }
    
    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('dokumen.edit', compact('dokumen'));
    }
    
    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'dokumen_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
        ]);
        
        // Update file if a new one is uploaded
        if ($request->hasFile('dokumen_file')) {
            // Delete old file
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            
            // Store new file
            $file = $request->file('dokumen_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumen', $fileName, 'public');
            
            $dokumen->file_path = $filePath;
        }
        
        $dokumen->nama_dokumen = $request->nama_dokumen;
        $dokumen->save();
        
        // Redirect based on guard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.pengajuan.show', $dokumen->id_pengajuan)
                ->with('success', 'Dokumen berhasil diperbarui.');
        } else {
            return redirect()->route('pengajuan.index')
                ->with('success', 'Dokumen berhasil diperbarui.');
        }
    }
    
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $pengajuanId = $dokumen->id_pengajuan;
        
        // Delete file from storage
        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }
        
        $dokumen->delete();
        
        // Redirect based on guard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.pengajuan.show', $pengajuanId)
                ->with('success', 'Dokumen berhasil dihapus.');
        } else {
            return redirect()->route('pengajuan.index')
                ->with('success', 'Dokumen berhasil dihapus.');
        }
    }
    
    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        if (!Storage::disk('public')->exists($dokumen->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        
        return response()->download(storage_path('app/public/' . $dokumen->file_path), $dokumen->nama_dokumen);
    }
    
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:belum_diverifikasi,valid,tidak_valid',
            'keterangan' => 'nullable|string',
        ]);
        
        $dokumen = Dokumen::findOrFail($id);
        $dokumen->status_verifikasi = $request->status_verifikasi;
        $dokumen->keterangan = $request->keterangan;
        $dokumen->save();
        
        return redirect()->back()->with('success', 'Status verifikasi dokumen berhasil diperbarui.');
    }
} 