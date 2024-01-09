<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showDashboard() {
        if(auth('student')->check()) {
            $student = Student::find(auth()->user()->student_id);
            
            return view('student_dashboard', [
                'student' => $student
            ]);
        }
        else if(auth('web')->check()) {
            if(Auth::user()->hasRole('coordinator')) {
                $supervisees = Student::orderBy('psm_year')->get();
                $psm1_students = Student::where('psm_year', '=', '1')->count();
                $psm2_students = Student::where('psm_year', '=', '2')->count();
                $lecturers = Lecturer::role('supervisor')->count();

                return view('dashboard', [
                    'supervisees' => $supervisees, 
                    'psm1_students' => $psm1_students,
                    'psm2_students' => $psm2_students,
                    'lecturers' => $lecturers
                ]);
            }
            else if(Auth::user()->hasRole('head of research group')) {
                $supervisees = Student::where('research_group_id', '=', Auth::user()->research_group->research_group_id)
                                ->orderBy('psm_year')
                                ->get();
                $psm1_students = Student::where('research_group_id', '=', Auth::user()->research_group->research_group_id)
                                ->where('psm_year', '=', '1')
                                ->count();
                $psm2_students = Student::where('research_group_id', '=', Auth::user()->research_group->research_group_id)
                                ->where('psm_year', '=', '2')
                                ->count();
                $lecturers = Lecturer::role('supervisor')
                                ->where('research_group_id', '=', Auth::user()->research_group->research_group_id)
                                ->count();

                return view('dashboard', [
                    'supervisees' => $supervisees, 
                    'psm1_students' => $psm1_students,
                    'psm2_students' => $psm2_students,
                    'lecturers' => $lecturers
                ]);
            }
            else {
                $supervisees = Auth::user()->supervisees;

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
}
