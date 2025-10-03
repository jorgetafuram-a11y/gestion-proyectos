<?php
require __DIR__ . '/../vendor/autoload.php';

echo "Requiring bootstrap/app.php to get fully configured application...\n";

/** @var \Illuminate\Foundation\Application $app */
$app = require __DIR__ . '/../bootstrap/app.php';

echo "Application obtained. Now running Kernel bootstrappers one-by-one...\n";

$bootstrappers = [
    \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
    \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
    \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
    \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
    \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
    \Illuminate\Foundation\Bootstrap\BootProviders::class,
];

foreach ($bootstrappers as $bs) {
    echo "Running: $bs\n";
    try {
        $instance = $app->make($bs);
        $instance->bootstrap($app);
        echo " -> OK\n";
    } catch (Throwable $e) {
        echo " -> Exception: " . get_class($e) . ": " . $e->getMessage() . "\n";
        echo $e->getTraceAsString() . "\n";
        break;
    }

    foreach (['config','files','hash','auth','view','blade.compiler'] as $k) {
        try {
            echo "   - $k: " . ($app->bound($k) ? 'bound' : 'not bound') . "\n";
        } catch (Throwable $e) {
            echo "   - $k: error: " . $e->getMessage() . "\n";
        }
    }
}

echo "Done.\n";
