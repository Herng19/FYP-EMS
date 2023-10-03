<?php

namespace App\Http\Controllers;

use App\Models\Rubric;
use App\Models\SubCriteria;
use Illuminate\Http\Request;
use App\Models\CriteriaScale;
use App\Models\ResearchGroup;
use App\Models\RubricCriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\IndustrialSubCriteria;
use App\Models\IndustrialCriteriaScale;
use App\Models\IndustrialRubricCriteria;
use App\Models\IndustrialEvaluationRubric;

class RubricController extends Controller
{
    // Function to show rubric list
    public function showRubricList() {
        $user = auth()->user();
        if($user->hasRole('coordinator')) {
            $normal_rubrics = DB::table('rubrics')
                        ->leftJoin('research_groups', 'rubrics.research_group_id', '=', 'research_groups.research_group_id')
                        ->select('research_groups.research_group_name', 'rubrics.rubric_name as rubric_name', 'rubrics.rubric_id as rubric_id', 'rubrics.psm_year as psm_year');

            $rubrics = DB::table('industrial_evaluation_rubrics')
                        ->leftJoin('research_groups', 'industrial_evaluation_rubrics.research_group_id', '=', 'research_groups.research_group_id')
                        ->select('research_groups.research_group_name', 'industrial_evaluation_rubrics.rubric_name as rubric_name', 'industrial_evaluation_rubrics.industrial_rubric_id as rubric_id', 'industrial_evaluation_rubrics.created_at as psm_year')
                        ->union($normal_rubrics)
                        ->paginate(10);

        }
        else {
            $rubrics = Rubric::where('research_group_id', auth()->user()->research_group->research_group_id)->paginate(10);
        }

        return view('rubric.rubric_list', [
            'rubrics' => $rubrics,
        ]);
    }

    // Function to show single rubric
    public function showRubric($rubric_id) {
        $rubric = Rubric::find($rubric_id);

        return view('rubric.view_rubric', ['rubric' => $rubric]);
    }

    // Function to show create rubric form
    public function newRubric() {
        $research_groups = ResearchGroup::all();

        return view('rubric.create_rubric', [
            'research_groups' => $research_groups
        ]);
    }

    // Function to create rubric
    public function createRubric(Request $request) {
        // Insert into rubric if normal evaluation
        if($request->evaluation_type == 'normal-evaluation') {
            $rubric_id = Rubric::create([
                'research_group_id' => $request->research_group, 
                'rubric_name' => $request->rubric_name,
                'evaluation_type' => $request->evaluation_number, 
                'psm_year' => $request->PSM,
            ])->rubric_id;

            // Insert into rubric_criteria
            foreach($request->criteria as $criteria => $sub_criterias) {
                $criteria_id = RubricCriteria::create([
                    'rubric_id' => $rubric_id,
                    'criteria_name' => $request->criteria[$criteria]['criteria_name'],
                ])->id;

                array_shift($sub_criterias); // Remove the criteria name

                // Insert into sub_criteria
                foreach($sub_criterias as $sub_criteria => $value) {
                    $sub_criteria_id = SubCriteria::create([
                        'criteria_id' => $criteria_id,
                        'sub_criteria_name' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_name"],
                        'sub_criteria_description' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_description"],
                        'co_level' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_co_level"],
                        'weightage' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_weightage"],
                    ])->id;

                    // Insert into criteria_scale
                    for($i = 0; $i < 6; $i++) {
                        CriteriaScale::create([
                            'sub_criteria_id' => $sub_criteria_id,
                            'scale_level' => $i,
                            'scale_description' => $request->criteria[$criteria][$sub_criteria]["scale_" . strval($i)],
                        ]);
                    }
                }
            }
        }
        // Insert into industrial_evaluation_rubric if industrial evaluation
        else if($request->evaluation_type == 'industrial-evaluation') {
            $industrial_rubric_id = IndustrialEvaluationRubric::create([
                'research_group_id' => $request->research_group, 
                'rubric_name' => $request->rubric_name,
            ])->id;

            // Insert into rubric_criteria
            foreach($request->criteria as $criteria => $sub_criterias) {
                $industrial_criteria_id = IndustrialRubricCriteria::create([
                    'industrial_rubric_id' => $industrial_rubric_id,
                    'criteria_name' => $request->criteria[$criteria]['criteria_name'],
                ])->id;

                array_shift($sub_criterias); // Remove the criteria name

                // Insert into sub_criteria
                foreach($sub_criterias as $sub_criteria => $value) {
                    $industrial_sub_criteria_id = IndustrialSubCriteria::create([
                        'industrial_criteria_id' => $industrial_criteria_id,
                        'sub_criteria_name' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_name"],
                        'sub_criteria_description' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_description"],
                        'co_level' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_co_level"],
                        'weightage' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_weightage"],
                    ])->id;

                    // Insert into criteria_scale
                    for($i = 0; $i < 6; $i++) {
                        IndustrialCriteriaScale::create([
                            'industrial_sub_criteria_id' => $industrial_sub_criteria_id,
                            'scale_level' => $i,
                            'scale_description' => $request->criteria[$criteria][$sub_criteria]["scale_" . strval($i)],
                        ]);
                    }
                }
            }
        }

        return redirect("/rubric")->with('success-message', 'Rubric created successfully!');
    }

    // Function to show edit rubric form
    public function editRubric($rubric_id) {

    }

    // Function to update rubric
    public function updateRubric($rubric_id, Request $request) {

    }

    // Function to delete rubric
    public function deleteRubric($rubric_id) {
        Rubric::find($rubric_id)->delete();
 
        return redirect('/rubric')->with('success-message', 'Rubric deleted successfully!');
    }
}
