<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
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
        $beasiswas = Beasiswa::paginate(10);
        return view('admin.beasiswa.index', compact('beasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $jenis = [
            ['beasiswa' => 'Beasiswa Prestasi Akademik'],
            ['beasiswa' => 'Beasiswa Prestasi Non Akademik'],
            ['beasiswa' => 'Beasiswa Berdasarkan Kebutuhan Ekonomi'],
            ['beasiswa' => 'Beasiswa Penelitian dan Inovasi'],
            ['beasiswa' => 'Beasiswa Pascasarjana'],
            ['beasiswa' => 'Beasiswa Internasional'],
            ['beasiswa' => 'Beasiswa Kemitraan Industri'],
        ];
        return view('admin.beasiswa.create', compact('jenis'));
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
                'jenis' => 'required',
                'deskripsi' => 'required',
            ]);

            Beasiswa::create($request->all());
            return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.beasiswa.index')->with('error', 'Beasiswa gagal ditambahkan');
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
        $beasiswa = Beasiswa::with('syarat')->findOrFail($id);

        // Statistik pengajuan (tambahkan jika relasi sudah ada)
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
        $jenis = [
            ['beasiswa' => 'Beasiswa Prestasi Akademik'],
            ['beasiswa' => 'Beasiswa Prestasi Non Akademik'],
            ['beasiswa' => 'Beasiswa Berdasarkan Kebutuhan Ekonomi'],
            ['beasiswa' => 'Beasiswa Penelitian dan Inovasi'],
            ['beasiswa' => 'Beasiswa Pascasarjana'],
            ['beasiswa' => 'Beasiswa Internasional'],
            ['beasiswa' => 'Beasiswa Kemitraan Industri'],
        ];
        $beasiswa = Beasiswa::find($id);
        return view('admin.beasiswa.edit', compact('beasiswa', 'jenis'));
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
                'jenis' => 'required',
                'deskripsi' => 'required',
            ]);

            Beasiswa::find($id)->update($request->all());
            return redirect()->route('admin.beasiswa.index')->with('success', 'Beasiswa berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->route('admin.beasiswa.index')->with('error', 'Beasiswa gagal diubah');
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
            return redirect()->route('admin.beasiswa.index')->with('error', 'Beasiswa gagal dihapus');
        }
    }
}
