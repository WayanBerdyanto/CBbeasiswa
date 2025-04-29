<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Syarat;
use App\Models\Pengajuan;
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

        return view('beasiswa.formPengajuan', compact('user', 'syarat'));
    }

    // Menyimpan data pengajuan beasiswa
    public function simpanPengajuan(Request $request)
    {
        $request->validate([
            'id_beasiswa' => 'required|exists:beasiswa,id_beasiswa',
            'alasan_pengajuan' => 'required|string',
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('dokumen')->store('dokumen', 'public');

        Pengajuan::create([
            'id_beasiswa' => $request->id_beasiswa,
            'id_mahasiswa' => Auth::guard('mahasiswa')->id(),
            'status_pengajuan' => 'diproses',
            'tgl_pengajuan' => now(),
            'alasan_pengajuan' => $request->alasan_pengajuan,
            'dokumen' => $file
        ]);

        return redirect()->route('beasiswa.index')->with('success', 'Pengajuan berhasil dikirim!');
    }

    // Menampilkan daftar pengajuan beasiswa milik user yang login
    public function daftar()
    {
        $pengajuan = Pengajuan::with('beasiswa')
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

        if ($pengajuan->dokumen) {
            Storage::disk('public')->delete($pengajuan->dokumen);
        }

        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
