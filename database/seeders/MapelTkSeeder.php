<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MapelTkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $mapel = [
            'Nilai Agama dan Moral',
            'Mewarnai',
            'Membaca',
            'Berhitung',
        ];

        $data = [];

        foreach ($mapel as $m) {
            $data[] = [
                'nama_mapel' => $m,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('mapel_tk')->insert($data);
    }
}
