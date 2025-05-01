<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\JenisBeasiswa;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLaporanController extends Controller
{
    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Summary statistics
        $stats = [
            'total_beasiswa' => Beasiswa::count(),
            'total_jenis' => JenisBeasiswa::count(),
            'total_mahasiswa' => Mahasiswa::count(),
            'total_pengajuan' => Pengajuan::count(),
            'pengajuan_diterima' => Pengajuan::where('status_pengajuan', 'diterima')->count(),
            'pengajuan_ditolak' => Pengajuan::where('status_pengajuan', 'ditolak')->count(),
            'pengajuan_diproses' => Pengajuan::where('status_pengajuan', 'diproses')->count(),
        ];
        
        // Beasiswa by type statistics
        $beasiswaByType = DB::table('jenis_beasiswa')
            ->leftJoin('beasiswa', 'jenis_beasiswa.id_jenis', '=', 'beasiswa.id_jenis')
            ->select('jenis_beasiswa.nama_jenis', DB::raw('count(beasiswa.id_beasiswa) as total'))
            ->groupBy('jenis_beasiswa.id_jenis', 'jenis_beasiswa.nama_jenis')
            ->orderBy('total', 'desc')
            ->get();
            
        // Pengajuan by status and beasiswa
        $pengajuanByBeasiswa = DB::table('beasiswa')
            ->leftJoin('pengajuan', 'beasiswa.id_beasiswa', '=', 'pengajuan.id_beasiswa')
            ->select(
                'beasiswa.id_beasiswa',
                'beasiswa.nama_beasiswa',
                DB::raw('count(pengajuan.id_pengajuan) as total'),
                DB::raw('count(case when pengajuan.status_pengajuan = "diterima" then 1 end) as diterima'),
                DB::raw('count(case when pengajuan.status_pengajuan = "ditolak" then 1 end) as ditolak'),
                DB::raw('count(case when pengajuan.status_pengajuan = "diproses" then 1 end) as diproses')
            )
            ->groupBy('beasiswa.id_beasiswa', 'beasiswa.nama_beasiswa')
            ->orderBy('total', 'desc')
            ->get();
            
        return view('admin.laporan.index', compact('stats', 'beasiswaByType', 'pengajuanByBeasiswa'));
    }

    /**
     * Export report data to Excel/PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Validate the request
        $request->validate([
            'jenis_laporan' => 'required|string|in:beasiswa,pengajuan,mahasiswa',
            'format' => 'required|string|in:excel,pdf',
            'id_jenis' => 'nullable|exists:jenis_beasiswa,id_jenis',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);
        
        $jenis = $request->jenis_laporan;
        $format = $request->format;
        $jenisBeasiswaId = $request->id_jenis;
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;
        
        $jenisBeasiswa = null;
        if ($jenisBeasiswaId) {
            $jenisBeasiswa = JenisBeasiswa::find($jenisBeasiswaId);
        }
        
        // Logic for different report types
        switch ($jenis) {
            case 'beasiswa':
                $query = Beasiswa::with('jenisBeasiswa');
                
                if ($jenisBeasiswaId) {
                    $query->where('id_jenis', $jenisBeasiswaId);
                }
                
                $data = $query->get();
                
                if ($format === 'excel') {
                    $exporter = new \App\Exports\BeasiswaExport($data, $jenisBeasiswa);
                    return $exporter->download('xlsx');
                } else {
                    $exporter = new \App\Exports\BeasiswaPdfExport($data, $jenisBeasiswa);
                    return $exporter->download();
                }
                break;
                
            case 'pengajuan':
                $query = Pengajuan::with(['beasiswa', 'mahasiswa', 'beasiswa.jenisBeasiswa']);
                
                if ($jenisBeasiswaId) {
                    $query->whereHas('beasiswa', function($q) use ($jenisBeasiswaId) {
                        $q->where('id_jenis', $jenisBeasiswaId);
                    });
                }
                
                if ($tanggalMulai) {
                    $query->where('created_at', '>=', $tanggalMulai);
                }
                
                if ($tanggalSelesai) {
                    $query->where('created_at', '<=', $tanggalSelesai . ' 23:59:59');
                }
                
                $data = $query->get();
                
                if ($format === 'excel') {
                    $exporter = new \App\Exports\PengajuanExport($data, $jenisBeasiswa, $tanggalMulai, $tanggalSelesai);
                    return $exporter->download('xlsx');
                } else {
                    $exporter = new \App\Exports\PengajuanPdfExport($data, $jenisBeasiswa, $tanggalMulai, $tanggalSelesai);
                    return $exporter->download();
                }
                break;
                
            case 'mahasiswa':
                $data = Mahasiswa::with('pengajuan.beasiswa.jenisBeasiswa')->get();
                
                if ($format === 'excel') {
                    $exporter = new \App\Exports\MahasiswaExport($data);
                    return $exporter->download('xlsx');
                } else {
                    $exporter = new \App\Exports\MahasiswaPdfExport($data);
                    return $exporter->download();
                }
                break;
                
            default:
                return redirect()->route('admin.laporan.index')
                    ->with('error', 'Jenis laporan tidak valid');
        }
    }
    
    /**
     * Show report generation form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisBeasiswas = JenisBeasiswa::all();
        return view('admin.laporan.create', compact('jenisBeasiswas'));
    }
    
    /**
     * Generate custom report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'id_jenis' => 'nullable|exists:jenis_beasiswa,id_jenis',
            'export_type' => 'nullable|in:view,excel,pdf',
        ]);
        
        $jenis = $request->jenis_laporan;
        $startDate = $request->tanggal_mulai;
        $endDate = $request->tanggal_selesai;
        $jenisBeasiswaId = $request->id_jenis;
        $exportType = $request->export_type ?? 'view'; // Default to view
        
        // Query based on the parameters
        switch ($jenis) {
            case 'pengajuan':
                $query = Pengajuan::with(['beasiswa', 'mahasiswa', 'beasiswa.jenisBeasiswa'])
                    ->when($startDate, function($q) use ($startDate) {
                        return $q->where('created_at', '>=', $startDate);
                    })
                    ->when($endDate, function($q) use ($endDate) {
                        return $q->where('created_at', '<=', $endDate . ' 23:59:59');
                    })
                    ->when($jenisBeasiswaId, function($q) use ($jenisBeasiswaId) {
                        return $q->whereHas('beasiswa', function($query) use ($jenisBeasiswaId) {
                            $query->where('id_jenis', $jenisBeasiswaId);
                        });
                    });
                break;
                
            case 'beasiswa':
                $query = Beasiswa::with('jenisBeasiswa')
                    ->when($jenisBeasiswaId, function($q) use ($jenisBeasiswaId) {
                        return $q->where('id_jenis', $jenisBeasiswaId);
                    });
                break;
                
            default:
                return redirect()->route('admin.laporan.create')
                    ->with('error', 'Jenis laporan tidak valid');
        }
        
        $results = $query->get();
        $jenisBeasiswa = $jenisBeasiswaId ? JenisBeasiswa::find($jenisBeasiswaId) : null;
        
        // Check if user wants to export directly
        if ($exportType !== 'view') {
            // Export to Excel/PDF directly
            switch ($jenis) {
                case 'pengajuan':
                    if ($exportType === 'excel') {
                        $exporter = new \App\Exports\PengajuanExport($results, $jenisBeasiswa, $startDate, $endDate);
                        return $exporter->download('xlsx');
                    } else {
                        $exporter = new \App\Exports\PengajuanPdfExport($results, $jenisBeasiswa, $startDate, $endDate);
                        return $exporter->download();
                    }
                    break;
                    
                case 'beasiswa':
                    if ($exportType === 'excel') {
                        $exporter = new \App\Exports\BeasiswaExport($results, $jenisBeasiswa);
                        return $exporter->download('xlsx');
                    } else {
                        $exporter = new \App\Exports\BeasiswaPdfExport($results, $jenisBeasiswa);
                        return $exporter->download();
                    }
                    break;
            }
        }
        
        // Otherwise, return the view
        return view('admin.laporan.show', [
            'results' => $results,
            'jenis_laporan' => $jenis,
            'tanggal_mulai' => $startDate,
            'tanggal_selesai' => $endDate,
            'jenis_beasiswa' => $jenisBeasiswa
        ]);
    }
    
    /**
     * Display the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // This could be used to show a saved report or a specific pre-generated report
        // For now, we'll redirect to the index
        return redirect()->route('admin.laporan.index');
    }
}
