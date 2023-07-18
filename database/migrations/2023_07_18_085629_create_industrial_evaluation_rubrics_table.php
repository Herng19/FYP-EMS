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
        Schema::create('industrial_evaluation_rubrics', function (Blueprint $table) {
            $table->id('industrial_rubric_id');
            $table->foreignId('research_group_id')->constrained('research_groups', 'research_group_id');
            $table->string('rubric_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industrial_evaluation_rubrics');
    }
};
