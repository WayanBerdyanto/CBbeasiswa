<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $mahasiswa = Auth::user(); // Karena model Mahasiswa extend Authenticatable
        return view('mahasiswa.profile', compact('mahasiswa'));
    }
}
