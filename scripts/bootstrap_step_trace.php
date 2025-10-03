<?php
require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Foundation\Bootstrap\RegisterProviders;

echo "Building application builder...\n";
$builder = Application::configure(basePath: dirname(__DIR__));
$app = $builder->create();

$bootstrappers = [
    \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
    \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
    \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
    \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
    \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
    \Illuminate\Foundation\Bootstrap\BootProviders::class,
];

foreach ($bootstrappers as $bs) {
    echo "Running bootstrapper: $bs\n";
    try {
        $instance = new $bs();
        $instance->bootstrap($app);
        echo " -> OK\n";
        // after each step, check a few important bindings
        foreach (['config','files','hash','auth','view'] as $k) {
            echo "   - $k: " . ($app->bound($k) ? 'bound' : 'not bound') . "\n";
        }
    } catch (Throwable $e) {
        echo " -> Exception: " . get_class($e) . ": " . $e->getMessage() . "\n";
        echo $e->getTraceAsString() . "\n";
        break;
    }
}

echo "Done.\n";
