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
        Schema::create('industrial_sub_criterias', function (Blueprint $table) {
            $table->id('industrial_sub_criteria_id');
            $table->foreignId('industrial_criteria_id')->constrained('industrial_rubric_criterias', 'industrial_criteria_id')->cascadeOnDelete();
            $table->string('sub_criteria_name');
            $table->string('sub_criteria_description');
            $table->foreignId('industrial_co_level_id')->constrained('industrial_co_levels', 'industrial_co_level_id')->cascadeOnDelete();
            $table->integer('weightage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_sub_criterias');
    }
};
