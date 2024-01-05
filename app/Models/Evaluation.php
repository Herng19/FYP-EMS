<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\CriteriaMark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'lecturer_id',
        'evaluation_type',
        'marks', 
        'comment', 
    ];

    protected $primaryKey = 'evaluation_id';

    public $timestamps = false;

    public function criteria_marks() {
        return $this->hasMany(CriteriaMark::class, 'evaluation_id', 'evaluation_id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function lecturer() {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'lecturer_id');
    }
}
