<?php

namespace App\Models;

use App\Models\SubCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CriteriaScale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_criteria_id', 
        'scale_level', 
        'scale_description', 
    ];

    public $timestamps = false;

    public function sub_criteria() {
        return $this->belongsTo(SubCriteria::class, 'sub_criteria_id', 'sub_criteria_id');
    }
}
