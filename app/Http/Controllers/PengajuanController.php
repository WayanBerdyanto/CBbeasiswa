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
        $beasiswa = Beasiswa::with('syarat')->findOrFail($id);
        $syarat = Syarat::where('id_beasiswa', $id)->get();
        $periodeAktif = PeriodeBeasiswa::where('id_beasiswa', $id)
            ->where('status', 'aktif')
            ->first();
            
        // Validasi ketersediaan periode aktif
        if (!$periodeAktif) {
            return redirect()->route('beasiswa.index')
                ->with('error', 'Beasiswa tidak sedang dalam periode pendaftaran aktif.');
        }
        
        // Validasi tipe semester (ganjil/genap)
        $semesterMahasiswa = (int)$user->semester;
        $isGanjil = $semesterMahasiswa % 2 === 1; // Semester ganjil (1, 3, 5, 7)
        
        if ($periodeAktif->tipe_semester === 'ganjil' && !$isGanjil) {
            return redirect()->route('beasiswa.index')
                ->with('error', 'Beasiswa ini hanya tersedia untuk mahasiswa semester ganjil. Semester Anda saat ini adalah ' . $semesterMahasiswa . ' (semester genap).');
        }
        
        if ($periodeAktif->tipe_semester === 'genap' && $isGanjil) {
            return redirect()->route('beasiswa.index')
                ->with('error', 'Beasiswa ini hanya tersedia untuk mahasiswa semester genap. Semester Anda saat ini adalah ' . $semesterMahasiswa . ' (semester ganjil).');
        }
        
        // Validasi syarat semester tertentu
        if (!empty($periodeAktif->semester_syarat)) {
            $allowedSemesters = explode(',', $periodeAktif->semester_syarat);
            $allowedSemesters = array_map('trim', $allowedSemesters);
            
            if (!in_array((string)$semesterMahasiswa, $allowedSemesters)) {
                return redirect()->route('beasiswa.index')
                    ->with('error', 'Beasiswa ini hanya tersedia untuk mahasiswa semester ' . $periodeAktif->semester_syarat . '. Semester Anda saat ini adalah ' . $semesterMahasiswa . '.');
            }
        }

        // Cek IPK minimal sebagai syarat
        $syaratIPK = Syarat::where('id_beasiswa', $id)->first();
            
        if ($syaratIPK && $user->ipk_terakhir < $syaratIPK->syarat_ipk) {
            return redirect()->route('beasiswa.index')
                ->with('error', 'IPK Anda ('.$user->ipk_terakhir.') tidak memenuhi syarat minimal ('.$syaratIPK->syarat_ipk.')');
        }

        return view('beasiswa.formPengajuan', compact('user', 'beasiswa', 'syarat', 'periodeAktif', 'syaratIPK'));
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
            
        // Validasi periode aktif
        if (!$periode) {
            return redirect()->route('beasiswa.index')
                ->with('error', 'Beasiswa tidak sedang dalam periode pendaftaran aktif.');
        }
        
        // Validasi tipe semester & syarat semester
        $user = Auth::guard('mahasiswa')->user();
        $semesterMahasiswa = (int)$user->semester;
        $isGanjil = $semesterMahasiswa % 2 === 1; // Semester ganjil (1, 3, 5, 7)
        
        if ($periode->tipe_semester === 'ganjil' && !$isGanjil) {
            return redirect()->route('beasiswa.index')
                ->with('error', 'Beasiswa ini hanya tersedia untuk mahasiswa semester ganjil.');
        }
        
        if ($periode->tipe_semester === 'genap' && $isGanjil) {
            return redirect()->route('beasiswa.index')
                ->with('error', 'Beasiswa ini hanya tersedia untuk mahasiswa semester genap.');
        }
        
        // Validasi syarat semester tertentu
        if (!empty($periode->semester_syarat)) {
            $allowedSemesters = explode(',', $periode->semester_syarat);
            $allowedSemesters = array_map('trim', $allowedSemesters);
            
            if (!in_array((string)$semesterMahasiswa, $allowedSemesters)) {
                return redirect()->route('beasiswa.index')
                    ->with('error', 'Beasiswa ini hanya tersedia untuk mahasiswa semester ' . $periode->semester_syarat . '.');
            }
        }
        
        $syarat = Syarat::where('id_beasiswa', $request->id_beasiswa)->value('syarat_ipk');
        $beasiswa = Beasiswa::find($request->id_beasiswa);
        
        if($request->ipk <= $syarat) {
            return redirect()->route('syarat.index', $request->id_beasiswa)->with('error', 'Belum Memenuhi syarat');
        }
        
        // Create pengajuan
        $pengajuan = Pengajuan::create([
            'id_beasiswa' => $request->id_beasiswa,
            'id_mahasiswa' => Auth::guard('mahasiswa')->id(),
            'id_periode' => $periode ? $periode->id_periode : null,
            'status_pengajuan' => 'diproses',
            'nominal_approved' => $beasiswa->nominal, // Menggunakan nominal default dari beasiswa
            'tgl_pengajuan' => now(),
            'alasan_pengajuan' => $request->alasan_pengajuan,
            'ipk' => $request->ipk,
        ]);
        
        // Log pengajuan yang dibuat
        \Illuminate\Support\Facades\Log::info('Pengajuan: New application created', [
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'id_beasiswa' => $pengajuan->id_beasiswa,
            'beasiswa_nominal' => $beasiswa->nominal,
            'nominal_approved' => $pengajuan->nominal_approved,
            'status' => $pengajuan->status_pengajuan
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
    public function daftar(Request $request)
    {
        $query = Pengajuan::with(['beasiswa', 'dokumen'])
            ->where('id_mahasiswa', Auth::guard('mahasiswa')->id());

        // Filter by status
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status_pengajuan', $request->status);
        }

        // Filter by date range
        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tgl_pengajuan', [
                $request->tanggal_mulai,
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        // Filter by beasiswa
        if ($request->has('beasiswa') && $request->beasiswa != 'semua') {
            $query->where('id_beasiswa', $request->beasiswa);
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->get();
        $beasiswas = Beasiswa::all(); // For filter dropdown

        return view('beasiswa.pengajuan', compact('pengajuan', 'beasiswas'));
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

    // Menampilkan detail pengajuan beasiswa
    public function detail($id)
    {
        // Memastikan nominal_approved terload dengan benar
        $pengajuan = Pengajuan::select([
                'pengajuan.*',   // Seleksi semua kolom
                'nominal_approved', // Pastikan kolom nominal_approved terload
            ])
            ->with(['beasiswa', 'mahasiswa', 'periode', 'dokumen'])
            ->where('id_pengajuan', $id)
            ->where('id_mahasiswa', Auth::guard('mahasiswa')->id())
            ->firstOrFail();
            
        // Log untuk debugging
        \Illuminate\Support\Facades\Log::info('Pengajuan: Detail viewed', [
            'id_pengajuan' => $pengajuan->id_pengajuan,
            'nominal_approved' => $pengajuan->nominal_approved,
            'beasiswa_nominal' => $pengajuan->beasiswa->nominal
        ]);
        
        return view('beasiswa.detailPengajuan', compact('pengajuan'));
    }

    public function export(Request $request)
    {
        $query = Pengajuan::with(['beasiswa', 'dokumen', 'mahasiswa'])
            ->where('id_mahasiswa', Auth::guard('mahasiswa')->id());

        // Apply filters to export
        if ($request->has('status') && $request->status != 'semua') {
            $query->where('status_pengajuan', $request->status);
        }

        if ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) {
            $query->whereBetween('tgl_pengajuan', [
                $request->tanggal_mulai,
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        if ($request->has('beasiswa') && $request->beasiswa != 'semua') {
            $query->where('id_beasiswa', $request->beasiswa);
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->get();

        // Generate CSV
        $filename = 'pengajuan_beasiswa_' . date('Y-m-d_His') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'Beasiswa',
            'Tanggal Pengajuan',
            'Status',
            'Nominal',
            'IPK',
            'Alasan Pengajuan'
        ]);

        foreach ($pengajuan as $item) {
            fputcsv($handle, [
                $item->beasiswa->nama_beasiswa,
                $item->tgl_pengajuan,
                ucfirst($item->status_pengajuan),
                $item->nominal_approved,
                $item->ipk,
                $item->alasan_pengajuan
            ]);
        }

        fclose($handle);
        return response()->stream(function() use ($pengajuan) {
            $handle = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($handle, [
                'Beasiswa',
                'Tanggal Pengajuan',
                'Status',
                'Nominal',
                'IPK',
                'Alasan Pengajuan'
            ]);
            
            // Add data
            foreach ($pengajuan as $item) {
                fputcsv($handle, [
                    $item->beasiswa->nama_beasiswa,
                    $item->tgl_pengajuan,
                    ucfirst($item->status_pengajuan),
                    $item->nominal_approved,
                    $item->ipk,
                    $item->alasan_pengajuan
                ]);
            }
            
            fclose($handle);
        }, 200, $headers);
    }
}
