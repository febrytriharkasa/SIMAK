<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa_MI;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OrangTuaSeeder extends Seeder
{
    public function run(): void
    {
        $siswas = Siswa_MI::all();

        foreach ($siswas as $siswa) {
            if ($siswa->no_hp_orangtua && $siswa->email) {
                // cek kalau user belum ada
                $existingUser = User::where('email', $siswa->email)->first();
                if (!$existingUser) {
                    User::create([
                        'name' => $siswa->nama_ayah . ' & ' . $siswa->nama_ibu,
                        'email' => $siswa->email,
                        'password' => Hash::make('password123'), // default password
                        'role' => 'ortu',
                        'siswa_id' => $siswa->id,
                        'status' => 'aktif',
                    ]);
                }
            }
        }
    }
}
