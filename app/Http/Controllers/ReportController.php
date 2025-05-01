<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Beasiswa;
use App\Models\JenisBeasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        // Get the authenticated student user
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        if (!$mahasiswa) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }
        
        // Summary statistics
        $stats = [
            'total_pengajuan' => Pengajuan::where('id_mahasiswa', $mahasiswa->id)->count(),
            'pengajuan_diterima' => Pengajuan::where('id_mahasiswa', $mahasiswa->id)
                                    ->where('status_pengajuan', 'diterima')->count(),
            'pengajuan_ditolak' => Pengajuan::where('id_mahasiswa', $mahasiswa->id)
                                  ->where('status_pengajuan', 'ditolak')->count(),
            'pengajuan_diproses' => Pengajuan::where('id_mahasiswa', $mahasiswa->id)
                                   ->where('status_pengajuan', 'diproses')->count(),
        ];
        
        // Get all the student's applications by scholarship type
        $pengajuanByJenis = DB::table('pengajuan')
            ->join('beasiswa', 'pengajuan.id_beasiswa', '=', 'beasiswa.id_beasiswa')
            ->join('jenis_beasiswa', 'beasiswa.id_jenis', '=', 'jenis_beasiswa.id_jenis')
            ->where('pengajuan.id_mahasiswa', $mahasiswa->id)
            ->select(
                'jenis_beasiswa.nama_jenis',
                DB::raw('count(pengajuan.id_pengajuan) as total'),
                DB::raw('count(case when pengajuan.status_pengajuan = "diterima" then 1 end) as diterima'),
                DB::raw('count(case when pengajuan.status_pengajuan = "ditolak" then 1 end) as ditolak'),
                DB::raw('count(case when pengajuan.status_pengajuan = "diproses" then 1 end) as diproses')
            )
            ->groupBy('jenis_beasiswa.id_jenis', 'jenis_beasiswa.nama_jenis')
            ->get();
        
        // Recent applications with details
        $pengajuanList = Pengajuan::with(['beasiswa', 'beasiswa.jenisBeasiswa', 'dokumen'])
            ->where('id_mahasiswa', $mahasiswa->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get months for application statistics
        $today = now();
        $months = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = $today->copy()->subMonths($i);
            $months[$month->format('M Y')] = $month->format('Y-m');
        }
        
        // Monthly application statistics
        $monthlyStats = [];
        foreach ($months as $label => $yearMonth) {
            list($year, $month) = explode('-', $yearMonth);
            
            $monthlyStats[$label] = [
                'total' => Pengajuan::where('id_mahasiswa', $mahasiswa->id)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'diterima' => Pengajuan::where('id_mahasiswa', $mahasiswa->id)
                    ->where('status_pengajuan', 'diterima')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'ditolak' => Pengajuan::where('id_mahasiswa', $mahasiswa->id)
                    ->where('status_pengajuan', 'ditolak')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count(),
                'diproses' => Pengajuan::where('id_mahasiswa', $mahasiswa->id)
                    ->where('status_pengajuan', 'diproses')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count(),
            ];
        }
        
        return view('mahasiswa.laporan.index', compact(
            'mahasiswa', 
            'stats', 
            'pengajuanByJenis',
            'pengajuanList',
            'months',
            'monthlyStats'
        ));
    }
    
    public function exportPdf($download = true)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        if (!$mahasiswa) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }
        
        // Get all applications for this student
        $pengajuanList = Pengajuan::with(['beasiswa', 'beasiswa.jenisBeasiswa', 'dokumen'])
            ->where('id_mahasiswa', $mahasiswa->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Prepare data for PDF
        $data = [
            'title' => 'Laporan Pengajuan Beasiswa',
            'date' => date('d/m/Y H:i:s'),
            'mahasiswa' => $mahasiswa,
            'pengajuanList' => $pengajuanList,
            'count' => $pengajuanList->count(),
        ];
        
        // Generate PDF
        $pdf = PDF::loadView('mahasiswa.laporan.pdf', $data);
        $filename = 'laporan_beasiswa_' . $mahasiswa->nim . '_' . date('d-m-Y') . '.pdf';
        
        // Return based on whether to download or stream
        if ($download === 'view' || $download === false) {
            return $pdf->stream($filename);
        } else {
            return $pdf->download($filename);
        }
    }
    
    /**
     * View PDF in browser instead of downloading
     */
    public function viewPdf()
    {
        return $this->exportPdf('view');
    }
    
    public function detailPengajuan($id)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        
        if (!$mahasiswa) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }
        
        // Get the specific application
        $pengajuan = Pengajuan::with(['beasiswa', 'beasiswa.jenisBeasiswa', 'dokumen'])
            ->where('id_mahasiswa', $mahasiswa->id)
            ->where('id_pengajuan', $id)
            ->firstOrFail();
        
        return view('mahasiswa.laporan.detail', compact('pengajuan', 'mahasiswa'));
    }
}
