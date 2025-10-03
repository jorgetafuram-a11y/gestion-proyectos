<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_and_update_project()
    {
        // create
        $response = $this->post(route('projects.store'), [
            'title' => 'Nuevo',
            'description' => 'Desc',
            'status' => 'en_curso'
        ]);
        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', ['title'=>'Nuevo']);

        $project = Project::first();

        // update
        $response2 = $this->put(route('projects.update', $project), [
            'title' => 'Modificado',
            'description' => 'Desc mod',
            'status' => 'finalizado'
        ]);
        $response2->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects', ['title'=>'Modificado','status'=>'finalizado']);
    }
}
