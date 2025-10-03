<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Foundation\Application;

echo "Creating application builder...\n";
$builder = Application::configure(basePath: dirname(__DIR__));

echo "Building application instance...\n";
$app = $builder->create();

echo "Application instance created. Inspecting core aliases and deferred services...\n";

$keys = ['config', 'files', 'hash', 'auth', 'view', 'router'];

foreach ($keys as $k) {
    try {
        $bound = $app->bound($k) ? 'bound' : 'not bound';
        echo "- $k: $bound" . PHP_EOL;
    } catch (Throwable $e) {
        echo "- $k: error: " . $e->getMessage() . PHP_EOL;
    }
}

// get deferred services from the application instance
try {
    $deferred = method_exists($app, 'getDeferredServices') ? $app->getDeferredServices() : [];
    echo "Deferred services count: " . count($deferred) . PHP_EOL;
} catch (Throwable $e) {
    echo "Deferred services: error: " . $e->getMessage() . PHP_EOL;
}

echo "Registered providers (loadedProviders keys):\n";
try {
    $loaded = method_exists($app, 'getLoadedProviders') ? $app->getLoadedProviders() : [];
    foreach (array_keys($loaded) as $prov) {
        echo " - $prov\n";
    }
} catch (Throwable $e) {
    echo "Providers: error: " . $e->getMessage() . PHP_EOL;
}

echo "All done.\n";
