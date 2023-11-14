<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IndustrialEvaluationSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialEvaluationSchedule extends Model
{
    use HasFactory;

    protected $primaryKey = 'industrial_schedule_id';

    protected $fillable = [
        'schedule_date',
    ];

    public function industrial_evaluation_slots() {
        return $this->hasMany(IndustrialEvaluationSlot::class, 'industrial_schedule_id', 'industrial_schedule_id');
    }
}
