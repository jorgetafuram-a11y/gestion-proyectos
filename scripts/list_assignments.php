<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('project_student')->get();
foreach($rows as $r){
    echo "project_id={$r->project_id} student_id={$r->student_id} role={$r->role}\n";
}
