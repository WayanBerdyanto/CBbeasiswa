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
                'nim' => '72200421',
                'jurusan' => 'Teknik Informatika',
                'fakultas' => 'Teknologi Informasi',
                'gender' => 'Laki-laki',
                'angkatan' => '2020',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Paingan No. 123, Yogyakarta',
                'ipk_terakhir' => 3.75,
                'email' => '72200421@students.ukdw.ac.id',
                'password' => bcrypt('password123'),
            ],
            [
                'nama' => 'Jane Smith',
                'nim' => '72200422',
                'jurusan' => 'Sistem Informasi',
                'fakultas' => 'Teknologi Informasi',
                'gender' => 'Perempuan',
                'angkatan' => '2020',
                'no_hp' => '081234567891',
                'alamat' => 'Jl. Affandi No. 45, Yogyakarta',
                'ipk_terakhir' => 3.85,
                'email' => '72200422@students.ukdw.ac.id',
                'password' => bcrypt('password123'),
            ],
            [
                'nama' => 'Michael Brown',
                'nim' => '72200423',
                'jurusan' => 'Akuntansi',
                'fakultas' => 'Ekonomika dan Bisnis',
                'gender' => 'Laki-laki',
                'angkatan' => '2021',
                'no_hp' => '081234567892',
                'alamat' => 'Jl. Kaliurang Km. 5, Yogyakarta',
                'ipk_terakhir' => 3.60,
                'email' => '72200423@students.ukdw.ac.id',
                'password' => bcrypt('password123'),
            ],
            [
                'nama' => 'Emily Johnson',
                'nim' => '72200424',
                'jurusan' => 'Manajemen',
                'fakultas' => 'Ekonomika dan Bisnis',
                'gender' => 'Perempuan',
                'angkatan' => '2021',
                'no_hp' => '081234567893',
                'alamat' => 'Jl. Seturan No. 78, Yogyakarta',
                'ipk_terakhir' => 3.90,
                'email' => '72200424@students.ukdw.ac.id',
                'password' => bcrypt('password123'),
            ],
            [
                'nama' => 'David Wilson',
                'nim' => '72200425',
                'jurusan' => 'Biologi',
                'fakultas' => 'Sains dan Teknologi',
                'gender' => 'Laki-laki',
                'angkatan' => '2022',
                'no_hp' => '081234567894',
                'alamat' => 'Jl. Gejayan No. 112, Yogyakarta',
                'ipk_terakhir' => 3.45,
                'email' => '72200425@students.ukdw.ac.id',
                'password' => bcrypt('password123'),
            ],
        ];

        foreach ($mahasiswaData as $mahasiswa) {
            Mahasiswa::create($mahasiswa);
        }
    }
}
