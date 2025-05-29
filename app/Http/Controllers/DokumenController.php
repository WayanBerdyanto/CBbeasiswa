<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

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
        
        // Redirect based on guard or redirect source
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.pengajuan.show', $request->id_pengajuan)
                ->with('success', 'Dokumen berhasil diunggah.');
        } else {
            // Check if request has a 'redirect_to_detail' parameter
            if ($request->has('redirect_to_detail')) {
                return redirect()->route('pengajuan.detail', $request->id_pengajuan)
                    ->with('success', 'Dokumen berhasil diunggah.');
            }
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
        
        // Redirect based on guard or redirect source
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.pengajuan.show', $dokumen->id_pengajuan)
                ->with('success', 'Dokumen berhasil diperbarui.');
        } else {
            // Check if request has a 'redirect_to_detail' parameter
            if ($request->has('redirect_to_detail')) {
                return redirect()->route('pengajuan.detail', $dokumen->id_pengajuan)
                    ->with('success', 'Dokumen berhasil diperbarui.');
            }
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
        
        // Redirect based on guard or HTTP referrer
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.pengajuan.show', $pengajuanId)
                ->with('success', 'Dokumen berhasil dihapus.');
        } else {
            // Check if the referrer contains 'detail' in the URL
            $referer = request()->headers->get('referer');
            if ($referer && strpos($referer, 'detail') !== false) {
                return redirect()->route('pengajuan.detail', $pengajuanId)
                    ->with('success', 'Dokumen berhasil dihapus.');
            }
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
        
        $path = storage_path('app/public/' . $dokumen->file_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $type = mime_content_type($path);
        $filename = Str::slug(Str::beforeLast($dokumen->nama_dokumen, '.')) . '.' . $extension;
        
        return response()->download($path, $filename, [
            'Content-Type' => $type,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
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

    /**
     * Display PDF file directly in browser
     */
    public function pdf($id)
    {
        $dokumen = Dokumen::with('pengajuan')->findOrFail($id);
        
        // Validasi akses
        if (Auth::guard('mahasiswa')->check()) {
            if ($dokumen->pengajuan->id_mahasiswa !== Auth::guard('mahasiswa')->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        if (!Storage::disk('public')->exists($dokumen->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $dokumen->file_path);
        $type = mime_content_type($path);

        // Jika file bukan PDF, redirect ke preview biasa
        if ($type !== 'application/pdf') {
            return redirect()->route('dokumen.show', $id);
        }

        // Set proper headers for PDF streaming
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $dokumen->nama_dokumen . '"',
            'Cache-Control' => 'public, must-revalidate, max-age=0',
            'Pragma' => 'public',
            'X-Content-Type-Options' => 'nosniff',
            'Accept-Ranges' => 'bytes'
        ];

        return response()->file($path, $headers);
    }

    /**
     * Generate PDF for a specific document
     */
    public function generatePdf($id)
    {
        $dokumen = Dokumen::with([
            'pengajuan', 
            'pengajuan.mahasiswa', 
            'pengajuan.beasiswa', 
            'pengajuan.beasiswa.jenisBeasiswa',
            'pengajuan.periode'
        ])->findOrFail($id);
        
        // Validasi akses
        if (Auth::guard('mahasiswa')->check()) {
            if ($dokumen->pengajuan->id_mahasiswa !== Auth::guard('mahasiswa')->id()) {
                abort(403, 'Unauthorized action.');
            }
        }
            
        $data = [
            'title' => 'Detail Dokumen Pengajuan Beasiswa',
            'date' => date('d/m/Y H:i:s'),
            'dokumen' => $dokumen,
            'pengajuan' => $dokumen->pengajuan,
            'mahasiswa' => $dokumen->pengajuan->mahasiswa,
            'beasiswa' => $dokumen->pengajuan->beasiswa,
            'nominal' => $dokumen->pengajuan->nominal_display
        ];
        
        $pdf = PDF::loadView('dokumen.pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        // Set proper headers for PDF streaming
        $filename = Str::slug($dokumen->nama_dokumen) . '.pdf';
        return $pdf->stream($filename, [
            'Attachment' => false,
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'public, must-revalidate, max-age=0',
            'Pragma' => 'public',
            'X-Content-Type-Options' => 'nosniff'
        ]);
    }
} 