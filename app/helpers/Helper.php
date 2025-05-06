<?php

use App\Models\Mahasiswa;
use App\Models\Pengajuan;


if (!function_exists('getCountPengajuan')) {
    function getCountPengajuan()
    {
        return Pengajuan::where('status_pengajuan', 'diproses')->count();
    }
}

function getMahasiswa(){
    $countMahasiswa = Mahasiswa::count();

    return $countMahasiswa;
}
