<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas_MI;

class KelasMiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_kelas' => 'Kelas 1', 'tingkat' => 1],
            ['nama_kelas' => 'Kelas 2', 'tingkat' => 2],
            ['nama_kelas' => 'Kelas 3', 'tingkat' => 3],
            ['nama_kelas' => 'Kelas 4', 'tingkat' => 4],
            ['nama_kelas' => 'Kelas 5', 'tingkat' => 5],
            ['nama_kelas' => 'Kelas 6', 'tingkat' => 6],
            ['nama_kelas' => 'Lulus',   'tingkat' => 7],
        ];

        foreach ($data as $row) {
            Kelas_MI::firstOrCreate(
                ['tingkat' => $row['tingkat']], // kalau sudah ada, jangan duplikat
                $row
            );
        }
    }
}
