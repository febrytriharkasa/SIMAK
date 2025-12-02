<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruMiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            ['nama' => 'Bambang Widjatmuko, S.Pd', 'nip' => '198001011', 'no_hp_guru' => '081234567001', 'alamat_guru' => 'Jl. Ampel Masjid No.1, Surabaya'],
            ['nama' => 'Azizah Andzar Ridwanah, S.Pd', 'nip' => '198002022', 'no_hp_guru' => '081234567002', 'alamat_guru' => 'Jl. KH Mas Mansyur No.12, Surabaya'],
            ['nama' => 'Sri Utaminingtyas, S.Ag', 'nip' => '198003033', 'no_hp_guru' => '081234567003', 'alamat_guru' => 'Jl. Ampel Kejambon No.3, Surabaya'],
            ['nama' => 'Devri Bertha Irawan, S.Pg', 'nip' => '198004044', 'no_hp_guru' => '081234567004', 'alamat_guru' => 'Jl. Sasak Tinggi No.4, Surabaya'],
            ['nama' => 'Rahmat Hidayat, S.Pd.I', 'nip' => '198005055', 'no_hp_guru' => '081234567005', 'alamat_guru' => 'Jl. Pegirian No.5, Surabaya'],
            ['nama' => 'Nurul Aini, S.Pd', 'nip' => '198006066', 'no_hp_guru' => '081234567006', 'alamat_guru' => 'Jl. Ampel Suci No.6, Surabaya'],
            ['nama' => 'Eko Prasetyo, S.Pd', 'nip' => '198007077', 'no_hp_guru' => '081234567007', 'alamat_guru' => 'Jl. Sidotopo Lor No.7, Surabaya'],
            ['nama' => 'Yulianti, S.Pd', 'nip' => '198008088', 'no_hp_guru' => '081234567008', 'alamat_guru' => 'Jl. Kapasan No.8, Surabaya'],
            ['nama' => 'Hendra Wijaya, S.Pd', 'nip' => '198009099', 'no_hp_guru' => '081234567009', 'alamat_guru' => 'Jl. Semampir No.9, Surabaya'],
            ['nama' => 'Lestari Handayani, S.Pd', 'nip' => '198010110', 'no_hp_guru' => '081234567010', 'alamat_guru' => 'Jl. Ampel Gading No.10, Surabaya'],
        ];

        DB::table('gurus_mi')->insert($gurus);
    }
}
