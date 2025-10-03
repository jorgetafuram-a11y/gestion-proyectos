<?php
require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Foundation\Application;

try {
    $app = Application::configure(__DIR__ . '/..');
    echo "Application builder created.\n";

    // Attempt to build the application fully
    $builtApp = $app->create();
    echo "Application instance created.\n";

    $keys = ['hash', 'files', 'config'];
    foreach ($keys as $k) {
        try {
            $res = $builtApp->make($k);
            echo "Resolved [$k]: ";
            if (is_object($res)) echo get_class($res) . "\n"; else var_export($res);
        } catch (Throwable $e) {
            echo "Failed to resolve [$k]: " . get_class($e) . " - " . $e->getMessage() . "\n";
            echo $e->getTraceAsString() . "\n";
        }
    }
} catch (Throwable $e) {
    echo "Exception during bootstrap: " . get_class($e) . " - " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
