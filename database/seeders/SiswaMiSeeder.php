<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaMiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alamatSiswa = [
            'Jl. Sunan Ampel No.1, Desa Ampel, Kec. Ampel, RT 01/RW 01',
            'Jl. Sunan Ampel No.2, Desa Ampel, Kec. Ampel, RT 02/RW 01',
            'Jl. Sunan Ampel No.3, Desa Ampel, Kec. Ampel, RT 03/RW 01',
            'Jl. Sunan Ampel No.4, Desa Ampel, Kec. Ampel, RT 04/RW 01',
            'Jl. Sunan Ampel No.5, Desa Ampel, Kec. Ampel, RT 05/RW 01',
            'Jl. Sunan Ampel No.6, Desa Ampel, Kec. Ampel, RT 06/RW 01',
            'Jl. Sunan Ampel No.7, Desa Ampel, Kec. Ampel, RT 07/RW 01',
            'Jl. Sunan Ampel No.8, Desa Ampel, Kec. Ampel, RT 08/RW 01',
            'Jl. Sunan Ampel No.9, Desa Ampel, Kec. Ampel, RT 09/RW 01',
            'Jl. Sunan Ampel No.10, Desa Ampel, Kec. Ampel, RT 10/RW 01',
            'Jl. Sunan Ampel No.11, Desa Ampel, Kec. Ampel, RT 11/RW 01',
            'Jl. Sunan Ampel No.12, Desa Ampel, Kec. Ampel, RT 12/RW 01',
            'Jl. Sunan Ampel No.13, Desa Ampel, Kec. Ampel, RT 13/RW 01',
            'Jl. Sunan Ampel No.14, Desa Ampel, Kec. Ampel, RT 14/RW 01',
            'Jl. Sunan Ampel No.15, Desa Ampel, Kec. Ampel, RT 15/RW 01',
        ];

        $siswas = [
            ['nisn' => '20230001', 'nama' => 'Ahmad Fauzi', 'tahun' => 2018, 'nama_wali' => 'Budi Santoso', 'no_hp_wali' => '081234567890', 'kelas_id' => 1],
            ['nisn' => '20230002', 'nama' => 'Siti Aminah', 'tahun' => 2019, 'nama_wali' => 'Ani Wijaya', 'no_hp_wali' => '081298765432', 'kelas_id' => 1],
            ['nisn' => '20230003', 'nama' => 'Rizki Ramadhan', 'tahun' => 2020, 'nama_wali' => 'Hendra Pratama', 'no_hp_wali' => '081345678901', 'kelas_id' => 2],
            ['nisn' => '20230004', 'nama' => 'Dewi Lestari', 'tahun' => 2021, 'nama_wali' => 'Slamet Riyadi', 'no_hp_wali' => '081456789012', 'kelas_id' => 2],
            ['nisn' => '20230005', 'nama' => 'Fajar Nugroho', 'tahun' => 2022, 'nama_wali' => 'Indah Puspitasari', 'no_hp_wali' => '081567890123', 'kelas_id' => 3],
            ['nisn' => '20230006', 'nama' => 'Nina Marlina', 'tahun' => 2023, 'nama_wali' => 'Agus Santoso', 'no_hp_wali' => '081678901234', 'kelas_id' => 3],
            ['nisn' => '20230007', 'nama' => 'Bayu Pratama', 'tahun' => 2018, 'nama_wali' => 'Rina Kartika', 'no_hp_wali' => '081789012345', 'kelas_id' => 1],
            ['nisn' => '20230008', 'nama' => 'Rahayu Putri', 'tahun' => 2019, 'nama_wali' => 'Eko Wahyudi', 'no_hp_wali' => '081890123456', 'kelas_id' => 1],
            ['nisn' => '20230009', 'nama' => 'Hendra Wijaya', 'tahun' => 2020, 'nama_wali' => 'Sari Mulyani', 'no_hp_wali' => '081901234567', 'kelas_id' => 2],
            ['nisn' => '20230010', 'nama' => 'Tika Amelia', 'tahun' => 2021, 'nama_wali' => 'Bambang Supriyadi', 'no_hp_wali' => '081012345678', 'kelas_id' => 2],
            ['nisn' => '20230011', 'nama' => 'Rian Saputra', 'tahun' => 2022, 'nama_wali' => 'Sri Hartati', 'no_hp_wali' => '081123456789', 'kelas_id' => 3],
            ['nisn' => '20230012', 'nama' => 'Maya Anggraini', 'tahun' => 2023, 'nama_wali' => 'Yusuf Hadi', 'no_hp_wali' => '081234567891', 'kelas_id' => 3],
            ['nisn' => '20230013', 'nama' => 'Fikri Ramdani', 'tahun' => 2018, 'nama_wali' => 'Lina Marlina', 'no_hp_wali' => '081345678902', 'kelas_id' => 1],
            ['nisn' => '20230014', 'nama' => 'Putri Ayu', 'tahun' => 2019, 'nama_wali' => 'Hadi Santoso', 'no_hp_wali' => '081456789013', 'kelas_id' => 2],
            ['nisn' => '20230015', 'nama' => 'Ahmad Zaky', 'tahun' => 2020, 'nama_wali' => 'Rini Puspita', 'no_hp_wali' => '081567890124', 'kelas_id' => 3],
        ];

        foreach ($siswas as $index => $siswa) {
            DB::table('siswas_mi')->insert([
                'nisn' => $siswa['nisn'],
                'nama' => $siswa['nama'],
                'tahun' => $siswa['tahun'],
                'nama_wali' => $siswa['nama_wali'],
                'no_hp_wali' => $siswa['no_hp_wali'],
                'kelas_id' => $siswa['kelas_id'],
                'alamat_siswa' => $alamatSiswa[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
