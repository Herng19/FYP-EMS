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
        Schema::create('rubrics', function (Blueprint $table) {
            $table->id('rubric_id');
            $table->foreignId('research_group_id')->constrained('research_groups', 'research_group_id');
            $table->string('rubric_name');
            $table->string('evaluation_type');
            $table->integer('psm_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubrics');
    }
};
