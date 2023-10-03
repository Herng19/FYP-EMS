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
        Schema::create('industrial_criteria_scales', function (Blueprint $table) {
            $table->id('industrial_criteria_scale_id');
            $table->foreignId('industrial_sub_criteria_id')->constrained('industrial_sub_criterias', 'industrial_sub_criteria_id')->cascadeOnDelete();
            $table->integer('scale_level');
            $table->string('scale_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_criteria_scales');
    }
};
