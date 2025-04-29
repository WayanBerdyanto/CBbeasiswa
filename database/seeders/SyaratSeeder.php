<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyaratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $syaratData = [
            ["id_beasiswa" => 1, "syarat_ipk" => 3.50, "syarat_dokumen" => "Transkrip Nilai, Sertifikat Prestasi"],
            ["id_beasiswa" => 2, "syarat_ipk" => 3.30, "syarat_dokumen" => "Transkrip Nilai, Bukti Prestasi"],
            ["id_beasiswa" => 3, "syarat_ipk" => 3.00, "syarat_dokumen" => "KTP, Kartu Keluarga, Surat Keterangan Tidak Mampu"],
            ["id_beasiswa" => 4, "syarat_ipk" => 2.75, "syarat_dokumen" => "Surat Keterangan Korban Bencana, Transkrip Nilai"],
            ["id_beasiswa" => 5, "syarat_ipk" => 3.40, "syarat_dokumen" => "Transkrip Nilai, Surat Rekomendasi"],
            ["id_beasiswa" => 6, "syarat_ipk" => 3.60, "syarat_dokumen" => "Paspor, Transkrip Nilai, Surat Penerimaan Universitas"]
        ];

        DB::table('syarat')->insert($syaratData);
    }
}
