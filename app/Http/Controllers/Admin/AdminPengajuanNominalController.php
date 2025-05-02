<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Beasiswa;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class AdminPengajuanNominalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengajuan = Pengajuan::with(['beasiswa', 'mahasiswa'])->findOrFail($id);
        return view('admin.pengajuan.nominal', compact('pengajuan'));
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
        $request->validate([
            'nominal_approved' => 'required|numeric|min:0',
            'status_pengajuan' => 'required|in:diterima,ditolak,diproses',
        ]);

        try {
            DB::beginTransaction();
            
            $pengajuan = Pengajuan::with('mahasiswa')->findOrFail($id);
            $oldStatus = $pengajuan->status_pengajuan;
            $oldNominal = $pengajuan->nominal_approved ?? 0;
            
            // Jika sebelumnya diterima, kurangi total beasiswa mahasiswa
            if ($oldStatus === 'diterima' && $oldNominal > 0) {
                $mahasiswa = $pengajuan->mahasiswa;
                $mahasiswa->total_received_scholarship -= $oldNominal;
                $mahasiswa->save();
            }
            
            // Update pengajuan
            $pengajuan->nominal_approved = $request->nominal_approved;
            $pengajuan->status_pengajuan = $request->status_pengajuan;
            $pengajuan->save();
            
            // Jika sekarang diterima, tambahkan ke total beasiswa mahasiswa
            if ($request->status_pengajuan === 'diterima') {
                $mahasiswa = $pengajuan->mahasiswa;
                $mahasiswa->total_received_scholarship += $request->nominal_approved;
                $mahasiswa->save();
            }
            
            DB::commit();
            
            return redirect()->route('admin.pengajuan.show', $id)
                ->with('success', 'Nominal beasiswa berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui nominal beasiswa: ' . $e->getMessage());
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
        //
    }

    /**
     * Set nominal default dari beasiswa
     */
    public function setDefault($id)
    {
        try {
            $pengajuan = Pengajuan::with(['beasiswa', 'mahasiswa'])->findOrFail($id);
            $beasiswa = $pengajuan->beasiswa;
            
            if (!$beasiswa) {
                return redirect()->back()->with('error', 'Beasiswa tidak ditemukan');
            }
            
            DB::beginTransaction();
            
            $oldStatus = $pengajuan->status_pengajuan;
            $oldNominal = $pengajuan->nominal_approved ?? 0;
            
            // Jika sebelumnya diterima, kurangi total beasiswa mahasiswa
            if ($oldStatus === 'diterima' && $oldNominal > 0) {
                $mahasiswa = $pengajuan->mahasiswa;
                $mahasiswa->total_received_scholarship -= $oldNominal;
                $mahasiswa->save();
            }
            
            // Set nominal default
            $pengajuan->nominal_approved = $beasiswa->nominal;
            $pengajuan->save();
            
            // Jika status diterima, tambahkan ke total beasiswa mahasiswa
            if ($pengajuan->status_pengajuan === 'diterima') {
                $mahasiswa = $pengajuan->mahasiswa;
                $mahasiswa->total_received_scholarship += $beasiswa->nominal;
                $mahasiswa->save();
            }
            
            DB::commit();
            
            return redirect()->route('admin.pengajuan.show', $id)
                ->with('success', 'Nominal beasiswa berhasil diatur ke nilai default');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengatur nominal default: ' . $e->getMessage());
        }
    }
}
