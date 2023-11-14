<?php

namespace App\Models;

use App\Models\IndustrialSlotEvaluator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function industrial_slot_evaluators() {
        return $this->hasMany(IndustrialSlotEvaluator::class, 'industrial_evaluator_id', 'industrial_evaluator_id');
    }
}
