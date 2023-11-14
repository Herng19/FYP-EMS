<?php

namespace App\Models;

use App\Models\IndustrialEvaluator;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndustrialEvaluationSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialSlotEvaluator extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'industrial_evaluator_id',
        'industrial_slot_id',
    ];

    public function industrial_evaluator() {
        return $this->belongsTo(IndustrialEvaluator::class, 'industrial_evaluator_id', 'industrial_evaluator_id');
    }

    public function industrial_evaluation_slot() {
        return $this->belongsTo(IndustrialEvaluationSlot::class, 'industrial_slot_id', 'industrial_slot_id');
    }
}
