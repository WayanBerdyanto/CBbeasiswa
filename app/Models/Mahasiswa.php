<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'jurusan',
        'gender',
        'angkatan',
        'syarat_lpk',
        'email',
        'password'
    ];

    protected $hidden = ['password'];

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_mahasiswa', 'id');
    }
    

}
