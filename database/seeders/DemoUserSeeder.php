<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // Demo non-admin user
        User::updateOrCreate([
            'email' => 'demo@example.com'
        ], [
            'name' => 'Demo User',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        // Admin user (also ensure AdminUserSeeder remains compatible)
        User::updateOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('SuperSecret123!'),
            'is_admin' => true,
        ]);
    }
}
