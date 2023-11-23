<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IndustrialEvaluation;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ReportController extends Controller
{
    public function showReport() {
        if(auth('web')->check()) {
            // Get lecturer's supervisees
            $lecturer = auth()->user();
            $supervisees = $lecturer->supervisees->pluck('student_id'); 

            foreach($supervisees as $supervisee) {
                // Get student name
                $student_name = Student::where('student_id', $supervisee)->first()->name;

                // Get total marks for that student
                $supervisee_marks = Evaluation::where('student_id', $supervisee)->get()->sum('marks');

                // Insert into array
                $data[$student_name] = $supervisee_marks;
            }
            
            return view('report.report_and_progress', compact('data')); 
        }
        else if(auth('student')->check()) {
            $student = Student::find(auth()->user()->student_id);

            // Get each evaluation marks for that student
            $all_marks = Evaluation::where('student_id', auth()->user()->student_id)->get();

            $data = $all_marks->mapWithKeys(function($item) {
                return [$item['evaluation_type'] => $item['marks']];
            });
            
            if($student->top_student == 1) {
                $industrial_evaluation= IndustrialEvaluation::where('student_id', auth()->user()->student_id)->get();
                $industrial_mark = $industrial_evaluation->mapWithKeys(function($item) {
                    return ['Industrial Evaluation' => $item['marks']];
                });
                $data = $data->merge($industrial_mark);
            }

            return view('report.report_and_progress', compact('data'));
        }
        else {
            return redirect()->route('login');
        }
    }
}
