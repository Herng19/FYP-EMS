<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustrialEvaluator extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'evaluator_name', 
        'company', 
        'position',
    ];

    protected $primaryKey = 'industrial_evaluator_id';
}
