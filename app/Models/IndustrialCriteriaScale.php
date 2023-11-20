<?php

namespace App\Models;

use App\Models\IndustrialSubCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialCriteriaScale extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'industrial_sub_criteria_id',
        'scale_level',
        'scale_description',
    ];

    protected $primaryKey = 'industrial_criteria_scale_id';

    public function industrial_sub_criteria() {
        return $this->belongsTo(IndustrialSubCriteria::class, 'industrial_sub_criteria_id', 'industrial_sub_criteria_id');
    }
}
