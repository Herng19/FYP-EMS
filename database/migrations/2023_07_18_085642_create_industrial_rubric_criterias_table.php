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
        Schema::create('industrial_rubric_criterias', function (Blueprint $table) {
            $table->id('industrial_criteria_id');
            $table->foreignId('industrial_rubric_id')->constrained('industrial_evaluation_rubrics', 'industrial_rubric_id');
            $table->string('criteria_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_rubric_criterias');
    }
};
