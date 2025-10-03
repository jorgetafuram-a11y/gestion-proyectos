<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Student;

class ProjectAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_assign_and_unassign_students()
    {
        // create project and students
        $project = Project::create(['title'=>'T1','status'=>'en_curso']);
        $s1 = Student::create(['name'=>'A','email'=>'a@example.com','program'=>'X']);
        $s2 = Student::create(['name'=>'B','email'=>'b@example.com','program'=>'Y']);

        // assign students via POST
        $response = $this->post(route('projects.assign', $project), [
            'students' => [
                $s1->id => 'miembro',
                $s2->id => 'lider',
            ]
        ]);

        $response->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseHas('project_student', ['project_id'=>$project->id, 'student_id'=>$s1->id, 'role'=>'miembro']);
        $this->assertDatabaseHas('project_student', ['project_id'=>$project->id, 'student_id'=>$s2->id, 'role'=>'lider']);

        // unassign one
        $response2 = $this->post(route('projects.unassign', ['project'=>$project->id,'student'=>$s1->id]));
        $response2->assertRedirect(route('projects.show', $project));

        $this->assertDatabaseMissing('project_student', ['project_id'=>$project->id, 'student_id'=>$s1->id]);
        $this->assertDatabaseHas('project_student', ['project_id'=>$project->id, 'student_id'=>$s2->id]);
    }
}
