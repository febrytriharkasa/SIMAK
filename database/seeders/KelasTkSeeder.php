<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KelasTk;

class KelasTkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $data = [
            ['nama_kelas' => 'Kelas A', 'tingkat' => 1],
            ['nama_kelas' => 'Kelas B', 'tingkat' => 2],
            ['nama_kelas' => 'Lulus',   'tingkat' => 3],
        ];

         foreach ($data as $kelas) {
            KelasTk::updateOrCreate(['tingkat' => $kelas['tingkat']], $kelas);
        }
    }
}
