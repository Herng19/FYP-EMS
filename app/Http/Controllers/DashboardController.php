<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function showDashboard() {
        $supervisees = DB::table('students')
                        ->join('supervisor_lists', 'students.student_id', '=', 'supervisor_lists.student_id')
                        ->join('projects', 'students.student_id', '=', 'projects.student_id')
                        ->select('students.name', 'students.psm_year', 'projects.project_title')
                        ->where('supervisor_lists.lecturer_id', '=', auth()->user()->lecturer_id)
                        ->get(); 

        return view('dashboard', [
            'supervisees' => $supervisees
        ]);
    }
}
