<?php

namespace App\Models;

use App\Models\RubricCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rubric extends Model
{
    use HasFactory;

    protected $fillable = [
        'rubric_id',
        'research_group_id',
        'rubric_name',
        'evaluation_type',
        'psm_year', 
    ];

    protected $primaryKey = 'rubric_id';

    public function rubric_criterias() {
        return $this->hasMany(RubricCriteria::class, 'rubric_id', 'rubric_id');
    }
    public function research_group() {
        return $this->belongsTo(ResearchGroup::class, 'research_group_id', 'research_group_id');
    }
}
