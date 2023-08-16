<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showDashboard() {
        if(auth('student')->check()) {
            $project = Project::where('student_id', auth()->user()->student_id)->first();
            
            return view('student_dashboard', [
                'project' => $project
            ]);
        }
        else{
            $supervisees = DB::table('students')
            ->join('supervisor_lists', 'students.student_id', '=', 'supervisor_lists.student_id')
            ->join('projects', 'students.student_id', '=', 'projects.student_id')
            ->select('students.name', 'students.psm_year', 'projects.project_title')
            ->where('supervisor_lists.lecturer_id', '=', auth()->user()->lecturer_id)
            ->get(); 

            $psm1_students = DB::table('students')
                        ->join('supervisor_lists', 'students.student_id', '=', 'supervisor_lists.student_id')
                        ->select('student_id')
                        ->where('supervisor_lists.lecturer_id', '=', auth()->user()->lecturer_id)
                        ->where('students.psm_year', '=', '1')
                        ->count();

            $psm2_students = DB::table('students')
                        ->join('supervisor_lists', 'students.student_id', '=', 'supervisor_lists.student_id')
                        ->select('student_id')
                        ->where('supervisor_lists.lecturer_id', '=', auth()->user()->lecturer_id)
                        ->where('students.psm_year', '=', '2')
                        ->count();

            $evaluatees = DB::table('students')
                        ->join('evaluator_lists', 'students.student_id', '=', 'evaluator_lists.student_id')
                        ->select('student_id')
                        ->where('evaluator_lists.lecturer_id', '=', auth()->user()->lecturer_id)
                        ->count();

            return view('dashboard', [
                'supervisees' => $supervisees, 
                'psm1_students' => $psm1_students,
                'psm2_students' => $psm2_students,
                'evaluatees' => $evaluatees
            ]);
        }
    }
}
