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
        Schema::create('industrial_evaluations', function (Blueprint $table) {
            $table->id('industrial_evaluation_id');
            $table->foreignId('student_id')->constrained('students', 'student_id');
            $table->integer('marks');
            $table->string('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_evaluations');
    }
};
