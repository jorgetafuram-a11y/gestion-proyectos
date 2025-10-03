<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Student;

class ProjectAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Run the database seeders to create projects, students and admin
        $this->artisan('migrate');
        $this->artisan('db:seed');
    }

    public function test_guest_is_redirected_from_protected_project_show()
    {
        $project = Project::first();
        $response = $this->get(route('projects.show', $project));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_non_admin_can_view_and_create_project()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // view existing project
        $project = Project::first();
        $res = $this->get(route('projects.show', $project));
        $res->assertStatus(200);

        // create new project should be forbidden for non-admins
        $post = $this->post(route('projects.store'), [
            'title' => 'Prueba creación',
            'description' => 'Creado por test',
            'status' => 'en_curso',
        ]);
        $post->assertStatus(403);
    }

    public function test_admin_can_update_and_assign()
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('secret'), 'is_admin' => true]
        );
        $this->actingAs($admin);

        $project = Project::first();
        $res = $this->get(route('projects.edit', $project));
        $res->assertStatus(200);

        // update
        $update = $this->put(route('projects.update', $project), [
            'title' => $project->title . ' updated',
            'description' => $project->description,
            'status' => $project->status,
        ]);
        $update->assertRedirect(route('projects.index'));

        // assign a student
        $student = Student::first() ?? Student::factory()->create(['name'=>'Alumno Test','email'=>'alumno@test.com']);
        $assign = $this->post(route('projects.assign', $project), [
            'students' => [ $student->id => 'miembro' ]
        ]);
        $assign->assertRedirect(route('projects.show', $project));
        $this->assertDatabaseHas('project_student', ['project_id' => $project->id, 'student_id' => $student->id]);
    }

    public function test_student_linked_user_can_view_assigned_project_but_not_unassigned()
    {
        // create two projects and one student, attach student to first project
        $projectA = Project::first();
        $projectB = Project::create(['title'=>'Otro proyecto','status'=>'en_curso']);

        $student = Student::first() ?? Student::create(['name'=>'Alumno Test','email'=>'alumno@test.com','program'=>'Prueba']);
        // attach student to projectA
        $projectA->students()->attach($student->id, ['role' => 'miembro']);

        // create a user linked to that student
        $user = User::factory()->create(['student_id' => $student->id]);
        $this->actingAs($user);

        // should be allowed to view projectA
        $resA = $this->get(route('projects.show', $projectA));
        $resA->assertStatus(200);

        // should be forbidden to view projectB (not assigned)
        $resB = $this->get(route('projects.show', $projectB));
        $resB->assertStatus(403);
    }
}
