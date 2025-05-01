<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisBeasiswa;
use Illuminate\Http\Request;

class AdminJenisBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisBeasiswas = JenisBeasiswa::withCount('beasiswas')->paginate(10);
        return view('admin.jenis-beasiswa.index', compact('jenisBeasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $beasiswaId = request('beasiswa_id');
        return view('admin.jenis-beasiswa.create', compact('beasiswaId'));
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
                'nama_jenis' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
            ]);

            $jenisBeasiswa = JenisBeasiswa::create($request->all());
            
            // Check if request comes from beasiswa create/edit page
            if ($request->has('beasiswa_id')) {
                // If beasiswa_id is 'new', we're creating a new beasiswa, so redirect to beasiswa create page
                if ($request->beasiswa_id === 'new') {
                    return redirect()->route('admin.beasiswa.create')
                        ->with('success', 'Jenis beasiswa berhasil ditambahkan')
                        ->with('selected_jenis_id', $jenisBeasiswa->id_jenis);
                }
                
                // Otherwise, we're editing an existing beasiswa
                return redirect()->route('admin.beasiswa.edit', $request->beasiswa_id)
                    ->with('success', 'Jenis beasiswa berhasil ditambahkan');
            }
            
            return redirect()->route('admin.jenis-beasiswa.index')->with('success', 'Jenis beasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.jenis-beasiswa.create')->with('error', 'Gagal menambahkan jenis beasiswa: ' . $e->getMessage());
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
        $jenisBeasiswa = JenisBeasiswa::with('beasiswas')->findOrFail($id);
        return view('admin.jenis-beasiswa.show', compact('jenisBeasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jenisBeasiswa = JenisBeasiswa::findOrFail($id);
        $beasiswaId = request('beasiswa_id');
        
        return view('admin.jenis-beasiswa.edit', compact('jenisBeasiswa', 'beasiswaId'));
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
                'nama_jenis' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
            ]);

            $jenisBeasiswa = JenisBeasiswa::findOrFail($id);
            $jenisBeasiswa->update($request->all());
            
            // Check if request comes from beasiswa edit page
            if ($request->has('beasiswa_id')) {
                return redirect()->route('admin.beasiswa.edit', $request->beasiswa_id)
                    ->with('success', 'Jenis beasiswa berhasil diperbarui');
            }
            
            return redirect()->route('admin.jenis-beasiswa.index')->with('success', 'Jenis beasiswa berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.jenis-beasiswa.edit', $id)->with('error', 'Gagal memperbarui jenis beasiswa: ' . $e->getMessage());
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
            $jenisBeasiswa = JenisBeasiswa::findOrFail($id);
            
            // Cek apakah ada beasiswa yang menggunakan jenis ini
            if ($jenisBeasiswa->beasiswas()->count() > 0) {
                return redirect()->route('admin.jenis-beasiswa.index')
                    ->with('error', 'Tidak dapat menghapus jenis beasiswa karena masih digunakan oleh beberapa beasiswa');
            }
            
            $jenisBeasiswa->delete();
            return redirect()->route('admin.jenis-beasiswa.index')->with('success', 'Jenis beasiswa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.jenis-beasiswa.index')->with('error', 'Gagal menghapus jenis beasiswa: ' . $e->getMessage());
        }
    }
} 