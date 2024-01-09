<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SuperviseeListController extends Controller
{
    public function showSuperviseeList() {
        if(Auth::user()->hasRole('coordinator')) {
            $supervisees = Student::orderBy('psm_year')->paginate(10);

            return view('supervisee.supervisee_list', [
                'supervisees' => $supervisees
            ]);
        }
        else if(Auth::user()->hasRole('head of research group')) {
            $supervisees = Student::where('research_group_id', '=', Auth::user()->research_group->research_group_id)
                            ->orderBy('psm_year')
                            ->paginate(10);

            return view('supervisee.supervisee_list', [
                'supervisees' => $supervisees
            ]);
        }
        else {
            $supervisees = Auth::user()->supervisees()->paginate(10); 

            return view('supervisee.supervisee_list', [
                'supervisees' => $supervisees
            ]);
        }
    }
}
