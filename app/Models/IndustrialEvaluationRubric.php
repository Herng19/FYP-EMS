<?php

namespace App\Models;

use App\Models\ResearchGroup;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndustrialRubricCriteria;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialEvaluationRubric extends Model
{
    use HasFactory;

    protected $fillable = [
        'research_group_id', 
        'rubric_name', 
    ];

    protected $primaryKey = 'industrial_rubric_id';

    public function industrial_rubric_criterias() {
        return $this->hasMany(IndustrialRubricCriteria::class, 'industrial_rubric_id', 'industrial_rubric_id');
    }

    public function research_group() {
        return $this->belongsTo(ResearchGroup::class, 'research_group_id', 'research_group_id');
    }
}
