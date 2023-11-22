<?php

namespace App\Models;

use App\Models\IndustrialEvaluation;
use App\Models\IndustrialSubCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialCriteriaMark extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'industrial_criteria_mark_id';

    protected $fillable = [
        'industrial_sub_criteria_id', 
        'industrial_evaluation_id', 
        'scale'
    ];

    public function industrial_evaluation() {
        return $this->belongsTo(IndustrialEvaluation::class, 'industrial_evaluation_id', 'industrial_evaluation_id');
    }

    public function industrial_sub_criteria_id() {
        return $this->belongsTo(IndustrialSubCriteria::class, 'industrial_sub_criteria_id', 'industrial_sub_criteria_id');
    }
}
