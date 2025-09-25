<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;

Route::get('/', function(){ return redirect()->route('projects.index'); });

Route::resource('projects', ProjectController::class);
Route::get('projects/{project}/assign', [ProjectController::class,'assignForm'])->name('projects.assign.form');
Route::post('projects/{project}/assign', [ProjectController::class,'assignStudents'])->name('projects.assign');

Route::resource('students', StudentController::class);

