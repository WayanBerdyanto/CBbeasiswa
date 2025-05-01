<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenisBeasiswaData = [
            ["nama_jenis" => "Beasiswa Prestasi Akademik", "deskripsi" => "Beasiswa yang diberikan berdasarkan prestasi akademik mahasiswa.", "created_at" => now(), "updated_at" => now()],
            ["nama_jenis" => "Beasiswa Prestasi Non Akademik", "deskripsi" => "Beasiswa yang diberikan berdasarkan prestasi non-akademik seperti olahraga, seni, atau kegiatan ekstrakurikuler lainnya.", "created_at" => now(), "updated_at" => now()],
            ["nama_jenis" => "Beasiswa Kebutuhan", "deskripsi" => "Beasiswa yang diberikan kepada mahasiswa dari keluarga kurang mampu.", "created_at" => now(), "updated_at" => now()],
            ["nama_jenis" => "Beasiswa Bencana Alam", "deskripsi" => "Beasiswa khusus untuk mahasiswa terdampak bencana alam.", "created_at" => now(), "updated_at" => now()],
            ["nama_jenis" => "Beasiswa Penelitian", "deskripsi" => "Beasiswa yang diberikan untuk mendukung kegiatan penelitian mahasiswa.", "created_at" => now(), "updated_at" => now()],
            ["nama_jenis" => "Beasiswa Internasional", "deskripsi" => "Beasiswa untuk mahasiswa yang ingin melanjutkan studi di luar negeri.", "created_at" => now(), "updated_at" => now()],
            ["nama_jenis" => "Beasiswa Kemitraan Industri", "deskripsi" => "Beasiswa yang didanai oleh perusahaan atau industri.", "created_at" => now(), "updated_at" => now()]
        ];

        DB::table('jenis_beasiswa')->insert($jenisBeasiswaData);
    }
}
