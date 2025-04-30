<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syarat extends Model
{
    use HasFactory;

    protected $table = 'syarat';
    protected $primaryKey = 'id_syarat';
    protected $fillable = ['id_beasiswa', 'syarat_ipk', 'syarat_dokumen'];

    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class, 'id_beasiswa', 'id_beasiswa');
    }
}

