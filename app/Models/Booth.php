<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IndustrialEvaluationSlot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booth extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function industrial_evaluation_slots() {
        return $this->hasMany(IndustrialEvaluationSlot::class, 'booth_id', 'booth_id');
    }
}
