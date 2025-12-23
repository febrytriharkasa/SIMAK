<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TahunAjaranMI;

class TahunAjaranMISeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_tahun'      => '2023/2024',
                'tanggal_mulai'   => '2023-07-17',
                'tanggal_selesai' => '2024-06-22',
                'aktif'           => false,
            ],
            [
                'nama_tahun'      => '2024/2025',
                'tanggal_mulai'   => '2024-07-15',
                'tanggal_selesai' => '2025-06-21',
                'aktif'           => true, // Tahun ajaran aktif saat ini
            ],
            [
                'nama_tahun'      => '2025/2026',
                'tanggal_mulai'   => '2025-07-14',
                'tanggal_selesai' => '2026-06-20',
                'aktif'           => false,
            ],
        ];

        foreach ($data as $item) {
            TahunAjaranMI::create($item);
        }
    }
}