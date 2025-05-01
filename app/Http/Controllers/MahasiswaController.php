<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('mahasiswa')->user();
        
        // Count user's applications by status
        $totalPengajuan = Pengajuan::where('id_mahasiswa', $user->id)->count();
        $penerimaanDiterima = Pengajuan::where('id_mahasiswa', $user->id)
            ->where('status_pengajuan', 'diterima')
            ->count();
        $penerimaanDiproses = Pengajuan::where('id_mahasiswa', $user->id)
            ->where('status_pengajuan', 'diproses')
            ->count();
        $penerimaanDitolak = Pengajuan::where('id_mahasiswa', $user->id)
            ->where('status_pengajuan', 'ditolak')
            ->count();
            
        // Get recent applications
        $recentPengajuan = Pengajuan::with(['beasiswa', 'dokumen'])
            ->where('id_mahasiswa', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        return view('mahasiswa.dashboard', compact(
            'user',
            'totalPengajuan',
            'penerimaanDiterima',
            'penerimaanDiproses',
            'penerimaanDitolak',
            'recentPengajuan'
        ));
    }
} 