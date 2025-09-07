<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $guruTkRole = Role::firstOrCreate(['name' => 'guru_tk', 'guard_name' => 'web']);
        $guruMiRole = Role::firstOrCreate(['name' => 'guru_mi', 'guard_name' => 'web']);

        // Buat user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin Super',
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        // Buat user guru TK
        $guruTk = User::firstOrCreate(
            ['email' => 'guru_tk@sekolah.com'],
            [
                'name' => 'Guru TK',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        $guruTk->assignRole($guruTkRole);

        // Buat user guru MI
        $guruMi = User::firstOrCreate(
            ['email' => 'guru_mi@sekolah.com'],
            [
                'name' => 'Guru MI',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ]
        );
        $guruMi->assignRole($guruMiRole);

        $this->call([
            GuruMiSeeder::class,
        ]);

        $this->call([
            SiswaMiSeeder::class,
        ]);
        
        $this->call([
            KelasMiSeeder::class,
        ]);

        $this->call([
            KelasTkSeeder::class,
        ]);
    }
}
