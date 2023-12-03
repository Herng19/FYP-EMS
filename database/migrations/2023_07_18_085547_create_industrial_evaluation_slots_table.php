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
        Schema::create('industrial_evaluation_slots', function (Blueprint $table) {
            $table->id('industrial_slot_id');
            $table->foreignId('student_id')->constrained('students', 'student_id');
            $table->foreignId('booth_id')->constrained('booths', 'booth_id');
            $table->foreignId('industrial_schedule_id')->constrained('industrial_evaluation_schedules', 'industrial_schedule_id');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_evaluation_slots');
    }
};
