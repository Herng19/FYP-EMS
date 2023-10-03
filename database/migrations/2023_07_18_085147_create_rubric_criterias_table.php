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
        Schema::create('rubric_criterias', function (Blueprint $table) {
            $table->id('criteria_id');
            $table->foreignId('rubric_id')->constrained('rubrics', 'rubric_id')->cascadeOnDelete();
            $table->string('criteria_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubric_criterias');
    }
};
