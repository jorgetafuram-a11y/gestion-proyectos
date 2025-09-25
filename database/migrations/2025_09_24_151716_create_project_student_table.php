<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_student', function (Blueprint $table) {
             $table->id();
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->string('role')->nullable(); // ej. 'miembro', 'lider'
        $table->timestamps();
        $table->unique(['project_id','student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_student');
    }
};
