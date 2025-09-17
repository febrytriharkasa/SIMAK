<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat role
        $adminRole   = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $guruTkRole  = Role::firstOrCreate(['name' => 'guru_tk', 'guard_name' => 'web']);
        $guruMiRole  = Role::firstOrCreate(['name' => 'guru_mi', 'guard_name' => 'web']);

        // Buat user admin
         $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nip' => '12345',
                'name' => 'Administrator',
                'password' => bcrypt('admin123'),
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        // Buat user guru TK
        $guruTk = User::firstOrCreate(
            ['email' => 'guru_tk@example.com'],
            [
                'nip' => '54321',
                'name' => 'Guru TK',
                'password' => Hash::make('password123'),
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );
        $guruTk->assignRole($guruTkRole);

        // Buat user guru MI
        $guruMi = User::firstOrCreate(
            ['email' => 'guru_mi@example.com'],
            [
                'nip' => '67890',
                'name' => 'Guru MI',
                'password' => Hash::make('password123'),
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );
        $guruMi->assignRole($guruMiRole);

        $this->call([
            KelasMiSeeder::class,
            MapelMiSeeder::class,
            KelasTkSeeder::class,
        ]);
    }
}
