<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use App\Models\PeriodeBeasiswa;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with(['beasiswa.jenisBeasiswa', 'mahasiswa', 'periode'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::with(['beasiswa.jenisBeasiswa', 'mahasiswa', 'periode', 'dokumen'])->find($id);
        $beasiswa = Beasiswa::with('jenisBeasiswa')->find($pengajuan->id_beasiswa);
        $mahasiswa = Mahasiswa::find($pengajuan->id_mahasiswa);
        return view('admin.pengajuan.show', compact('pengajuan', 'beasiswa', 'mahasiswa'));
    }

    public function filter(Request $request)
    {
        $query = Pengajuan::query()->with(['beasiswa.jenisBeasiswa', 'mahasiswa', 'periode']);
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pengajuan', $request->status);
        }
        
        // Filter by beasiswa
        if ($request->has('beasiswa') && $request->beasiswa != '') {
            $query->where('id_beasiswa', $request->beasiswa);
        }
        
        // Filter by periode
        if ($request->has('periode') && $request->periode != '') {
            $query->where('id_periode', $request->periode);
        }
        
        // Filter by mahasiswa
        if ($request->has('mahasiswa') && $request->mahasiswa != '') {
            $query->where('id_mahasiswa', $request->mahasiswa);
        }
        
        // Filter by date range
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('tgl_pengajuan', '>=', $request->tanggal_mulai);
        }
        
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir != '') {
            $query->whereDate('tgl_pengajuan', '<=', $request->tanggal_akhir);
        }
        
        // Search by keyword (mahasiswa name or beasiswa name)
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;
            $query->whereHas('mahasiswa', function($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%");
            })->orWhereHas('beasiswa', function($q) use ($keyword) {
                $q->where('nama_beasiswa', 'like', "%{$keyword}%");
            });
        }
        
        $pengajuans = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        // Get beasiswas and mahasiswas for filter options
        $beasiswas = Beasiswa::all();
        $mahasiswas = Mahasiswa::all();
        $periodes = PeriodeBeasiswa::with('beasiswa')->where('status', 'aktif')->get();
        
        return view('admin.pengajuan.index', compact('pengajuans', 'beasiswas', 'mahasiswas', 'periodes'));
    }

    public function create(Request $request)
    {
        $beasiswas = Beasiswa::all();
        $mahasiswas = Mahasiswa::all();
        $periodes = PeriodeBeasiswa::with('beasiswa')->get();
        $selectedMahasiswaId = $request->query('mahasiswa_id');
        
        return view('admin.pengajuan.create', compact('beasiswas', 'mahasiswas', 'periodes', 'selectedMahasiswaId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_beasiswa' => 'required',
            'nama_mahasiswa' => 'required',
            'status_pengajuan' => 'required',
            'tgl_pengajuan' => 'required',
            'alasan_pengajuan' => 'required',
            'id_periode' => 'nullable|exists:periode_beasiswa,id_periode',
            'ipk' => 'required|numeric|min:0|max:4.00',
        ]);

        try {
            $beasiswa = Beasiswa::find($request->nama_beasiswa);
            $mahasiswa = Mahasiswa::find($request->nama_mahasiswa);

            // Jika IPK kosong atau tidak valid, gunakan IPK terakhir mahasiswa
            $ipk = $request->ipk;
            if (!$ipk || $ipk <= 0 || $ipk > 4.00) {
                $ipk = $mahasiswa->ipk_terakhir ?? 0;
            }

            DB::beginTransaction();
            $pengajuan = new Pengajuan();
            $pengajuan->id_beasiswa = $beasiswa->id_beasiswa;
            $pengajuan->id_mahasiswa = $mahasiswa->id;
            $pengajuan->id_periode = $request->id_periode;
            $pengajuan->status_pengajuan = $request->status_pengajuan;
            $pengajuan->nominal_approved = $beasiswa->nominal; // Set default nominal dari beasiswa
            $pengajuan->tgl_pengajuan = $request->tgl_pengajuan;
            $pengajuan->alasan_pengajuan = $request->alasan_pengajuan;
            $pengajuan->ipk = $ipk;
            $pengajuan->save();
            
            // Log untuk debugging
            \Illuminate\Support\Facades\Log::info('Admin: New pengajuan created', [
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'id_beasiswa' => $pengajuan->id_beasiswa,
                'nominal_approved' => $pengajuan->nominal_approved,
                'ipk' => $pengajuan->ipk,
                'ipk_mahasiswa' => $mahasiswa->ipk_terakhir
            ]);
            
            DB::commit();
            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Admin: Error creating pengajuan', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);
            return redirect()->route('admin.pengajuan.create')->with('error', 'Gagal menambahkan pengajuan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pengajuan = Pengajuan::with(['beasiswa', 'mahasiswa', 'periode'])->find($id);
        $beasiswas = Beasiswa::all();
        $mahasiswas = Mahasiswa::all();
        $periodes = PeriodeBeasiswa::with('beasiswa')->get();
        return view('admin.pengajuan.edit', compact('pengajuan', 'beasiswas', 'mahasiswas', 'periodes'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_beasiswa' => 'required',
                'nama_mahasiswa' => 'required',
                'status_pengajuan' => 'required',
                'tgl_pengajuan' => 'required',
                'alasan_pengajuan' => 'required',
                'id_periode' => 'nullable|exists:periode_beasiswa,id_periode',
                'ipk' => 'required|numeric|min:0|max:4.00',
            ]);

            $pengajuan = Pengajuan::find($id);

            if (!$pengajuan) {
                return redirect()->route('admin.pengajuan.index')->with('error', 'Pengajuan tidak ditemukan');
            }
            
            $beasiswa = Beasiswa::find($request->nama_beasiswa);
            $mahasiswa = Mahasiswa::find($request->nama_mahasiswa);
            
            // Jika IPK kosong atau tidak valid, gunakan IPK terakhir mahasiswa
            $ipk = $request->ipk;
            if (!$ipk || $ipk <= 0 || $ipk > 4.00) {
                $ipk = $mahasiswa->ipk_terakhir ?? 0;
            }

            DB::beginTransaction();
            $pengajuan->id_beasiswa = $request->nama_beasiswa;
            $pengajuan->id_mahasiswa = $request->nama_mahasiswa;
            $pengajuan->id_periode = $request->id_periode;
            $pengajuan->status_pengajuan = $request->status_pengajuan;
            
            // Jika beasiswa berubah, update nominal_approved ke default beasiswa baru
            if ($pengajuan->getOriginal('id_beasiswa') != $request->nama_beasiswa) {
                $pengajuan->nominal_approved = $beasiswa->nominal;
            }
            
            $pengajuan->tgl_pengajuan = $request->tgl_pengajuan;
            $pengajuan->alasan_pengajuan = $request->alasan_pengajuan;
            $pengajuan->ipk = $ipk;
            $pengajuan->save();
            
            // Log untuk debugging
            \Illuminate\Support\Facades\Log::info('Admin: Pengajuan updated', [
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'id_beasiswa' => $pengajuan->id_beasiswa,
                'nominal_approved' => $pengajuan->nominal_approved,
                'ipk' => $pengajuan->ipk,
                'ipk_mahasiswa' => $mahasiswa->ipk_terakhir
            ]);
            
            DB::commit();

            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Admin: Error updating pengajuan', [
                'id' => $id,
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);
            return redirect()->route('admin.pengajuan.edit', $id)->with('error', 'Gagal memperbarui pengajuan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::find($id);
        $pengajuan->delete();
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil dihapus');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pengajuan' => 'required|in:diterima,ditolak,diproses',
        ]);

        try {
            $pengajuan = Pengajuan::find($id);
            $pengajuan->status_pengajuan = $request->status_pengajuan;
            $pengajuan->save();
            
            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pengajuan: ' . $e->getMessage());
        }
    }

    /**
     * Generate and display PDF for a student's application
     */
    public function viewPdf($id)
    {
        // Find the application
        $pengajuan = Pengajuan::with(['beasiswa', 'beasiswa.jenisBeasiswa', 'dokumen', 'mahasiswa'])
            ->findOrFail($id);
        
        // Prepare data for PDF
        $data = [
            'title' => 'Laporan Pengajuan Beasiswa',
            'date' => date('d/m/Y H:i:s'),
            'mahasiswa' => $pengajuan->mahasiswa,
            'pengajuanList' => collect([$pengajuan]), // Wrap in collection to match view expectations
            'count' => 1,
            'isAdmin' => true
        ];
        
        // Generate PDF
        $pdf = PDF::loadView('mahasiswa.laporan.pdf', $data);
        $filename = 'laporan_beasiswa_' . $pengajuan->mahasiswa->nim . '_' . $pengajuan->id_pengajuan . '.pdf';
        
        // Stream the PDF (display in browser)
        return $pdf->stream($filename);
    }
}
