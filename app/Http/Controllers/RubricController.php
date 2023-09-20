<?php

namespace App\Http\Controllers;

use App\Models\Rubric;
use Illuminate\Http\Request;
use App\Models\IndustrialEvaluationRubric;

class RubricController extends Controller
{
    public function showRubric()
    {
        if(auth()->user()->hasRole('coordinator')) {
            $rubrics = Rubric::all();
            $industrial_rubrics = IndustrialEvaluationRubric::all();
        }
        else {
            $rubrics = Rubric::where('research_group_id', auth()->user()->research_group->research_group_id)->get();
            $industrial_rubrics = [];
        }

        return view('rubric.rubric_list', [
            'rubrics' => $rubrics,
            'industrial_rubrics' => $industrial_rubrics
        ]);
    }

    public function newRubric() {
        return view('rubric.create_rubric');
    }

    public function createRubric(Request $request) {
        dd($request->all());
        return redirect("/rubric")->with('success', 'Rubric created successfully!');
    }
}
