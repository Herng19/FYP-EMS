<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IndustrialEvaluationRubric;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResearchGroup extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function students() {
        return $this->hasMany(Student::class, 'research_group_id', 'research_group_id');
    }

    public function lecturers() {
        return $this->hasMany(Student::class, 'research_group_id', 'research_group_id');
    }

    public function rubrics() {
        return $this->hasMany(Rubric::class, 'research_group_id', 'research_group_id');
    }

    public function industrial_rubrics() {
        return $this->hasMany(IndustrialEvaluationRubric::class, 'research_group_id', 'research_group_id');
    }
}
