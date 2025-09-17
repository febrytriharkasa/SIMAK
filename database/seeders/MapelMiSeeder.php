<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelMiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mapel_mi')->insert([
            ['nama_mapel' => 'Matematika'],
            ['nama_mapel' => 'Bahasa Indonesia'],
            ['nama_mapel' => 'IPA'],
            ['nama_mapel' => 'IPS'],
            ['nama_mapel' => 'Bahasa Arab'],
            ['nama_mapel' => 'Qur\'an Hadits'],
            ['nama_mapel' => 'Fiqih'],
            ['nama_mapel' => 'Sejarah Kebudayaan Islam'],
            ['nama_mapel' => 'Akidah Akhlak'],
            ['nama_mapel' => 'PJOK'],
        ]);
    }
}
