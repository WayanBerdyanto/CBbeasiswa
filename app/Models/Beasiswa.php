<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

    protected $table = 'beasiswa';
    protected $primaryKey = 'id_beasiswa';
    protected $fillable = ['nama_beasiswa', 'id_jenis', 'deskripsi'];

    public function jenisBeasiswa()
    {
        return $this->belongsTo(JenisBeasiswa::class, 'id_jenis', 'id_jenis');
    }

    public function syarat()
    {
        return $this->hasMany(Syarat::class, 'id_beasiswa', 'id_beasiswa');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'id_beasiswa');
    }

    public function periode()
    {
        return $this->hasMany(PeriodeBeasiswa::class, 'id_beasiswa', 'id_beasiswa');
    }
}
