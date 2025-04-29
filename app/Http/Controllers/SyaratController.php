<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syarat;

class SyaratController extends Controller
{
    public function index($id_beasiswa)
    {
        $syarat = Syarat::where('id_beasiswa', $id_beasiswa)->get();
        return view('beasiswa.syarat', [
            'syarat' => $syarat,
            'id_beasiswa' => $id_beasiswa
        ]);
    }
}
