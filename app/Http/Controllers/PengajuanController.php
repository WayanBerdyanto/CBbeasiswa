<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Syarat;
use App\Models\Pengajuan;
use App\Models\Dokumen;
use App\Models\PeriodeBeasiswa;
use App\Models\Beasiswa;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    // Menampilkan semua syarat dari semua beasiswa
    public function syaratBeasiswa()
    {
        $syarat = Syarat::with('beasiswa')->get();
        return view('beasiswa.syarat', compact('syarat'));
    }

    // Menampilkan form pengajuan untuk beasiswa tertentu
    public function form($id)
    {
        $user = Auth::guard('mahasiswa')->user();
        $syarat = Syarat::where('id_beasiswa', $id)->first();
        $periodeAktif = PeriodeBeasiswa::where('id_beasiswa', $id)
            ->where('status', 'aktif')
            ->first();

        return view('beasiswa.formPengajuan', compact('user', 'syarat', 'periodeAktif'));
    }

    // Menyimpan data pengajuan beasiswa
    public function simpanPengajuan(Request $request)
    {
        $request->validate([
            'id_beasiswa' => 'required|exists:beasiswa,id_beasiswa',
            'alasan_pengajuan' => 'required|string',
            'ipk' => 'required|numeric|min:0|max:4',
            'dokumen_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
            'nama_dokumen' => 'required|string|max:255',
        ]);

        // Get active period
        $periode = PeriodeBeasiswa::where('id_beasiswa', $request->id_beasiswa)
            ->where('status', 'aktif')
            ->first();
            
        // Create pengajuan
        $pengajuan = Pengajuan::create([
            'id_beasiswa' => $request->id_beasiswa,
            'id_mahasiswa' => Auth::guard('mahasiswa')->id(),
            'id_periode' => $periode ? $periode->id_periode : null,
            'status_pengajuan' => 'diproses',
            'tgl_pengajuan' => now(),
            'alasan_pengajuan' => $request->alasan_pengajuan,
            'ipk' => $request->ipk,
        ]);
        
        // Upload and store document
        $file = $request->file('dokumen_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('dokumen', $fileName, 'public');
        
        // Create document record
        Dokumen::create([
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'nama_dokumen' => $request->nama_dokumen,
            'file_path' => $filePath,
            'status_verifikasi' => 'belum_diverifikasi',
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dikirim!');
    }

    // Menampilkan form edit pengajuan
    public function edit($id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        // Find the application and ensure it belongs to the logged-in student
        $pengajuan = Pengajuan::with(['beasiswa', 'dokumen'])
            ->where('id_pengajuan', $id)
            ->where('id_mahasiswa', $mahasiswa->id)
            ->firstOrFail();
        
        // Check if the application is in "diproses" status
        // Only allow editing if the application is still being processed
        if ($pengajuan->status_pengajuan !== 'diproses') {
            return redirect()->route('pengajuan.index')
                ->with('error', 'Pengajuan tidak dapat diedit karena status sudah ' . $pengajuan->status_pengajuan);
        }
        
        $beasiswa = Beasiswa::find($pengajuan->id_beasiswa);
        
        return view('beasiswa.editPengajuan', compact('pengajuan', 'beasiswa', 'mahasiswa'));
    }
    
    // Update pengajuan beasiswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'alasan_pengajuan' => 'required|string',
            'ipk' => 'required|numeric|min:0|max:4',
        ]);
        
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        // Find the application and ensure it belongs to the logged-in student
        $pengajuan = Pengajuan::where('id_pengajuan', $id)
            ->where('id_mahasiswa', $mahasiswa->id)
            ->firstOrFail();
        
        // Check if the application is in "diproses" status
        if ($pengajuan->status_pengajuan !== 'diproses') {
            return redirect()->route('pengajuan.index')
                ->with('error', 'Pengajuan tidak dapat diedit karena status sudah ' . $pengajuan->status_pengajuan);
        }
        
        // Update the application
        $pengajuan->update([
            'alasan_pengajuan' => $request->alasan_pengajuan,
            'ipk' => $request->ipk,
        ]);
        
        return redirect()->route('pengajuan.index')
            ->with('success', 'Pengajuan berhasil diperbarui');
    }

    // Menampilkan daftar pengajuan beasiswa milik user yang login
    public function daftar()
    {
        $pengajuan = Pengajuan::with(['beasiswa', 'dokumen'])
            ->where('id_mahasiswa', Auth::guard('mahasiswa')->id())
            ->get();

        return view('beasiswa.pengajuan', compact('pengajuan'));
    }

    // Menghapus pengajuan yang telah dibuat
    public function hapus($id)
    {
        $pengajuan = Pengajuan::where('id_pengajuan', $id)
            ->where('id_mahasiswa', Auth::guard('mahasiswa')->id())
            ->firstOrFail();

        // Delete all related documents
        foreach ($pengajuan->dokumen as $dokumen) {
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $dokumen->delete();
        }

        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
