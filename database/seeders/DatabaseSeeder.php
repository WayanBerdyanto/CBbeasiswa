<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MahasiswaSeeder::class,
            JenisBeasiswaSeeder::class,
            BeasiswaSeeder::class,
            SyaratSeeder::class,
            PeriodeBeasiswaSeeder::class,
            PengajuanSeeder::class,
            DokumenSeeder::class,
        ]);
    }
}
