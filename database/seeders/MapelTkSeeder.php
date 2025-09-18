<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelTkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mapel_tk')->insert([
            ['nama_mapel' => 'Matematika'],
            ['nama_mapel' => 'Bahasa Indonesia'],
        ]);
    }
}
