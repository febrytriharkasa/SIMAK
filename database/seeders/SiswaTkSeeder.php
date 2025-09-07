<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaTkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alamatSiswa = [
            'Jl. Cempaka No.1, Desa Ampel, Kec. Ampel, RT 01/RW 01',
            'Jl. Cempaka No.2, Desa Ampel, Kec. Ampel, RT 02/RW 01',
            'Jl. Cempaka No.3, Desa Ampel, Kec. Ampel, RT 03/RW 01',
            'Jl. Cempaka No.4, Desa Ampel, Kec. Ampel, RT 04/RW 01',
            'Jl. Cempaka No.5, Desa Ampel, Kec. Ampel, RT 05/RW 01',
            'Jl. Cempaka No.6, Desa Ampel, Kec. Ampel, RT 06/RW 01',
            'Jl. Cempaka No.7, Desa Ampel, Kec. Ampel, RT 07/RW 01',
            'Jl. Cempaka No.8, Desa Ampel, Kec. Ampel, RT 08/RW 01',
            'Jl. Cempaka No.9, Desa Ampel, Kec. Ampel, RT 09/RW 01',
            'Jl. Cempaka No.10, Desa Ampel, Kec. Ampel, RT 10/RW 01',
        ];

        $siswas = [
            ['id_tk' => 'TK001', 'nama' => 'Alya Putri', 'tahun' => 2020, 'nama_wali' => 'Rini Susanti', 'no_hp_wali' => '081234567800', 'kelas_id' => 1],
            ['id_tk' => 'TK002', 'nama' => 'Rafa Dwi', 'tahun' => 2020, 'nama_wali' => 'Budi Santoso', 'no_hp_wali' => '081234567801', 'kelas_id' => 1],
            ['id_tk' => 'TK003', 'nama' => 'Nabila Ayu', 'tahun' => 2021, 'nama_wali' => 'Ani Wijaya', 'no_hp_wali' => '081234567802', 'kelas_id' => 2],
            ['id_tk' => 'TK004', 'nama' => 'Fahri Ramadhan', 'tahun' => 2021, 'nama_wali' => 'Hendra Pratama', 'no_hp_wali' => '081234567803', 'kelas_id' => 2],
            ['id_tk' => 'TK005', 'nama' => 'Salsabila', 'tahun' => 2022, 'nama_wali' => 'Slamet Riyadi', 'no_hp_wali' => '081234567804', 'kelas_id' => 3],
            ['id_tk' => 'TK006', 'nama' => 'Zahra Putri', 'tahun' => 2022, 'nama_wali' => 'Indah Puspitasari', 'no_hp_wali' => '081234567805', 'kelas_id' => 3],
            ['id_tk' => 'TK007', 'nama' => 'Alif Ramdani', 'tahun' => 2020, 'nama_wali' => 'Agus Santoso', 'no_hp_wali' => '081234567806', 'kelas_id' => 1],
            ['id_tk' => 'TK008', 'nama' => 'Dian Lestari', 'tahun' => 2021, 'nama_wali' => 'Rina Kartika', 'no_hp_wali' => '081234567807', 'kelas_id' => 2],
            ['id_tk' => 'TK009', 'nama' => 'Fikri Ahmad', 'tahun' => 2022, 'nama_wali' => 'Eko Wahyudi', 'no_hp_wali' => '081234567808', 'kelas_id' => 3],
            ['id_tk' => 'TK010', 'nama' => 'Putri Amalia', 'tahun' => 2022, 'nama_wali' => 'Sari Mulyani', 'no_hp_wali' => '081234567809', 'kelas_id' => 1],
        ];

        foreach ($siswas as $index => $siswa) {
            DB::table('siswa_tk')->insert([
                'id_tk' => $siswa['id_tk'],
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
