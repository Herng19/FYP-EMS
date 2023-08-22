<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showFYP() {
        $fyp = Project::where('student_id', '=', Auth::user()->student_id)->first();

        return view('profile.edit_fyp', ['fyp' => $fyp]);
    }

    public function updateFYP(Request $request) {
        $input = $request->validate([
            'project_title' => 'required', 
            'project_description' => 'required',
        ]); 

        Project::where('student_id', '=', Auth::user()->student_id)->update($input);

        return back()->with('success-message', 'Final Year Project Infomation Updated Successfully');
    }
}
