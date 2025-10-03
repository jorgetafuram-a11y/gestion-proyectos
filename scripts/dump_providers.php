<?php
if (! function_exists('env')) {
    function env($key, $default = null) {
        $v = getenv($key);
        return $v !== false ? $v : $default;
    }
}

$c = require __DIR__.'/../config/app.php';
foreach ($c['providers'] as $i => $p) {
    echo "[$i] ";
    if (is_string($p)) echo $p . PHP_EOL; else var_export($p);
}
