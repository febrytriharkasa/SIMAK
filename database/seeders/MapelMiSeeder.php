<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MapelMiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $mapel = [
            'Pendidikan Agama Islam (PAI)',
            'Bahasa Indonesia',
            'IPA',
            'IPS',
            'Pendidikan Pancasila',
            "Matematika",
            'Seni Budaya & Prakarya',
            'Akidah Akhlak',
            'PJOK',
        ];

        $data = [];

        foreach ($mapel as $m) {
            $data[] = [
                'nama_mapel' => $m,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('mapel_mi')->insert($data);
    }
}
