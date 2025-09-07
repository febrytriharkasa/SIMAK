<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruTkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            ['nama' => 'Ahmad Fauzi', 'nip' => '19780101', 'mapel' => 'Matematika', 'no_hp_guru' => '081234567890', 'alamat_guru' => 'Jl. Sunan Ampel No.1, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Siti Aminah', 'nip' => '19800202', 'mapel' => 'Bahasa Indonesia', 'no_hp_guru' => '081234567891', 'alamat_guru' => 'Jl. Sunan Ampel No.2, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Rizki Ramadhan', 'nip' => '19810303', 'mapel' => 'IPA', 'no_hp_guru' => '081234567892', 'alamat_guru' => 'Jl. Sunan Ampel No.3, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Dewi Lestari', 'nip' => '19820404', 'mapel' => 'IPS', 'no_hp_guru' => '081234567893', 'alamat_guru' => 'Jl. Sunan Ampel No.4, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Fajar Nugroho', 'nip' => '19830505', 'mapel' => 'Pendidikan Jasmani', 'no_hp_guru' => '081234567894', 'alamat_guru' => 'Jl. Sunan Ampel No.5, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Nina Marlina', 'nip' => '19840606', 'mapel' => 'Seni Budaya', 'no_hp_guru' => '081234567895', 'alamat_guru' => 'Jl. Sunan Ampel No.6, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Bayu Pratama', 'nip' => '19850707', 'mapel' => 'Bahasa Inggris', 'no_hp_guru' => '081234567896', 'alamat_guru' => 'Jl. Sunan Ampel No.7, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Rahayu Putri', 'nip' => '19860808', 'mapel' => 'Matematika', 'no_hp_guru' => '081234567897', 'alamat_guru' => 'Jl. Sunan Ampel No.8, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Hendra Wijaya', 'nip' => '19870909', 'mapel' => 'Bahasa Indonesia', 'no_hp_guru' => '081234567898', 'alamat_guru' => 'Jl. Sunan Ampel No.9, Desa Ampel, Kec. Ampel, Surabaya'],
            ['nama' => 'Tika Amelia', 'nip' => '19881010', 'mapel' => 'IPA', 'no_hp_guru' => '081234567899', 'alamat_guru' => 'Jl. Sunan Ampel No.10, Desa Ampel, Kec. Ampel, Surabaya'],
        ];

        foreach ($gurus as $guru) {
            DB::table('guru_tk')->insert([
                'nama' => $guru['nama'],
                'nip' => $guru['nip'],
                'mapel' => $guru['mapel'],
                'no_hp_guru' => $guru['no_hp_guru'],
                'alamat_guru' => $guru['alamat_guru'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
