<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $mahasiswa = Auth::user(); // Karena model Mahasiswa extend Authenticatable
        return view('mahasiswa.profile', compact('mahasiswa'));
    }

    public function edit()
    {
        $mahasiswa = Auth::user(); // Karena model Mahasiswa extend Authenticatable
        return view('mahasiswa.formUpdate', compact('mahasiswa'));
    }

    public function update(Request $request)
    {
        $mahasiswa = Auth::user(); // Karena model Mahasiswa extend Authenticatable
        $mahasiswa->update($request->all());
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }

    public function editPassword()
    {
        $mahasiswa = Auth::user(); // Karena model Mahasiswa extend Authenticatable
        return view('mahasiswa.edit-password', compact('mahasiswa'));
    }

    public function updatePassword(Request $request)
    {
        $mahasiswa = Auth::user(); // Karena model Mahasiswa extend Authenticatable
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $mahasiswa->update(['password' => bcrypt($request->password)]);
        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }
}
