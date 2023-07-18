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
            $table->foreignId('industrial_criteria_id')->constrained('industrial_rubric_criterias', 'industrial_criteria_id');
            $table->string('sub_criteria_name');
            $table->string('sub_criteria_description');
            $table->string('co_level');
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
