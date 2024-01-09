<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Rubric;
use App\Models\CoLevel;
use App\Models\SubCriteria;
use Illuminate\Http\Request;
use App\Models\CriteriaScale;
use App\Models\ResearchGroup;
use App\Models\RubricCriteria;
use App\Rules\rubricWeightageTotal;

class RubricController extends Controller
{
    // Function to show rubric list
    public function showRubricList() {
        $user = auth()->user();
        if($user->hasRole('coordinator')) {
            $rubrics = Rubric::paginate(10);

        }
        else {
            $rubrics = Rubric::where('research_group_id', '=', $user->research_group_id)->paginate(10);
        }

        return view('rubric.rubric_list', [
            'rubrics' => $rubrics,
        ]);
    }

    // Function to show single rubric
    public function showRubric($rubric_id) {
        $rubric = Rubric::find($rubric_id);
        $scale_num = count($rubric->rubric_criterias[0]->sub_criterias[0]->criteria_scales); 

        return view('rubric.view_rubric', ['rubric' => $rubric, 'scale_num' => $scale_num]);
    }

    // Function to print rubric
    public function printRubric($rubric_id) {
        $rubric = Rubric::find($rubric_id);

        $pdf = PDF::loadView('rubric.print_rubric', compact('rubric'));

        // return view('rubric.print_rubric', ['rubric' => $rubric]);
        return $pdf->download($rubric->rubric_name.'.pdf');
    }

    // Function to show create rubric form
    public function newRubric() {
        $user = auth()->user();
        if($user->hasRole('coordinator')) {
            $research_groups = ResearchGroup::all();
        }
        else {
            $research_groups = ResearchGroup::where('research_group_id', '=', $user->research_group_id)->get();
        }

        $co_levels = CoLevel::all();

        return view('rubric.create_rubric', [
            'research_groups' => $research_groups, 
            'co_levels' => $co_levels,
        ]);
    }

