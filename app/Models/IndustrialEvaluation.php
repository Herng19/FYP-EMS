<?php

namespace App\Models;

use App\Models\Student;
use App\Models\IndustrialCriteriaMark;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustrialEvaluation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'industrial_evaluation_id';
    
    protected $fillable = [
        'student_id', 
        'marks', 
        'comment',
    ];

    public function student() {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function industrial_criteria_marks() {
        return $this->hasMany(IndustrialCriteriaMark::class, 'industrial_evaluation_id', 'industrial_evaluation_id');
    }
}
