<?php
require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Foundation\Application;

$builder = Application::configure(basePath: dirname(__DIR__));
$app = $builder->create();

echo "Inspecting container internals...\n";

$r = new ReflectionClass($app);

$props = ['aliases', 'bindings', 'instances'];
foreach ($props as $p) {
    if ($r->hasProperty($p)) {
        $prop = $r->getProperty($p);
        $prop->setAccessible(true);
        $val = $prop->getValue($app);
        echo "\n=== $p (" . count($val) . ") ===\n";
        foreach (array_slice(array_keys($val), 0, 50) as $k) {
            echo " - $k\n";
        }
    } else {
        echo "Property $p not present.\n";
    }
}

echo "\nLoaded providers:\n";
if (method_exists($app, 'getLoadedProviders')) {
    foreach (array_keys($app->getLoadedProviders()) as $prov) {
        echo " - $prov\n";
    }
}

echo "Done.\n";
