<?php

namespace App\Models;

use App\Models\COLevel;
use App\Models\CriteriaMark;
use App\Models\CriteriaScale;
use App\Models\RubricCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteria_id',
        'sub_criteria_name',
        'sub_criteria_description',
        'co_level_id', 
        'weightage', 
    ];

    public $timestamps = false;

    public function criteria() {
        return $this->belongsTo(RubricCriteria::class, 'criteria_id', 'criteria_id');
    }

    public function criteria_scales() {
        return $this->hasMany(CriteriaScale::class, 'sub_criteria_id', 'sub_criteria_id');
    }

    public function criteria_marks() {
        return $this->hasMany(CriteriaMark::class, 'sub_criteria_id', 'sub_criteria_id');
    }

    public function co_level() {
        return $this->belongsTo(COLevel::class, 'co_level_id', 'co_level_id');
    }
}
