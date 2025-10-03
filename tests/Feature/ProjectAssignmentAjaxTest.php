<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Student;

class ProjectAssignmentAjaxTest extends TestCase
{
    use RefreshDatabase;

    public function test_assign_students_via_json_and_unassign()
    {
        $project = Project::create(['title'=>'T','status'=>'en_curso']);
        $s1 = Student::create(['name'=>'A','email'=>'a@example.com','program'=>'X']);
        $s2 = Student::create(['name'=>'B','email'=>'b@example.com','program'=>'Y']);

        $response = $this->postJson(route('projects.assign', $project), [
            'students' => [ $s1->id => 'miembro', $s2->id => 'lider' ]
        ]);
        $response->assertStatus(200)->assertJsonStructure(['message','data']);

        $this->assertDatabaseHas('project_student', ['project_id'=>$project->id,'student_id'=>$s1->id]);

        $resp2 = $this->postJson(route('projects.unassign', ['project'=>$project->id,'student'=>$s1->id]));
        $resp2->assertStatus(200)->assertJson(['student_id'=>$s1->id]);

        $this->assertDatabaseMissing('project_student', ['project_id'=>$project->id,'student_id'=>$s1->id]);
    }
}
