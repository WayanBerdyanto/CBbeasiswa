<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class AdminPengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::paginate(10);
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function show($id)
    {
        $pengajuan = Pengajuan::find($id);
        $beasiswa = Beasiswa::find($pengajuan->id_beasiswa);
        $mahasiswa = Mahasiswa::find($pengajuan->id_mahasiswa);
        return view('admin.pengajuan.show', compact('pengajuan', 'beasiswa', 'mahasiswa'));
    }

    public function filter(Request $request)
    {
        $query = Pengajuan::query()->with(['beasiswa', 'mahasiswa']);
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status_pengajuan', $request->status);
        }
        
        // Filter by beasiswa
        if ($request->has('beasiswa') && $request->beasiswa != '') {
            $query->where('id_beasiswa', $request->beasiswa);
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
        
        return view('admin.pengajuan.index', compact('pengajuans', 'beasiswas', 'mahasiswas'));
    }

    public function create(Request $request)
    {
        $beasiswas = Beasiswa::all();
        $mahasiswas = Mahasiswa::all();
        $selectedMahasiswaId = $request->query('mahasiswa_id');
        
        return view('admin.pengajuan.create', compact('beasiswas', 'mahasiswas', 'selectedMahasiswaId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_beasiswa' => 'required',
            'nama_mahasiswa' => 'required',
            'status_pengajuan' => 'required',
            'tgl_pengajuan' => 'required',
            'alasan_pengajuan' => 'required',
        ]);

        try {
            $beasiswa = Beasiswa::find($request->nama_beasiswa);
            $mahasiswa = Mahasiswa::find($request->nama_mahasiswa);

            DB::beginTransaction();
            $pengajuan = new Pengajuan();
            $pengajuan->id_beasiswa = $beasiswa->id_beasiswa;
            $pengajuan->id_mahasiswa = $mahasiswa->id;
            $pengajuan->status_pengajuan = $request->status_pengajuan;
            $pengajuan->tgl_pengajuan = $request->tgl_pengajuan;
            $pengajuan->alasan_pengajuan = $request->alasan_pengajuan;
            $pengajuan->save();
            DB::commit();
            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pengajuan.create')->with('error', 'Gagal menambahkan pengajuan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pengajuan = Pengajuan::find($id);
        $beasiswas = Beasiswa::all();
        $mahasiswas = Mahasiswa::all();
        return view('admin.pengajuan.edit', compact('pengajuan', 'beasiswas', 'mahasiswas'));
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
            ]);

            $pengajuan = Pengajuan::find($id);

            if (!$pengajuan) {
                return redirect()->route('admin.pengajuan.index')->with('error', 'Pengajuan tidak ditemukan');
            }

            DB::beginTransaction();
            $pengajuan->id_beasiswa = $request->nama_beasiswa;
            $pengajuan->id_mahasiswa = $request->nama_mahasiswa;
            $pengajuan->status_pengajuan = $request->status_pengajuan;
            $pengajuan->tgl_pengajuan = $request->tgl_pengajuan;
            $pengajuan->alasan_pengajuan = $request->alasan_pengajuan;
            $pengajuan->save();
            DB::commit();

            return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pengajuan.edit', $id)->with('error', 'Gagal memperbarui pengajuan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::find($id);
        $pengajuan->delete();
        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil dihapus');
    }
}
