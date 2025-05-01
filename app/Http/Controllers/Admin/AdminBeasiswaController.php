<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\JenisBeasiswa;
use Illuminate\Http\Request;

class AdminBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beasiswas = Beasiswa::with('jenisBeasiswa')->paginate(10);
        return view('admin.beasiswa.index', compact('beasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisBeasiswas = JenisBeasiswa::all();
        return view('admin.beasiswa.create', compact('jenisBeasiswas'));
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
                'nama_beasiswa' => 'required',
                'id_jenis' => 'required|exists:jenis_beasiswa,id_jenis',
                'deskripsi' => 'required',
            ]);

            Beasiswa::create($request->all());
            return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.beasiswa.create')->with('error', 'Beasiswa gagal ditambahkan: ' . $e->getMessage());
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
        $beasiswa = Beasiswa::with(['syarat', 'jenisBeasiswa'])->findOrFail($id);

        // Statistik pengajuan
        $beasiswa->pengajuan_count = $beasiswa->pengajuan()->count();
        $beasiswa->pengajuan_diterima_count = $beasiswa->pengajuan()->where('status_pengajuan', 'diterima')->count();
        $beasiswa->pengajuan_diproses_count = $beasiswa->pengajuan()->where('status_pengajuan', 'diproses')->count();
        $beasiswa->pengajuan_ditolak_count = $beasiswa->pengajuan()->where('status_pengajuan', 'ditolak')->count();

        return view('admin.beasiswa.show', compact('beasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jenisBeasiswas = JenisBeasiswa::all();
        $beasiswa = Beasiswa::findOrFail($id);
        return view('admin.beasiswa.edit', compact('beasiswa', 'jenisBeasiswas'));
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
                'nama_beasiswa' => 'required',
                'id_jenis' => 'required|exists:jenis_beasiswa,id_jenis',
                'deskripsi' => 'required',
            ]);

            Beasiswa::find($id)->update($request->all());
            return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('admin.beasiswa.edit', $id)->with('error', 'Beasiswa gagal diubah: ' . $e->getMessage());
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
            Beasiswa::find($id)->delete();
            return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.beasiswa.index')->with('error', 'Beasiswa gagal dihapus: ' . $e->getMessage());
        }
    }
}
