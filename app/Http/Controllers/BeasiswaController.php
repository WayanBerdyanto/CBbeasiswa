<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beasiswa;

class BeasiswaController extends Controller
{
    public function index()
    {
        // Ambil semua data beasiswa dari database
        $beasiswa = Beasiswa::all();

        // Kirim data ke view: resources/views/beasiswa/beasiswa.blade.php
        return view('beasiswa.beasiswa', compact('beasiswa'));
    }
}
