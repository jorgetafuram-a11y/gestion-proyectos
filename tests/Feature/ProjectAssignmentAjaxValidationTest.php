<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Student;

class ProjectAssignmentAjaxValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_invalid_role_returns_validation_error()
    {
        $project = Project::create(['title'=>'Proyecto X','status'=>'en_curso']);
        $s = Student::create(['name'=>'Alumno','email'=>'a@x.com','program'=>'P']);

        $resp = $this->postJson(route('projects.assign', $project), [
            'students' => [ $s->id => 'invalid_role' ]
        ]);

        $resp->assertStatus(422)->assertJsonValidationErrors(['students.'.$s->id]);
    }
}
