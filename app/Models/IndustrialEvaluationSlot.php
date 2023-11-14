<?php

namespace App\Models;

use App\Models\Venue;
use App\Models\Student;
use App\Models\IndustrialSlotEvaluator;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndustrialEvaluationSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialEvaluationSlot extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'industrial_slot_id';

    protected $fillable = [
        'industrial_schedule_id',
        'student_id',
        'venue_id',
        'start_time', 
        'end_time',
    ];

    public function student() {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function venues() {
        return $this->belongsTo(Venue::class, 'venue_id', 'venue_id');
    }

    public function industrial_evaluation_schedule() {
        return $this->belongsTo(IndustrialEvaluationSchedule::class, 'industrial_schedule_id', 'industrial_schedule_id');
    }

    public function industrial_slot_evaluators() {
        return $this->hasMany(IndustrialSlotEvaluator::class, 'industrial_slot_id', 'industrial_slot_id');
    }
}
