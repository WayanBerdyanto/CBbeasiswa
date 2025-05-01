<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class AdminMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::paginate(10);
        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mahasiswa.create');
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
                'nama' => 'required|string|max:35',
                'nim' => 'required|string|size:8|unique:mahasiswa,nim',
                'fakultas' => 'required|string|max:35',
                'jurusan' => 'required|string|max:35',
                'angkatan' => 'required|string|max:25',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'no_hp' => 'nullable|string|max:15',
                'alamat' => 'nullable|string',
                'ipk_terakhir' => 'nullable|numeric|min:0|max:4.00',
            ]);

            // Create data with default password
            $data = $request->all();
            $data['password'] = bcrypt('mahasiswa123'); // Default password
            $data['email'] = $request->nim . '@students.ukdw.ac.id'; // Default email based on NIM
            
            // Set default values for nullable fields if not provided
            $data['no_hp'] = $request->no_hp ?? null;
            $data['alamat'] = $request->alamat ?? null;
            $data['ipk_terakhir'] = $request->ipk_terakhir ?? 0.00;

            Mahasiswa::create($data);
            return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa.create')->with('error', 'Gagal menambahkan mahasiswa: ' . $e->getMessage());
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
        $mahasiswa = Mahasiswa::with(['pengajuan', 'pengajuan.beasiswa'])
            ->withCount(['pengajuan as pengajuan_count',
                'pengajuan as pengajuan_diterima_count' => function ($query) {
                    $query->where('status_pengajuan', 'diterima');
                },
                'pengajuan as pengajuan_diproses_count' => function ($query) {
                    $query->where('status_pengajuan', 'diproses');
                },
                'pengajuan as pengajuan_ditolak_count' => function ($query) {
                    $query->where('status_pengajuan', 'ditolak');
                }
            ])
            ->findOrFail($id);
            
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
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
            $mahasiswa = Mahasiswa::findOrFail($id);
            
            $request->validate([
                'nama' => 'required|string|max:35',
                'nim' => 'required|string|size:8|unique:mahasiswa,nim,'.$id,
                'fakultas' => 'required|string|max:35',
                'jurusan' => 'required|string|max:35',
                'angkatan' => 'required|string|max:25',
                'gender' => 'required|in:Laki-laki,Perempuan',
                'no_hp' => 'nullable|string|max:15',
                'alamat' => 'nullable|string',
                'ipk_terakhir' => 'nullable|numeric|min:0|max:4.00',
            ]);

            $data = $request->all();
            
            // Set default values for nullable fields if not provided
            $data['no_hp'] = $request->no_hp ?? null;
            $data['alamat'] = $request->alamat ?? null;
            $data['ipk_terakhir'] = $request->ipk_terakhir ?? 0.00;

            $mahasiswa->update($data);
            return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.mahasiswa.edit', $id)->with('error', 'Gagal memperbarui mahasiswa: ' . $e->getMessage());
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
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
