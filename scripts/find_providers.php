<?php
function findProviders($dir) {
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($it as $file) {
        if ($file->isFile() && $file->getFilename() === 'composer.json') {
            $path = $file->getPathname();
            $json = json_decode(file_get_contents($path), true);
            if (json_last_error() !== JSON_ERROR_NONE) continue;
            if (isset($json['extra']['laravel']['providers']) && is_array($json['extra']['laravel']['providers'])) {
                echo "Found in: $path\n";
                foreach ($json['extra']['laravel']['providers'] as $p) {
                    echo "  - $p\n";
                }
            }
        }
    }
}

findProviders(__DIR__ . '/../vendor');

echo "\nAlso checking root composer.json...\n";
$root = json_decode(file_get_contents(__DIR__ . '/../composer.json'), true);
if (isset($root['extra']['laravel']['providers'])) {
    foreach ($root['extra']['laravel']['providers'] as $p) echo "root: $p\n";
}

?>
