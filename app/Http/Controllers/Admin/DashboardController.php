<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use App\Models\PeriodeBeasiswa;
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

        // Period statistics
        $totalPeriode = PeriodeBeasiswa::count();
        $aktivePeriode = PeriodeBeasiswa::where('status', 'aktif')->count();
        
        // Modified query to just check for active status
        $currentPeriods = PeriodeBeasiswa::where('status', 'aktif')
            ->with('beasiswa')
            ->get();

        // Get latest pengajuan for the table
        $latestPengajuan = Pengajuan::with(['beasiswa', 'mahasiswa', 'periode'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get most popular beasiswa (by number of applications)
        $popularBeasiswa = Beasiswa::select(
            'beasiswa.id_beasiswa',
            'beasiswa.nama_beasiswa',
            'beasiswa.id_jenis',
            'beasiswa.deskripsi',
            'beasiswa.created_at',
            'beasiswa.updated_at',
            DB::raw('COUNT(pengajuan.id_pengajuan) as total_applications')
        )
            ->leftJoin('pengajuan', 'beasiswa.id_beasiswa', '=', 'pengajuan.id_beasiswa')
            ->groupBy(
                'beasiswa.id_beasiswa',
                'beasiswa.nama_beasiswa',
                'beasiswa.id_jenis',
                'beasiswa.deskripsi',
                'beasiswa.created_at',
                'beasiswa.updated_at'
            )
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
        $latestActivity = Pengajuan::with(['beasiswa', 'mahasiswa', 'periode'])
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
            'latestActivity',
            'totalPeriode',
            'aktivePeriode',
            'currentPeriods'
        ));
    }
}
