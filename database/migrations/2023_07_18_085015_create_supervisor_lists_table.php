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
        Schema::create('supervisor_lists', function (Blueprint $table) {
            $table->id('supervisor_list_id');
            $table->foreignId('student_id')->constrained('students', 'student_id');
            $table->foreignId('lecturer_id')->constrained('lecturers', 'lecturer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisor_lists');
    }
};
