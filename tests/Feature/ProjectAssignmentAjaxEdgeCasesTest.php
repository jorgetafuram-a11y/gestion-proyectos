<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\Student;

class ProjectAssignmentAjaxEdgeCasesTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_payload_clears_assignments()
    {
        $project = Project::create(['title'=>'P1','status'=>'en_curso']);
        $s = Student::create(['name'=>'X','email'=>'x@e.com','program'=>'Z']);
        $project->students()->attach($s->id, ['role'=>'miembro']);

        $resp = $this->postJson(route('projects.assign', $project), []);
        $resp->assertStatus(200);
        $this->assertDatabaseMissing('project_student', ['project_id'=>$project->id,'student_id'=>$s->id]);
    }

    public function test_nonexistent_student_id_is_ignored()
    {
        $project = Project::create(['title'=>'P2','status'=>'en_curso']);
        $resp = $this->postJson(route('projects.assign', $project), ['students'=> [9999 => 'miembro']]);
        $resp->assertStatus(200);
        // no rows should exist
        $this->assertDatabaseCount('project_student', 0);
    }

    public function test_mass_assign_many_students()
    {
        $project = Project::create(['title'=>'P3','status'=>'en_curso']);
        $students = [];
        for($i=0;$i<30;$i++){
            $s = Student::create(['name'=>'S'.$i,'email'=>'s'.$i.'@x.test','program'=>'Prog']);
            $students[$s->id] = ($i%5===0)?'lider':'miembro';
        }
        $resp = $this->postJson(route('projects.assign', $project), ['students'=>$students]);
        $resp->assertStatus(200);
        $this->assertDatabaseCount('project_student', 30);
    }
}
