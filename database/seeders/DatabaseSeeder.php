<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(2)->create();
        $this->call(ProjectsSeeder::class);
        $this->call(StudentsSeeder::class);
        $this->call(AdminUserSeeder::class);
    $this->call(DemoUserSeeder::class);
        // link first user to first student for convenience in testing
        $firstUser = \App\Models\User::first();
        $firstStudent = \App\Models\Student::first();
        if($firstUser && $firstStudent && !$firstUser->student_id){
            $firstUser->student_id = $firstStudent->id;
            $firstUser->save();
        }
    }
}
