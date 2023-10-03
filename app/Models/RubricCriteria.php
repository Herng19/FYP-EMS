<?php

namespace App\Models;

use App\Models\Rubric;
use App\Models\SubCriteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RubricCriteria extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'rubric_id',
        'criteria_name',
    ];

    public $timestamps = false;

    public function rubric() {
        return $this->belongsTo(Rubric::class, 'rubric_id', 'rubric_id');
    }

    public function sub_criterias() {
        return $this->hasMany(SubCriteria::class, 'criteria_id', 'criteria_id');
    }
}
