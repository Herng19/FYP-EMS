<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IndustrialEvaluator;

class IndustrialEvaluationController extends Controller
{
    // Function to show industrial evaluator list
    public function showIndustrialEvaluators() {
        $industrial_evaluators = IndustrialEvaluator::all();

        return view('industrial_evaluation.industrial_evaluator.industrial_evaluator_list', ['industrial_evaluators' => $industrial_evaluators]);
    }

    // Function to show add industrial evaluator form
    public function newIndustrialEvaluator() {
        return view('industrial_evaluation.industrial_evaluator.add_industrial_evaluator');
    }

    // Function to create new industrial evaluator
    public function createIndustrialEvaluator(Request $request) {
        $formfields = $request->validate([
            'evaluator_name' => 'required',
            'company' => 'required',
            'position' => 'required',
        ]);

        IndustrialEvaluator::create($formfields);

        return redirect('/industrial evaluator')->with('success-message', 'Industrial Evaluator has been added successfully.');
    }

    // Function to show edit industrial evaluator form
    public function editIndustrialEvaluator($industrial_evaluator_id) {
        $industrial_evaluator = IndustrialEvaluator::find($industrial_evaluator_id);

        return view('industrial_evaluation.industrial_evaluator.edit_industrial_evaluator', ['industrial_evaluator' => $industrial_evaluator]);
    }

    // Function to update industrial evaluator
    public function updateIndustrialEvaluator(Request $request, $industrial_evaluator_id) {
        $formfields = $request->validate([
            'evaluator_name' => 'required',
            'company' => 'required',
            'position' => 'required',
        ]);

        IndustrialEvaluator::find($industrial_evaluator_id)->update($formfields);

        return redirect('/industrial evaluator')->with('success-message', 'Industrial Evaluator has been updated successfully.');
    }

    // Function to delete industrial evaluator
    public function deleteIndustrialEvaluator($industrial_evaluator_id) {
        IndustrialEvaluator::find($industrial_evaluator_id)->delete();

        return redirect('/industrial evaluator')->with('success-message', 'Industrial Evaluator has been deleted successfully.');
    }

    // Function to show industrial schedule
    public function showIndustrialSchedule(Request $request) {
        if(isset($request->date) && $request->date != null) {
            session(['date' => $request->date]);
        }

        $timeslots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $schedules = DB::table('students')
                    ->join('projects', 'students.student_id', '=', 'projects.student_id')
                    ->join('industrial_evaluation_slots', 'students.student_id', 'industrial_evaluation_slots.student_id')
                    ->join('venues', 'industrial_evaluation_slots.venue_id', 'venues.venue_id')
                    ->join('industrial_evaluation_schedules', 'industrial_evaluation_slots.industrial_schedule_id', '=', 'industrial_evaluation_schedules.industrial_schedule_id')
                    ->select('students.student_id', 'students.name', 'projects.project_title', 'industrial_evaluation_schedules.schedule_date', 'industrial_evaluation_slots.industrial_slot_id', 'industrial_evaluation_slots.start_time', 'venues.venue_id', 'venues.venue_name')
                    ->where('industrial_evaluation_schedules.schedule_date', '=', session('date'))
                    ->orderBy('venues.venue_id')
                    ->get();
        $venues = Venue::all(); 

        return view('industrial_evaluation.industrial_schedule.industrial_schedule', [
            'timeslots' => $timeslots,
            'schedules' => $schedules,
            'venues' => $venues, 
        ]);
    }
}
