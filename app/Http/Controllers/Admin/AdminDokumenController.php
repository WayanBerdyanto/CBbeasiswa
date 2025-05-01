<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDokumenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokumen = Dokumen::with('pengajuan')->get();
        return view('admin.dokumen.index', compact('dokumen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $pengajuanId
     * @return \Illuminate\Http\Response
     */
    public function create($pengajuanId)
    {
        $pengajuan = Pengajuan::findOrFail($pengajuanId);
        return view('admin.dokumen.create', compact('pengajuan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        
        return redirect()->route('admin.pengajuan.show', $request->id_pengajuan)
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('admin.dokumen.show', compact('dokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('admin.dokumen.edit', compact('dokumen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        
        return redirect()->route('admin.pengajuan.show', $dokumen->id_pengajuan)
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $pengajuanId = $dokumen->id_pengajuan;
        
        // Delete file from storage
        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }
        
        $dokumen->delete();
        
        return redirect()->route('admin.pengajuan.show', $pengajuanId)
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Download the specified document.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        if (!Storage::disk('public')->exists($dokumen->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        
        return response()->download(storage_path('app/public/' . $dokumen->file_path), $dokumen->nama_dokumen);
    }

    /**
     * Show form for verifying document status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifikasiForm($id)
    {
        $dokumen = Dokumen::with(['pengajuan.mahasiswa', 'pengajuan.beasiswa'])->findOrFail($id);
        return view('admin.dokumen.verifikasi', compact('dokumen'));
    }

    /**
     * Verify document status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        
        return redirect()->route('admin.pengajuan.show', $dokumen->id_pengajuan)
            ->with('success', 'Status verifikasi dokumen berhasil diperbarui.');
    }
} 