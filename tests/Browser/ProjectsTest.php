<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

class ProjectsTest extends DuskTestCase
{
    public function test_projects_index_is_accessible()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/projects')
                    ->assertSee('Proyectos');
        });
    }
}
