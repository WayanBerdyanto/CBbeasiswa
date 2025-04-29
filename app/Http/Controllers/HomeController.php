<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $beasiswa = [
            "Beasiswa Prestasi Akademik",
            "Beasiswa Prestasi Umum",
            "Beasiswa Kebutuhan",
            "Beasiswa Bencana Alam",
            "Beasiswa Scranton",
            "Beasiswa Internasional"
        ];

        // Menyesuaikan ke: resources/views/home/home.blade.php
        return view('home.home', compact('beasiswa'));
    }
}
