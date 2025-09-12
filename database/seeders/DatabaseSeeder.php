<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // bikin role admin kalau belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // bikin user admin default
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nip' => '12345',
                'name' => 'Administrator',
                'password' => bcrypt('admin123'),
                'status' => 'approved',
                'role' => 'admin',
            ]
        );

        // kasih role admin ke user ini
        $admin->assignRole($adminRole);
    }
}
