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
        Schema::create('criteria_marks', function (Blueprint $table) {
            $table->id('criteria_mark_id');
            $table->foreignId('sub_criteria_id')->constrained('sub_criterias', 'sub_criteria_id');
            $table->foreignId('evaluation_id')->constrained('evaluations', 'evaluation_id');
            $table->integer('scale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_marks');
    }
};
