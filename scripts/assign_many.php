<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;

$projects = Project::all();
if($projects->isEmpty()){
    echo "No hay proyectos\n"; exit(1);
}

// Assign student 1 and 3 to project 1, student 2 to project 2
$p1 = $projects->first();
$p2 = $projects->count() > 1 ? $projects[1] : null;

$p1->students()->syncWithoutDetaching([1 => ['role' => 'miembro'], 3 => ['role' => 'miembro']]);
if($p2){
    $p2->students()->syncWithoutDetaching([2 => ['role' => 'lider']]);
}

echo "Asignaciones realizadas.\n";
