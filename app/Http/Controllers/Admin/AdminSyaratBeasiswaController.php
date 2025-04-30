<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Syarat;
use App\Models\Beasiswa;
use Illuminate\Support\Facades\DB;

class AdminSyaratBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $syarat = Syarat::with('beasiswa')->paginate(10);
        return view('admin.syarat.index', compact('syarat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $beasiswa = Beasiswa::all();
        return view('admin.syarat.create', compact('beasiswa'));
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
                'id_beasiswa' => 'required',
                'syarat_ipk' => 'required',
                'syarat_dokumen' => 'required',
            ]); 
            
            DB::beginTransaction();
            $syarat = new Syarat();
            $syarat->id_beasiswa = $request->id_beasiswa;
            $syarat->syarat_ipk = $request->syarat_ipk;
            $syarat->syarat_dokumen = $request->syarat_dokumen;
            $syarat->save();
            DB::commit();
            return redirect()->route('admin.syarat.index')->with('success', 'Syarat berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.syarat.create')->with('error', 'Gagal menambahkan syarat: ' . $e->getMessage());
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
        $syarat = Syarat::with('beasiswa')->find($id);
        return view('admin.syarat.show', compact('syarat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $syarat = Syarat::with('beasiswa')->find($id);
        $beasiswa = Beasiswa::all();
        return view('admin.syarat.edit', compact('syarat', 'beasiswa'));
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
                'id_beasiswa' => 'required',
                'syarat_ipk' => 'required',
                'syarat_dokumen' => 'required',
            ]);

            DB::beginTransaction();
            $syarat = Syarat::find($id);
            $syarat->id_beasiswa = $request->id_beasiswa;
            $syarat->syarat_ipk = $request->syarat_ipk;
            $syarat->syarat_dokumen = $request->syarat_dokumen;
            $syarat->save();
            DB::commit();
            return redirect()->route('admin.syarat.index')->with('success', 'Syarat berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.syarat.edit', $id)->with('error', 'Gagal mengubah syarat: ' . $e->getMessage());
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
        $syarat = Syarat::find($id);
        $syarat->delete();
        return redirect()->route('admin.syarat.index')->with('success', 'Syarat berhasil dihapus');
    }
}