    // Function to create rubric
    public function createRubric(Request $request) {
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
                    'co_level_id' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_co_level"],
                    'weightage' => $request->criteria[$criteria][$sub_criteria]["sub_criteria_weightage"],
                ])->id;


                // Insert into criteria_scale
                for($i = 0; $i < count($sub_criterias[$sub_criteria])-4; $i++) {
                    CriteriaScale::create([
                        'sub_criteria_id' => $sub_criteria_id,
                        'scale_level' => $i,
                        'scale_description' => $request->criteria[$criteria][$sub_criteria]["scale_" . strval($i)],
                    ]);
                }
            }
        }

        return redirect("/rubric")->with('success-message', 'Rubric created successfully!');
    }

    // Function to show edit rubric form
    public function editRubric($rubric_id) {
        $rubric = Rubric::find($rubric_id);
        $user = auth()->user();
        
        if($user->hasRole('coordinator')) {
            $research_groups = ResearchGroup::all();
        }
        else {
            $research_groups = ResearchGroup::where('research_group_id', '=', $user->research_group_id)->get();
        }
        $co_levels = CoLevel::all();

        return view('rubric.edit_rubric', [
            'rubric' => $rubric,
            'research_groups' => $research_groups,
            'co_levels' => $co_levels,
        ]);
    }

    // Function to update rubric
    public function updateRubric($rubric_id, Request $request) {
        Rubric::find($rubric_id)->update([
            'research_group_id' => $request->research_group, 
            'rubric_name' => $request->rubric_name,
            'evaluation_type' => $request->evaluation_number, 
            'psm_year' => $request->PSM,
        ]);

        foreach($request->criteria as $criteria => $sub_criterias) {
            if($request->criteria[$criteria]['criteria_id'] == null) {
                $criteria_id = RubricCriteria::create([
                    'rubric_id' => $rubric_id,
                    'criteria_name' => $request->criteria[$criteria]['criteria_name'],
                ])->id;
            }
            else {
                $criteria_id = $request->criteria[$criteria]['criteria_id'];
                RubricCriteria::where('criteria_id', '=', $criteria_id)
                            ->update(['criteria_name' => $request->criteria[$criteria]['criteria_name']]);
            }

            array_shift($sub_criterias); // Remove the criteria id
            array_shift($sub_criterias); // Remove the criteria name


            // Insert into sub_criteria
            foreach($sub_criterias as $sub_criteria => $value) {
                if($sub_criterias[$sub_criteria]["sub_criteria_id"] != null) {
                    $sub_criteria_id = $sub_criterias[$sub_criteria]["sub_criteria_id"];
                    SubCriteria::where('sub_criteria_id', '=', $sub_criteria_id)
                                ->update([
                                    'sub_criteria_name' => $sub_criterias[$sub_criteria]["sub_criteria_name"],
                                    'sub_criteria_description' => $sub_criterias[$sub_criteria]["sub_criteria_description"],
                                    'co_level_id' => $sub_criterias[$sub_criteria]["sub_criteria_co_level"],
                                    'weightage' => $sub_criterias[$sub_criteria]["sub_criteria_weightage"]
                                ]);
                }
                else {
                    $sub_criteria_id = SubCriteria::create([
                        'criteria_id' => $criteria_id,
                        'sub_criteria_name' => $sub_criterias[$sub_criteria]["sub_criteria_name"],
                        'sub_criteria_description' => $sub_criterias[$sub_criteria]["sub_criteria_description"],
                        'co_level' => $sub_criterias[$sub_criteria]["sub_criteria_co_level"],
                        'weightage' => $sub_criterias[$sub_criteria]["sub_criteria_weightage"]
                    ])->id;
                }

                array_shift($sub_criterias[$sub_criteria]); // Remove the sub criteria id
                array_shift($sub_criterias[$sub_criteria]); // Remove the sub criteria name
                array_shift($sub_criterias[$sub_criteria]); // Remove the sub criteria weightage
                array_shift($sub_criterias[$sub_criteria]); // Remove the sub criteria co level
                array_shift($sub_criterias[$sub_criteria]); // Remove the sub criteria description

                // Insert into criteria_scale
                foreach($sub_criterias[$sub_criteria] as $i => $scale) {
                    CriteriaScale::UpdateOrCreate(
                        ['scale_id'  => $sub_criterias[$sub_criteria][$i]['scale_id']], 
                        ['sub_criteria_id' => $sub_criteria_id, 'scale_level' => $i, 'scale_description' => $sub_criterias[$sub_criteria][$i]['scale_description']]
                    );
                }
            }
        }

        return back()->with('success-message', 'Rubric updated successfully!');
    }

    // Function to delete rubric
    public function deleteRubric($rubric_id) {
        Rubric::find($rubric_id)->delete();
 
        return redirect('/rubric')->with('success-message', 'Rubric deleted successfully!');
    }

    // Function to delete sub-criteria
    public function deleteCriteria($criteria_id) {
        RubricCriteria::where('criteria_id', '=', $criteria_id)->delete();

        return 0;
    }

    // Function to delete criteria
    public function deleteSubCriteria($sub_criteria_id) {
        SubCriteria::where('sub_criteria_id', '=', $sub_criteria_id)->delete();

        return 0;
    }

    // Function to delete scale
    public function deleteScale($scale_id) {
        CriteriaScale::where('scale_id', '=', $scale_id)->delete();

        return 0;
    }

    // CO Level Settings
    // Function to show co level setting page
    public function showCOLevelSettings() {
        $co_levels = CoLevel::paginate(10);

        return view('rubric.co_level_settings', [
            'co_levels' => $co_levels,
        ]);
    }

    // Function to show create co level form
    public function newCOLevel() {
        return view('rubric.create_co_level');
    }

    // Function to create co level
    public function createCOLevel(Request $request) {
        CoLevel::create([
            'co_level_name' => $request->co_level_name,
            'co_level_description' => $request->co_level_description,
        ]);

        return redirect('/rubric/co-level-settings')->with('success-message', 'Co Level created successfully!');
    }

    // Function to show edit co level form
    public function editCOLevel($co_level_id) {
        $co_level = CoLevel::find($co_level_id);

        return view('rubric.edit_co_level', [
            'co_level' => $co_level,
        ]);
    }

    // Function to update co level
    public function updateCOLevel($co_level_id, Request $request) {
        CoLevel::find($co_level_id)->update([
            'co_level_name' => $request->co_level_name,
            'co_level_description' => $request->co_level_description,
        ]);

        return redirect('/rubric/co-level-settings')->with('success-message', 'Co Level updated successfully!');
    }

    // Function to delete co level
    public function deleteCOLevel($co_level_id) {
        CoLevel::find($co_level_id)->delete();

        return redirect('/rubric/co-level-settings')->with('success-message', 'Co Level deleted successfully!');
    }
}
