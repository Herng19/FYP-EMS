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
        Schema::create('sub_criterias', function (Blueprint $table) {
            $table->id('sub_criteria_id');
            $table->foreignId('criteria_id')->constrained('rubric_criterias', 'criteria_id')->cascadeOnDelete();
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
        Schema::dropIfExists('sub_criterias');
    }
};
