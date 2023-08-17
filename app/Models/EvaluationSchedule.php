<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationSchedule extends Model
{
    use HasFactory;

    public function slots() {
        return $this->hasMany(Slot::class, 'schedule_id', 'schedule_id');
    }
}
