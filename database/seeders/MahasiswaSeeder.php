<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Define faculty and major combinations
        $facultyMajors = [
            'Teknologi Informasi' => [
                'Teknik Informatika',
                'Sistem Informasi',
            ],
            'Ekonomika dan Bisnis' => [
                'Akuntansi',
                'Manajemen',
                'Ekonomi',
            ],
            'Teologi' => [
                'Teologi',
            ],
            'Kependidikan dan Humaniora' => [
                'Pendidikan Bahasa Inggris',
                'Pendidikan Agama',
            ],
            'Bioteknologi' => [
                'Biologi',
                'Bioteknologi',
            ],
        ];
        
        // Define class years (angkatan)
        $angkatan = ['2019', '2020', '2021', '2022', '2023'];
        
        // Define possible semesters based on angkatan
        $semesterMap = [
            '2019' => [7, 8],
            '2020' => [5, 6],
            '2021' => [3, 4],
            '2022' => [1, 2],
            '2023' => [1],
        ];
        
        // First, create some predefined mahasiswa for testing
        $mahasiswaData = [
            [
                'nama' => 'John Doe',
                'nim' => '72200421',
                'jurusan' => 'Teknik Informatika',
                'fakultas' => 'Teknologi Informasi',
                'gender' => 'Laki-laki',
                'angkatan' => '2020',
                'semester' => 6,
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
                'semester' => 6,
                'no_hp' => '081234567891',
                'alamat' => 'Jl. Affandi No. 45, Yogyakarta',
                'ipk_terakhir' => 3.85,
                'email' => '72200422@students.ukdw.ac.id',
                'password' => bcrypt('password123'),
            ],
        ];

        // Create predefined mahasiswa
        foreach ($mahasiswaData as $mahasiswa) {
            Mahasiswa::create($mahasiswa);
        }
        
        // Then generate random mahasiswa data
        $countToGenerate = 50; // Generate 50 random students
        
        // Array to keep track of used NIMs
        $usedNims = ['72200421', '72200422']; // already used in predefined data
        
        for ($i = 0; $i < $countToGenerate; $i++) {
            // Select random faculty and major
            $faculty = $faker->randomElement(array_keys($facultyMajors));
            $major = $faker->randomElement($facultyMajors[$faculty]);
            
            // Select random angkatan
            $selectedAngkatan = $faker->randomElement($angkatan);
            
            // Select appropriate semester based on angkatan
            $semester = $faker->randomElement($semesterMap[$selectedAngkatan]);
            
            // Generate a unique 8-digit NIM
            do {
                $nim = '7' . $faker->numberBetween(2000000, 2999999);
            } while (in_array($nim, $usedNims));
            $usedNims[] = $nim;
            
            // Generate realistic IPK that varies by semester
            // Higher semester usually has lower IPK variation
            $baseIpk = 2.5;
            if ($semester > 4) {
                // Senior students tend to have more stable IPKs
                $ipk = $faker->randomFloat(2, $baseIpk, 4.0);
            } else {
                // Freshman might have more varied IPKs
                $ipk = $faker->randomFloat(2, 2.0, 4.0);
            }
            
            // Round IPK to 2 decimal places
            $ipk = round($ipk, 2);
            
            // Create the mahasiswa record
            Mahasiswa::create([
                'nama' => $faker->name,
                'nim' => $nim,
                'jurusan' => $major,
                'fakultas' => $faculty,
                'gender' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'angkatan' => $selectedAngkatan,
                'semester' => $semester,
                'no_hp' => $faker->numerify('08##########'),
                'alamat' => $faker->address,
                'ipk_terakhir' => $ipk,
                'email' => $nim . '@students.ukdw.ac.id',
                'password' => bcrypt('password123'),
                'total_received_scholarship' => 0, // Will be updated by PengajuanSeeder
            ]);
        }
    }
}
