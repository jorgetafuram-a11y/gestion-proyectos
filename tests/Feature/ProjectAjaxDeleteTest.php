<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;

class ProjectAjaxDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed');
    }

    public function test_admin_can_delete_project_via_ajax()
    {
        $admin = User::where('email','admin@example.com')->first() ?? User::factory()->create(['email'=>'admin@example.com','is_admin'=>true]);
        $this->actingAs($admin);

        $project = Project::create(['title'=>'Para eliminar','status'=>'en_curso']);

        $response = $this->deleteJson(route('projects.destroy', $project));
        $response->assertStatus(200)->assertJson(['message' => 'Proyecto eliminado']);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
