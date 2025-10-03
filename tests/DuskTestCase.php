<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class DuskTestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Prepare for Dusk test execution.
     */
    public static function prepare(): void
    {
        // Dusk installs chromedriver via artisan command; keep empty for CI customization
    }

    /**
     * Create the application.
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
