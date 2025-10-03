<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;

Route::get('/', function(){ return redirect()->route('projects.index'); });

// Public index (optional). Protect create/view/edit/assign actions behind auth
Route::resource('projects', ProjectController::class)->only(['index']);

// Make students index public but keep other student actions protected.
Route::get('students', [StudentController::class,'index'])->name('students.index');

Route::middleware('auth')->group(function () {
	// All other project actions require authentication (and will then be
	// authorized by the ProjectPolicy inside the controller methods).
	Route::resource('projects', ProjectController::class)->except(['index']);

	Route::get('projects/{project}/assign', [ProjectController::class,'assignForm'])->name('projects.assign.form');
	Route::post('projects/{project}/assign', [ProjectController::class,'assignStudents'])->name('projects.assign');
	Route::post('projects/{project}/unassign/{student}', [ProjectController::class,'unassignStudent'])->name('projects.unassign');

	Route::resource('students', StudentController::class)->except(['index']);
});

// Auth
Route::middleware('guest')->group(function(){
	Route::get('login', [AuthController::class,'showLogin'])->name('login');
	Route::post('login', [AuthController::class,'login'])->name('login.post');
	Route::get('register', [RegisterController::class,'show'])->name('register');
	Route::post('register', [RegisterController::class,'register'])->name('register.post');
	Route::get('password/reset', [PasswordResetController::class,'requestForm'])->name('password.request');
	Route::post('password/email', [PasswordResetController::class,'sendToken'])->name('password.email');
	Route::get('password/reset/{token}', [PasswordResetController::class,'showResetForm'])->name('password.reset.form');
	Route::post('password/reset', [PasswordResetController::class,'reset'])->name('password.reset');
});

Route::post('logout', [AuthController::class,'logout'])->name('logout');

// Admin routes
Route::middleware(['auth','is_admin'])->prefix('admin')->name('admin.')->group(function(){
	Route::get('users', [UsersController::class,'index'])->name('users.index');
	Route::get('users/create', [UsersController::class,'create'])->name('users.create');
	Route::post('users', [UsersController::class,'store'])->name('users.store');
	Route::get('/admin', [AdminController::class, 'index'])->middleware('can:isAdmin');
});

