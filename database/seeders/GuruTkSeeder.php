<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruTkSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = [
            [
                'nama' => 'Wahyuni, S.Pd.',
                'nip' => '196603020001',
                'no_hp_guru' => '+6281234001001',
                'alamat_guru' => 'Jl. Ampel Madrasah 12',
            ],
            [
                'nama' => 'Sri Wahyuni',
                'nip' => '196603020002',
                'no_hp_guru' => '+6281234001002',
                'alamat_guru' => 'Jl. Kebon Dalem',
            ],
            [
                'nama' => 'Shava Oliviatie M.HI',
                'nip' => '196603020003',
                'no_hp_guru' => '+6281234001003',
                'alamat_guru' => '-',
            ],
            [
                'nama' => 'Nur Amalia',
                'nip' => '196603020004',
                'no_hp_guru' => '+6281234001004',
                'alamat_guru' => 'Jl. Ampel Mulia 29',
            ],
            [
                'nama' => 'Adybagus Fery',
                'nip' => '196603020005', // tidak ada data lahir
                'no_hp_guru' => '+6281234001005',
                'alamat_guru' => 'PERUM AL',
            ],
        ];

        foreach ($gurus as $guru) {
           DB::table('guru_tk')->updateOrInsert(
                ['nip' => $guru['nip']],  // kunci unik
                [
                    'nama' => $guru['nama'],
                    'no_hp_guru' => $guru['no_hp_guru'],
                    'alamat_guru' => $guru['alamat_guru'],
                    'updated_at' => now()
                ]
            );
        }
    }
}
