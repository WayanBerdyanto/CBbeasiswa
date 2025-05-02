<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syarat;
use App\Models\Beasiswa;
use App\Models\PeriodeBeasiswa;
use Illuminate\Support\Facades\Auth;

class SyaratController extends Controller
{
    public function index($id_beasiswa)
    {
        // Get the beasiswa details
        $beasiswa = Beasiswa::with('jenisBeasiswa')->findOrFail($id_beasiswa);
        
        // Get active period for this beasiswa
        $periode = PeriodeBeasiswa::where('id_beasiswa', $id_beasiswa)
            ->where('status', 'aktif')
            ->first();
        
        // Get syarat for this beasiswa
        $syarat = Syarat::where('id_beasiswa', $id_beasiswa)->get();

        // Get authenticated user's IPK (if logged in)
        $ipk_user = Auth::guard('mahasiswa')->check() ? Auth::guard('mahasiswa')->user()->ipk_terakhir : null;
        
        return view('beasiswa.syarat', [
            'syarat' => $syarat,
            'id_beasiswa' => $id_beasiswa,
            'ipk_user' => $ipk_user,
            'beasiswa' => $beasiswa,
            'periode' => $periode
        ]);
    }
}
