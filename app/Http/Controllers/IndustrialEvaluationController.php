<?php

namespace App\Http\Controllers;

use App\Models\IndustrialEvaluator;
use Illuminate\Http\Request;

class IndustrialEvaluationController extends Controller
{
    public function showIndustrialEvaluators() {
        $industrial_evaluators = IndustrialEvaluator::all();

        return view('industrial_evaluation.industrial_evaluator.industrial_evaluator_list', ['industrial_evaluators' => $industrial_evaluators]);
    }

    public function newIndustrialEvaluator() {
        return view('industrial_evaluation.industrial_evaluator.add_industrial_evaluator');
    }

    public function createIndustrialEvaluator(Request $request) {
        $formfields = $request->validate([
            'evaluator_name' => 'required',
            'company' => 'required',
            'position' => 'required',
        ]);

        IndustrialEvaluator::create($formfields);

        return redirect('/industrial evaluator')->with('success-message', 'Industrial Evaluator has been added successfully.');
    }

    public function editIndustrialEvaluator($industrial_evaluator_id) {
        $industrial_evaluator = IndustrialEvaluator::find($industrial_evaluator_id);

        return view('industrial_evaluation.industrial_evaluator.edit_industrial_evaluator', ['industrial_evaluator' => $industrial_evaluator]);
    }

    public function updateIndustrialEvaluator(Request $request, $industrial_evaluator_id) {
        $formfields = $request->validate([
            'evaluator_name' => 'required',
            'company' => 'required',
            'position' => 'required',
        ]);

        IndustrialEvaluator::find($industrial_evaluator_id)->update($formfields);

        return redirect('/industrial evaluator')->with('success-message', 'Industrial Evaluator has been updated successfully.');
    }

    public function deleteIndustrialEvaluator($industrial_evaluator_id) {
        IndustrialEvaluator::find($industrial_evaluator_id)->delete();

        return redirect('/industrial evaluator')->with('success-message', 'Industrial Evaluator has been deleted successfully.');
    }
}
