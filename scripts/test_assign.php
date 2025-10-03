<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Project;
use App\Models\Student;

$project = Project::first();
$student = Student::first();

if(!$project || !$student){
    echo "No hay proyectos o estudiantes.\n";
    exit(1);
}

$project->students()->syncWithoutDetaching([$student->id => ['role' => 'miembro']]);

echo "Asignado estudiante {$student->id} al proyecto {$project->id}\n";
