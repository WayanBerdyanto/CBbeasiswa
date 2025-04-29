<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswaData = [
            [
                'nama' => 'John Doe',
                'nim' => '72200600',
                'jurusan' => 'Teknik Informatika',
                'gender' => 'Laki-laki',
                'angkatan' => '2020',
                'syarat_lpk' => '1',
                'email' => 'john@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'nama' => 'Jane Doe',
                'nim' => '72200601',
                'jurusan' => 'Teknik Informatika',
                'gender' => 'Perempuan',
                'angkatan' => '2020',
                'syarat_lpk' => '1',
                'email' => 'jane@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'nama' => 'Gilbert',
                'nim' => '72200602',
                'jurusan' => 'Teknik Informatika',
                'gender' => 'Laki-laki',
                'angkatan' => '2020',
                'syarat_lpk' => '1',
                'email' => 'gilbert@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'nama' => 'Marcel',
                'nim' => '72200603',
                'jurusan' => 'Teknik Informatika',
                'gender' => 'Laki-laki',
                'angkatan' => '2020',
                'syarat_lpk' => '1',
                'email' => 'marcel@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'nama' => 'Rafael',
                'nim' => '72200604',
                'jurusan' => 'Teknik Informatika',
                'gender' => 'Laki-laki',
                'angkatan' => '2020',
                'syarat_lpk' => '1',
                'email' => 'rafael@gmail.com',
                'password' => bcrypt('password'),
            ],
            [
                'nama' => 'Samuel',
                'nim' => '72200605',
                'jurusan' => 'Teknik Informatika',
                'gender' => 'Laki-laki',
                'angkatan' => '2020',
                'syarat_lpk' => '1',
                'email' => 'samuel@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($mahasiswaData as $mahasiswa) {
            Mahasiswa::create($mahasiswa);
        }
    }
}
