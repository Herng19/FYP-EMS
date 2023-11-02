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
        Schema::create('slots', function (Blueprint $table) {
            $table->id('slot_id');
            $table->foreignId('student_id')->constrained('students', 'student_id');
            $table->foreignId('venue_id')->nullable()->constrained('venues', 'venue_id');
            $table->foreignId('booth_id')->nullable()->constrained('booths', 'booth_id');
            $table->foreignId('schedule_id')->constrained('evaluation_schedules', 'schedule_id');
            $table->timestamp('start_time')->nullable(); 
            $table->timestamp('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
