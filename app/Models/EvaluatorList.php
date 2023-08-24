<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluatorList extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 
        'lecturer_id', 
    ];

    public $timestamps = false;
}
