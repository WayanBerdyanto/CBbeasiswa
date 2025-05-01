<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBeasiswa extends Model
{
    use HasFactory;

    protected $table = 'jenis_beasiswa';
    protected $primaryKey = 'id_jenis';
    
    protected $fillable = [
        'nama_jenis',
        'deskripsi'
    ];

    public function beasiswas()
    {
        return $this->hasMany(Beasiswa::class, 'id_jenis', 'id_jenis');
    }
} 