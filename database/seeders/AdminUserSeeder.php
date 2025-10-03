<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@example.com'
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('SuperSecret123!'),
            'is_admin' => true,
        ]);
    }
}
