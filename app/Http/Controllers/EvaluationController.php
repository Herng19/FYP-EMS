<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function showEvaluateeList() {
        $evaluatees = DB::table('students')
                    ->join('evaluator_lists', 'students.student_id', '=', 'evaluator_lists.student_id')
                    ->join('supervisor_lists', 'students.student_id', '=', 'supervisor_lists.student_id')
                    ->join('projects', 'students.student_id', '=', 'projects.student_id')
                    ->select('students.*', 'projects.project_title')
                    ->where('supervisor_lists.lecturer_id', '=', auth()->user()->lecturer_id)
                    ->orWhere('evaluator_lists.lecturer_id', '=', auth()->user()->lecturer_id)
                    ->paginate(10);

        return view('evaluation.student_list', [
            'evaluatees' => $evaluatees
        ]);
    }

    public function showEvaluationForm($student_id) {
        $student = Student::find($student_id);
        
        return view('evaluation.edit_evaluation', ['student' => $student]);
    }
}
