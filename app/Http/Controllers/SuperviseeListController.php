<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperviseeListController extends Controller
{
    public function showSuperviseeList() {
            $supervisees = DB::table('students')
                            ->join('supervisor_lists', 'students.student_id', '=', 'supervisor_lists.student_id')
                            ->join('projects', 'students.student_id', '=', 'projects.student_id')
                            ->select('students.name', 'students.psm_year', 'projects.project_title', 'students.course')
                            ->where('supervisor_lists.lecturer_id', '=', auth()->user()->lecturer_id)
                            ->paginate(10); 
    
            return view('supervisee.supervisee_list', [
                'supervisees' => $supervisees
            ]);
    }
}
