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
            ['nama' => 'Ahmad Fauzi',      'nip' => '198001011', 'mapel' => 'Matematika',  'no_hp_guru' => '081234567001', 'alamat_guru' => 'Jl. Melati No.1'],
            ['nama' => 'Siti Aminah',      'nip' => '198002022', 'mapel' => 'Bahasa Indonesia', 'no_hp_guru' => '081234567002', 'alamat_guru' => 'Jl. Mawar No.2'],
            ['nama' => 'Budi Santoso',     'nip' => '198003033', 'mapel' => 'IPA',         'no_hp_guru' => '081234567003', 'alamat_guru' => 'Jl. Anggrek No.3'],
            ['nama' => 'Dewi Lestari',     'nip' => '198004044', 'mapel' => 'IPS',         'no_hp_guru' => '081234567004', 'alamat_guru' => 'Jl. Kenanga No.4'],
            ['nama' => 'Rahmat Hidayat',   'nip' => '198005055', 'mapel' => 'PKN',         'no_hp_guru' => '081234567005', 'alamat_guru' => 'Jl. Dahlia No.5'],
            ['nama' => 'Nurul Aini',       'nip' => '198006066', 'mapel' => 'Bahasa Arab', 'no_hp_guru' => '081234567006', 'alamat_guru' => 'Jl. Flamboyan No.6'],
            ['nama' => 'Eko Prasetyo',     'nip' => '198007077', 'mapel' => 'Matematika',  'no_hp_guru' => '081234567007', 'alamat_guru' => 'Jl. Teratai No.7'],
            ['nama' => 'Yulianti',         'nip' => '198008088', 'mapel' => 'Bahasa Inggris', 'no_hp_guru' => '081234567008', 'alamat_guru' => 'Jl. Melur No.8'],
            ['nama' => 'Hendra Wijaya',    'nip' => '198009099', 'mapel' => 'IPA',         'no_hp_guru' => '081234567009', 'alamat_guru' => 'Jl. Cempaka No.9'],
            ['nama' => 'Lestari Handayani','nip' => '198010110', 'mapel' => 'IPS',         'no_hp_guru' => '081234567010', 'alamat_guru' => 'Jl. Nusa Indah No.10'],
            ['nama' => 'Andi Saputra',     'nip' => '198011111', 'mapel' => 'Seni Budaya', 'no_hp_guru' => '081234567011', 'alamat_guru' => 'Jl. Kamboja No.11'],
            ['nama' => 'Fitriani',         'nip' => '198012122', 'mapel' => 'PJOK',        'no_hp_guru' => '081234567012', 'alamat_guru' => 'Jl. Bougenville No.12'],
            ['nama' => 'Rizky Ramadhan',   'nip' => '198013133', 'mapel' => 'Agama Islam', 'no_hp_guru' => '081234567013', 'alamat_guru' => 'Jl. Angsana No.13'],
            ['nama' => 'Maya Sari',        'nip' => '198014144', 'mapel' => 'Bahasa Indonesia', 'no_hp_guru' => '081234567014', 'alamat_guru' => 'Jl. Cemara No.14'],
            ['nama' => 'Fajar Nugroho',    'nip' => '198015155', 'mapel' => 'Matematika',  'no_hp_guru' => '081234567015', 'alamat_guru' => 'Jl. Akasia No.15'],
        ];

        DB::table('gurus_mi')->insert($gurus);
    }
}
