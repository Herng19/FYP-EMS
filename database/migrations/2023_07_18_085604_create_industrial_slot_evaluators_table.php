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
        Schema::create('industrial_slot_evaluators', function (Blueprint $table) {
            $table->id('slot_evaluator_id');
            $table->foreignId('industrial_slot_id')->constrained('industrial_evaluation_slots', 'industrial_slot_id');
            $table->foreignId('industrial_evaluator_id')->constrained('industrial_evaluators', 'industrial_evaluator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_slot_evaluators');
    }
};
