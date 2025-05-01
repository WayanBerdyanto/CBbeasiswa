<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\PeriodeBeasiswa;
use Illuminate\Http\Request;

class PeriodeBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodes = PeriodeBeasiswa::with('beasiswa')->paginate(10);
        return view('admin.periode.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $beasiswas = Beasiswa::all();
        $selectedBeasiswaId = $request->query('id_beasiswa');
        
        return view('admin.periode.create', compact('beasiswas', 'selectedBeasiswaId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_beasiswa' => 'required|exists:beasiswa,id_beasiswa',
                'nama_periode' => 'required|string|max:255',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'kuota' => 'required|integer|min:0',
                'status' => 'required|in:aktif,tidak_aktif',
            ]);

            PeriodeBeasiswa::create($request->all());
            return redirect()->route('admin.periode.index')->with('success', 'Periode beasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.periode.create')->with('error', 'Periode beasiswa gagal ditambahkan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $periode = PeriodeBeasiswa::with('beasiswa')->findOrFail($id);
        
        // Get pengajuan statistics for this periode
        $periode->total_pengajuan = $periode->pengajuan()->count();
        $periode->pengajuan_diterima = $periode->pengajuan()->where('status_pengajuan', 'diterima')->count();
        $periode->pengajuan_ditolak = $periode->pengajuan()->where('status_pengajuan', 'ditolak')->count();
        $periode->pengajuan_diproses = $periode->pengajuan()->where('status_pengajuan', 'diproses')->count();
        
        return view('admin.periode.show', compact('periode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periode = PeriodeBeasiswa::findOrFail($id);
        $beasiswas = Beasiswa::all();
        return view('admin.periode.edit', compact('periode', 'beasiswas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'id_beasiswa' => 'required|exists:beasiswa,id_beasiswa',
                'nama_periode' => 'required|string|max:255',
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
                'kuota' => 'required|integer|min:0',
                'status' => 'required|in:aktif,tidak_aktif',
            ]);

            PeriodeBeasiswa::find($id)->update($request->all());
            return redirect()->route('admin.periode.index')->with('success', 'Periode beasiswa berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('admin.periode.edit', $id)->with('error', 'Periode beasiswa gagal diubah: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            PeriodeBeasiswa::find($id)->delete();
            return redirect()->route('admin.periode.index')->with('success', 'Periode beasiswa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.periode.index')->with('error', 'Periode beasiswa gagal dihapus: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the status of the specified periode.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus($id)
    {
        try {
            $periode = PeriodeBeasiswa::findOrFail($id);
            $newStatus = $periode->status === 'aktif' ? 'tidak_aktif' : 'aktif';
            
            $periode->update(['status' => $newStatus]);
            
            return redirect()->route('admin.periode.index')
                ->with('success', 'Status periode beasiswa berhasil diubah menjadi ' . 
                    ($newStatus === 'aktif' ? 'Aktif' : 'Tidak Aktif'));
        } catch (\Exception $e) {
            return redirect()->route('admin.periode.index')
                ->with('error', 'Status periode beasiswa gagal diubah: ' . $e->getMessage());
        }
    }
}
