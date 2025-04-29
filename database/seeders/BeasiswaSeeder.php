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
            ["nama_beasiswa" => "Beasiswa Unggulan", "jenis" => "Beasiswa Prestasi Akademik", "deskripsi" => "Diberikan kepada mahasiswa dengan prestasi akademik terbaik."],
            ["nama_beasiswa" => "Beasiswa Talenta", "jenis" => "Beasiswa Prestasi Umum", "deskripsi" => "Untuk mahasiswa yang memiliki prestasi di bidang non-akademik."],
            ["nama_beasiswa" => "Beasiswa Bidikmisi", "jenis" => "Beasiswa Kebutuhan", "deskripsi" => "Diberikan kepada mahasiswa dari keluarga kurang mampu."],
            ["nama_beasiswa" => "Beasiswa Peduli Bencana", "jenis" => "Beasiswa Bencana Alam", "deskripsi" => "Dikhususkan bagi mahasiswa terdampak bencana alam."],
            ["nama_beasiswa" => "Beasiswa Scranton", "jenis" => "Beasiswa Scranton", "deskripsi" => "Beasiswa bagi mahasiswi yang berprestasi."],
            ["nama_beasiswa" => "Beasiswa Erasmus", "jenis" => "Beasiswa Internasional", "deskripsi" => "Beasiswa untuk mahasiswa yang ingin studi di luar negeri."]
        ];

        DB::table('beasiswa')->insert($beasiswaData);
    }
}
