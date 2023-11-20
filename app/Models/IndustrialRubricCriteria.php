<?php

namespace App\Models;

use App\Models\IndustrialSubCriteria;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndustrialEvaluationRubric;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialRubricCriteria extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'industrial_rubric_id',
        'criteria_name',
    ];

    public function industrial_evaluation_rubric() {
        return $this->belongsTo(IndustrialEvaluationRubric::class, 'industrial_rubric_id', 'industrial_rubric_id');
    }

    public function industrial_sub_criterias() {
        return $this->hasMany(IndustrialSubCriteria::class, 'industrial_criteria_id', 'industrial_criteria_id');
    }
}
