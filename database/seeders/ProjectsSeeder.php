<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Project::create([
            'title' => 'Proyecto Alpha',
            'description' => 'Proyecto de prueba Alpha',
            'status' => 'en_curso',
        ]);

        \App\Models\Project::create([
            'title' => 'Proyecto Beta',
            'description' => 'Proyecto de prueba Beta',
            'status' => 'finalizado',
        ]);
    }
}
