<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use App\Models\Project;

$project = Project::first();
if(!$project){ echo "No project\n"; exit(1); }

// Simulate request to assign student 2 as lider
$request = Request::create('/','POST', ['students' => [2 => 'lider']]);

$controller = new ProjectController();
$response = $controller->assignStudents($request, $project);

echo "Done\n";
