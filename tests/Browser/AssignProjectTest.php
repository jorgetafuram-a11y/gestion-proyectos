<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssignProjectTest extends DuskTestCase
{
    /**
     * Placeholder Dusk test for assignment UI.
     * To run: install and configure Laravel Dusk, then run php artisan dusk
     */
    public function test_placeholder()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Gestión Proyectos');
        });
    }
}
