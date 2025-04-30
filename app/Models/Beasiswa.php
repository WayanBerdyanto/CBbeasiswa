<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

    protected $table = 'beasiswa';
    protected $primaryKey = 'id_beasiswa';
    protected $fillable = ['nama_beasiswa', 'jenis', 'deskripsi'];

    public function syarat()
    {
        return $this->hasMany(Syarat::class, 'id_beasiswa', 'id_beasiswa');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_beasiswa');
    }
}
