<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Count statistics
        $totalBeasiswa = Beasiswa::count();
        $totalMahasiswa = Mahasiswa::count();
        
        // Count pengajuan by status
        $penerimaanDiterima = Pengajuan::where('status_pengajuan', 'diterima')->count();
        $penerimaanDiproses = Pengajuan::where('status_pengajuan', 'diproses')->count();
        $penerimaanDitolak = Pengajuan::where('status_pengajuan', 'ditolak')->count();
        
        // Get latest pengajuan for the table
        $latestPengajuan = Pengajuan::with(['beasiswa', 'mahasiswa'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get most popular beasiswa (by number of applications)
        $popularBeasiswa = Beasiswa::select('beasiswa.*', DB::raw('COUNT(pengajuan.id_pengajuan) as total_applications'))
            ->leftJoin('pengajuan', 'beasiswa.id_beasiswa', '=', 'pengajuan.id_beasiswa')
            ->groupBy('beasiswa.id_beasiswa')
            ->orderBy('total_applications', 'desc')
            ->limit(5)
            ->get();
        
        // Calculate percentages for popular beasiswa
        $totalApplications = Pengajuan::count();
        foreach ($popularBeasiswa as $beasiswa) {
            if ($totalApplications > 0) {
                $beasiswa->percentage = round(($beasiswa->total_applications / $totalApplications) * 100);
            } else {
                $beasiswa->percentage = 0;
            }
        }
        
        // Get latest activity (most recent pengajuan status updates)
        $latestActivity = Pengajuan::with(['beasiswa', 'mahasiswa'])
            ->orderBy('updated_at', 'desc')
            ->limit(4)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalBeasiswa', 
            'totalMahasiswa',
            'penerimaanDiterima', 
            'penerimaanDiproses', 
            'penerimaanDitolak',
            'latestPengajuan',
            'popularBeasiswa',
            'latestActivity'
        ));
    }
}
