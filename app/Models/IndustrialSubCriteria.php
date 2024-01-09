<?php

namespace App\Models;

use App\Models\IndustrialCoLevel;
use App\Models\IndustrialCriteriaScale;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndustrialRubricCriteria;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialSubCriteria extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'industrial_criteria_id',
        'sub_criteria_name',
        'sub_criteria_description',
        'industrial_co_level_id',
        'weightage', 
    ];

    public function industrial_rubric_criteria() {
        return $this->belongsTo(IndustrialRubricCriteria::class, 'industrial_criteria_id', 'industrial_criteria_id');
    }

    public function industrial_criteria_scales() {
        return $this->hasMany(IndustrialCriteriaScale::class, 'industrial_sub_criteria_id', 'industrial_sub_criteria_id');
    }

    public function industrial_criteria_marks() {
        return $this->hasMany(IndustrialCriteriaMark::class, 'industrial_sub_criteria_id', 'industrial_sub_criteria_id');
    }

    public function industrial_co_level() {
        return $this->belongsTo(IndustrialCoLevel::class, 'industrial_co_level_id', 'industrial_co_level_id');
    }
}
