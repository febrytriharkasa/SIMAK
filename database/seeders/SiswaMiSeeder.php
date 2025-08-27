<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SiswaMiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 15; $i++) {
            DB::table('siswas_mi')->insert([
                'nisn'        => $faker->unique()->numerify('20230###'),
                'nama'        => $faker->name,
                'tahun'       => $faker->numberBetween(2018, 2025),
                'nama_wali'   => $faker->name,
                'no_hp_wali'  => $faker->phoneNumber,
                'alamat_siswa'=> $faker->address,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
