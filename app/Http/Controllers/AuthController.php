<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        // Menyesuaikan ke file: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::guard('mahasiswa')->logout();
        return redirect('/login');
    }
}
