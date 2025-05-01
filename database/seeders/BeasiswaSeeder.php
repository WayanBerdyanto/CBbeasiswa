<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beasiswaData = [
            ["nama_beasiswa" => "Beasiswa Unggulan", "id_jenis" => 1, "deskripsi" => "Diberikan kepada mahasiswa dengan prestasi akademik terbaik.", "created_at" => now(), "updated_at" => now()],
            ["nama_beasiswa" => "Beasiswa Talenta", "id_jenis" => 2, "deskripsi" => "Untuk mahasiswa yang memiliki prestasi di bidang non-akademik.", "created_at" => now(), "updated_at" => now()],
            ["nama_beasiswa" => "Beasiswa Bidikmisi", "id_jenis" => 3, "deskripsi" => "Diberikan kepada mahasiswa dari keluarga kurang mampu.", "created_at" => now(), "updated_at" => now()],
            ["nama_beasiswa" => "Beasiswa Peduli Bencana", "id_jenis" => 4, "deskripsi" => "Dikhususkan bagi mahasiswa terdampak bencana alam.", "created_at" => now(), "updated_at" => now()],
            ["nama_beasiswa" => "Beasiswa Scranton", "id_jenis" => 5, "deskripsi" => "Beasiswa bagi mahasiswa yang berprestasi dalam penelitian.", "created_at" => now(), "updated_at" => now()],
            ["nama_beasiswa" => "Beasiswa Erasmus", "id_jenis" => 6, "deskripsi" => "Beasiswa untuk mahasiswa yang ingin studi di luar negeri.", "created_at" => now(), "updated_at" => now()]
        ];

        DB::table('beasiswa')->insert($beasiswaData);
    }
}
