<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Student::updateOrCreate(['email'=>'ana.perez@example.com'], ['name' => 'Ana Perez','program' => 'Ingeniería']);
        \App\Models\Student::updateOrCreate(['email'=>'luis.gomez@example.com'], ['name' => 'Luis Gomez','program' => 'Diseño']);
        \App\Models\Student::updateOrCreate(['email'=>'maria.ruiz@example.com'], ['name' => 'María Ruiz','program' => 'Matemáticas']);
    }
}
