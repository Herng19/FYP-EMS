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
        Schema::create('criteria_scales', function (Blueprint $table) {
            $table->id('scale_id');
            $table->foreignId('sub_criteria_id')->constrained('sub_criterias', 'sub_criteria_id')->cascadeOnDelete();
            $table->integer('scale_level'); 
            $table->string('scale_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_scales');
    }
};
