<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use App\Models\Student;

echo "Projects: " . Project::count() . PHP_EOL;
echo "Students: " . Student::count() . PHP_EOL;
