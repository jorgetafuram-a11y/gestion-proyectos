<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\View;
use App\Models\Project;

// render create
$create = View::make('projects.create')->render();
file_put_contents(__DIR__ . '/../tmp_create.html', $create);

// render edit with first project (if any)
$project = Project::first();
if($project){
  $edit = View::make('projects.edit', compact('project'))->render();
  file_put_contents(__DIR__ . '/../tmp_edit.html', $edit);
}

echo "Rendered create and edit (if project exists)";
