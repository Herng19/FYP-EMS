<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'slot_id';
    protected $fillable = [
        'schedule_id',
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

    public function schedule() {
        return $this->belongsTo(EvaluationSchedule::class, 'schedule_id', 'schedule_id');
    }
}
