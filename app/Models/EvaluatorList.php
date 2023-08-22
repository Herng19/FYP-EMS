<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluatorList extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 
        'lecturer_id', 
    ];

    public $timestamps = false;
}
