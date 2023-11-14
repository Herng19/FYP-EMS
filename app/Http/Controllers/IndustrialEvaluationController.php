<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IndustrialEvaluator;
use App\Models\IndustrialSlotEvaluator;
use App\Rules\industrialSlotCrashVenue;
use App\Models\IndustrialEvaluationSlot;
use App\Models\IndustrialEvaluationSchedule;
use App\Rules\industrialEvaluatorCrashTimeslot;

class IndustrialEvaluationController extends Controller
{
    /**
     * 
     * 
     Industrial Evaluators Module
     */

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

    /**
     * 
     * 
     Industrial Schedule Module
     */

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

    // Function to show create industrial slot form
    public function newIndustrialSlot(Request $request) {
        $students = Student::where('top_student', '=', '1')->get()->sortBy('name');
        (isset($request->student_id))? $selected_student = Student::find($request->student_id) : ((null !== $request->old('name'))? $selected_student = Student::find($request->old('name')) : $selected_student = Student::all()->sortBy('name')->first());
 

        $venues = Venue::all();
        $timeslots = ['8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $available_evaluators = IndustrialEvaluator::all();

        return view('industrial_evaluation.industrial_schedule.create_slot', ["students" => $students, 
                                                "selected_student" => $selected_student, 
                                                "venues" => $venues, 
                                                "timeslots" => $timeslots, 
                                                "available_evaluators" => $available_evaluators]);
    }

    // Function to create industrial slot
    public function createIndustrialSlot(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'unique:App\Models\IndustrialEvaluationSlot,student_id'],
            'venue' => ['required',  new industrialSlotCrashVenue],
            'date' => ['required', 'date'], 
            'timeslot' => 'required',
            'evaluator1' => ['required', 'different:evaluator2',  new industrialEvaluatorCrashTimeslot], 
            'evaluator2' => ['required', 'different:evaluator1',  new industrialEvaluatorCrashTimeslot]
        ], ['name.unique' => 'Student has already been assigned a slot']); 

        $date = $formFields['date'];
        $time = $formFields['timeslot'];
        $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        $end_time_converted = date('H:i:s', strtotime($time) + 30*60);
        $end_time = date('Y-m-d H:i:s', strtotime("$date $end_time_converted"));
        $schedule = IndustrialEvaluationSchedule::firstOrCreate(['schedule_date' => $date]);

        $slot_id = IndustrialEvaluationSlot::create([
            'student_id' => $formFields['name'],
            'venue_id' => $formFields['venue'],
            'industrial_schedule_id' => $schedule->industrial_schedule_id, 
            'start_time' => $start_time,
            'end_time' => $end_time, 
        ])->industrial_slot_id;

        IndustrialSlotEvaluator::create([
            'industrial_slot_id' => $slot_id,
            'industrial_evaluator_id' => $formFields['evaluator1']
        ]); 

        IndustrialSlotEvaluator::create([
            'industrial_slot_id' => $slot_id,
            'industrial_evaluator_id' => $formFields['evaluator2']
        ]); 

        return redirect('/industrial schedule')->with('success-message', 'Slot Created Successfully');
    }

    // Function to show edit industrial slot form
    public function editIndustrialSlot($slot_id, Request $request) {
        $slot = IndustrialEvaluationSlot::find($slot_id);

        isset($request->student_id) ? $selected_student = Student::find($request->student_id) : $selected_student = Student::find($slot->student_id);
        $students = Student::where('top_student', '=', 1)->get()->sortBy('name');

        $evaluators = $slot->industrial_slot_evaluators()->get()->pluck('industrial_evaluator_id')->toArray();
        $venues = Venue::all();
        $timeslots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $available_evaluators = IndustrialEvaluator::all();

        return view('industrial_evaluation.industrial_schedule.edit_slot', ["students" => $students, 
                                                "slot" => $slot,
                                                "selected_student" => $selected_student, 
                                                "venues" => $venues, 
                                                "timeslots" => $timeslots, 
                                                "evaluators" => $evaluators, 
                                                "available_evaluators" => $available_evaluators]);
    }

    // Function to update industrial slot
    public function updateIndustrialSlot($slot_id, Request $request) {
        $formFields = $request->validate([
            'name' => ['required'],
            'venue' => ['required',  new industrialSlotCrashVenue],
            'date' => ['required', 'date'], 
            'timeslot' => 'required',
            'evaluator1' => ['required', 'different:evaluator2',  new industrialEvaluatorCrashTimeslot], 
            'evaluator2' => ['required', 'different:evaluator1',  new industrialEvaluatorCrashTimeslot]
        ]); 

        $date = $formFields['date'];
        $time = $formFields['timeslot'];
        $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        $end_time_converted = date('H:i:s', strtotime($time) + 30*60);
        $end_time = date('Y-m-d H:i:s', strtotime("$date $end_time_converted"));
        $schedule = IndustrialEvaluationSchedule::firstOrCreate(['schedule_date' => $date]);
        
        $slot = IndustrialEvaluationSlot::find($slot_id);
        $evaluators = IndustrialSlotEvaluator::where('industrial_slot_id', "=", $slot_id)->limit(2)->get();

        if($evaluators === null) {
            IndustrialSlotEvaluator::create([
                'industrial_slot_id' => $slot_id,
                'industrial_evaluator_id' => $formFields['evaluator1']
            ]); 
    
            IndustrialSlotEvaluator::create([
                'industrial_slot_id' => $slot_id,
                'industrial_evaluator_id' => $formFields['evaluator2']
            ]); 
        }
        else {
            foreach($evaluators as $i => $evaluator) {
                IndustrialSlotEvaluator::where('slot_evaluator_id', '=', $evaluator->slot_evaluator_id)->update([
                    'industrial_evaluator_id' => $formFields['evaluator' . ($i + 1)]
                ]);
            }
        }

        $slot->update([
            'student_id' => $formFields['name'],
            'venue_id' => $formFields['venue'],
            'industrial_schedule_id' => $schedule->industrial_schedule_id, 
            'start_time' => $start_time,
            'end_time' => $end_time, 
        ]);

        return back()->with('success-message', 'Slot Updated Successfully');
    }

    // Function to delete industrial slot
    public function deleteIndustrialSlot($slot_id) {
        IndustrialEvaluationSlot::find($slot_id)->delete();

        return redirect("/industrial schedule")->with('success-message', 'Slot Deleted Successfully');
    }

     // Function to schedule industrial evaluation schedule
     public function scheduleIndustrialSchedule(Request $request) {
        // If industrial evaluators < 2, return error
        if(IndustrialEvaluator::all()->count() < 2) {
            return redirect('/industrial schedule')->with('error-message', 'Please add at least 2 industrial evaluators before scheduling.');
        }

        // If top students are not set yet, return error message
        if(Student::where('top_student', '=', 1)->where('psm_year', '=', 2)->count() == 0) {
            return redirect('/industrial schedule')->with('error-message', 'Please set top students before scheduling.');
        }

        // Clear schdule on requested date
        $schedule_id = IndustrialEvaluationSchedule::whereDate('schedule_date', $request->date)->pluck('industrial_schedule_id')->first();

        // If schedule does not exist, create new schedule
        ($schedule_id !== null)? $schedule_id = $schedule_id : $schedule_id = IndustrialEvaluationSchedule::create(['schedule_date' => $request->date])->industrial_schedule_id;

        // Get all slots scheduled on the date and delete
        IndustrialEvaluationSlot::whereDate('start_time', $request->date)->delete();

        // Initiate variables for timeslots, particles num
        $timeslots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $rooms_available = Venue::all()->pluck('venue_id')->toArray();
        $num_particles = 20;
        $stud_num = 0; 

        // Getting all variables 
        $students_had_slot = IndustrialEvaluationSlot::all()->pluck('student_id')->toArray();

        $first_stud_no_slot = Student::whereNotIn('student_id', $students_had_slot)
                                    ->where('psm_year', '=', 2)
                                    ->where('top_student', '=', 1)
                                    ->first();

        // If all students have been scheduled, break
        if($first_stud_no_slot === null) {
            return redirect('/industrial schedule')->with('error-message', 'All top students have been scheduled.');
        }

        $students_pending_slot = Student::whereNotIn('student_id', $students_had_slot)
                            ->where('psm_year', '=', 2)
                            ->where('top_student', '=', 1)
                            ->limit(15)
                            ->pluck('student_id')
                            ->toArray();

        $stud_num = count($students_pending_slot);

        // Get industrial evaluators
        $evaluators2 = $evaluators1 = IndustrialEvaluator::all()->pluck('industrial_evaluator_id')->toArray();
        
        $rooms = array_slice($rooms_available, 0, ceil($stud_num/count($timeslots)));
        array_splice($rooms_available, 0, ceil($stud_num/count($timeslots)));

        // Get the schedule
        $global_best_position = $this->particle_swarm_optimization($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot);
        $schedule = array();
        for ($i = 0; $i < count($global_best_position); $i += 5) {
            $timeslot = $timeslots[$global_best_position[$i]];
            $room = $rooms[$global_best_position[$i + 1]];
            $evaluator1 = $evaluators1[$global_best_position[$i + 2]];
            $evaluator2 = $evaluators2[$global_best_position[$i + 3]];
            $student = $students_pending_slot[$global_best_position[$i + 4]];
            $schedule[] = array($timeslot, $room, $evaluator1, $evaluator2, $student);
        }

        // Foreach student, insert data into slots, and evaluator list
        foreach($schedule as $slot) {
            $start_time = date('Y-m-d H:i:s', strtotime("$request->date $slot[0]"));
            $end_time = date('Y-m-d H:i:s', strtotime("$request->date $slot[0]") + 30*60);

            $slot_id = IndustrialEvaluationSlot::create([
                'student_id' => $slot[4],
                'venue_id' => $slot[1],
                'industrial_schedule_id' => $schedule_id, 
                'start_time' => $start_time,
                'end_time' => $end_time, 
            ])->id;

            IndustrialSlotEvaluator::create([
                'industrial_slot_id' => $slot_id,
                'industrial_evaluator_id' => $slot[2]
            ]);

            IndustrialSlotEvaluator::create([
                'industrial_slot_id' => $slot_id,
                'industrial_evaluator_id' => $slot[3]
            ]);
        }

        // Count the rest of unschedule top student
        $students_had_slot = IndustrialEvaluationSlot::all()->pluck('student_id')->toArray();
        $top_students_dont_have_slot = Student::whereNotIn('student_id', $students_had_slot)
                                ->where('psm_year', '=', 2)
                                ->where('top_student', '=', 1)
                                ->count();

        return redirect('/industrial schedule')->with('success-message', 'Schedule Created Successfully, '.$top_students_dont_have_slot.' top students are not scheduled.');
    }

    // Evaluation function to evaluate industrial evaluation schedule generated
    private function evaluate($position, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot) {
        $schedule = array();
        $evaluator_student_counts = array();

    
        for ($i = 0; $i < count($position); $i += 5) {
            $timeslot = $timeslots[$position[$i]];
            $room = $rooms[$position[$i + 1]];
            $evaluator1 = $evaluators1[$position[$i + 2]];
            $evaluator2 = $evaluators2[$position[$i + 3]];
            $student = $students_pending_slot[$position[$i + 4]];
            $schedule[] = array($timeslot, $room, $evaluator1, $evaluator2, $student);
    
            $evaluator_student_counts[$evaluator1] = 0;
            $evaluator_student_counts[$evaluator2] = 0;
        }
    
        // calculate the cost of the schedule
        $cost = 0;
        for ($i = 0; $i < count($schedule); $i++) {
            $conflicts = 0;
            
            // count the number of students assigned to each evaluator
            $evaluator_student_counts[$schedule[$i][2]]++;
            $evaluator_student_counts[$schedule[$i][3]]++;
            
            for ($j = $i + 1; $j < count($schedule); $j++) {
                // check for timeslot/venue/evaluators conflicts
                if($schedule[$i][2] == $schedule[$i][3] || $schedule[$j][2] == $schedule[$j][3]){
                    $conflicts++;
                }
                else if ($schedule[$i][2] == $schedule[$j][3] || $schedule[$i][3] == $schedule[$j][2] || $schedule[$i][2] == $schedule[$j][2] || $schedule[$i][3] == $schedule[$j][3] || $schedule[$i][1] == $schedule[$j][1]) {
                    if ($schedule[$i][0] == $schedule[$j][0]) {
                        $conflicts++;
                    }
                }
            }
            $cost += $conflicts;
        }
        
        // check student counts range 
        // $max_student_count = max($evaluator_student_counts);
        // $min_student_count = min($evaluator_student_counts);
        // $balance_penalty = $max_student_count - $min_student_count;
        
        // if($balance_penalty > 2) {
        //     $cost += 1;
        // }
    
        return 1 / ($cost + 1); // minimize conflicts
    }

    // initialize the particles for industrial evaluation schedule
    private function generate_particles($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot) {
        $particles = array();
        for ($i = 0; $i < $num_particles; $i++) {
            $position = array();
            for ($j = 0; $j < count($students_pending_slot); $j++) {
                $position[] = rand(0, count($timeslots) - 1);
                $position[] = rand(0, count($rooms) - 1);
                $position[] = rand(0, count($evaluators1) - 1);
                $position[] = rand(0, count($evaluators2) - 1);
                $position[] = $j;
            }
            $particles[] = array(
                'position' => $position,
                'velocity' => array_fill(0, count($students_pending_slot)*5, 0),
                'best_position' => $position,
                'best_fitness' => $this->evaluate($position, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot),
                'fitness' => $this->evaluate($position, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot)
            );
        }
        return $particles; 
    }

    // PSO algorithm for industrial evaluation schedule
    private function particle_swarm_optimization($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot) {   
        // PSO parameters
        $c1 = 3.0;
        $c2 = 1.0;
        $w = 0.5;
        $particles = $this->generate_particles($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot);
        $best_position = $particles[0]['position'];
        $best_fitness = $particles[0]['fitness'];
        $iterations = 0; 
    
        // run the PSO algorithm
        while($best_fitness < 1 ) {
            if($iterations >= 300) {
                $iterations = 0;
                $particles = $this->generate_particles($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot);
                $best_position = $particles[0]['position'];
                $best_fitness = $particles[0]['fitness'];
            }
            if($w > 0.3) {
                $w -= 0.0005;
            }
            else  {
                $w = 0.5;
            }
            for ($i = 0; $i < $num_particles; $i++) {
                // update the particle velocity
                for ($j = 0; $j < (count($students_pending_slot) * 5); $j++) {
                    if ( $j % 5 == 4 ) {
                        $particles[$i]['velocity'][$j] = 0;
                    }
                    else {
                        $r1 = mt_rand() / mt_getrandmax();
                        $r2 = mt_rand() / mt_getrandmax();
                        $particles[$i]['velocity'][$j] = $w * $particles[$i]['velocity'][$j]
                            + $c1 * $r1 * ($particles[$i]['best_position'][$j] - $particles[$i]['position'][$j])
                            + $c2 * $r2 * ($best_position[$j] - $particles[$i]['position'][$j]);
                    }
                }
                // update the particle position
                for ($j = 0; $j < (count($students_pending_slot) * 5); $j++) {
                    $particles[$i]['position'][$j] += $particles[$i]['velocity'][$j];
                    // handle out-of-bounds positions
                    if ($j % 5 == 0 && $particles[$i]['position'][$j] >= count($timeslots)) {
                        $particles[$i]['position'][$j] = count($timeslots) - 1;
                    } else if ($j % 5 == 1 && $particles[$i]['position'][$j] >= count($rooms)) {
                        $particles[$i]['position'][$j] = count($rooms) - 1;
                    } else if ($j % 5 == 2 && $particles[$i]['position'][$j] >= count($evaluators1)) {
                        $particles[$i]['position'][$j] = count($evaluators1) - 1;
                    } else if ($j % 5 == 3 && $particles[$i]['position'][$j] >= count($evaluators2)) {
                        $particles[$i]['position'][$j] = count($evaluators2) - 1;
                    } else if ($particles[$i]['position'][$j] < 0) {
                        $particles[$i]['position'][$j] = 0;
                    }
                }
                // update the particle fitness
                $particles[$i]['fitness'] = $this->evaluate($particles[$i]['position'], $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot);
                // update the particle's best position and fitness
                if ($particles[$i]['fitness'] > $particles[$i]['best_fitness']) {
                    $particles[$i]['best_position'] = $particles[$i]['position'];
                    $particles[$i]['best_fitness'] = $particles[$i]['fitness'];
                }
                // update the global best position and fitness
                if ($particles[$i]['fitness'] > $best_fitness) {
                    $best_position = $particles[$i]['position'];
                    $best_fitness = $particles[$i]['fitness'];
                }
                if($best_fitness == 1){
                    break;
                }
            }
            $iterations += 1; 
        }

        return $best_position;
    }

    /**
     * 
     * 
     Industrial Rubric Module
     */

    // Function to show industrial rubric list
    public function showIndustrialRubricList() {

    }

    /**
     * 
     * 
     Industrial Evaluation Module
     */

    // Function to show all evaluatable top students list
    public function showTopStudentList() {

    }
}
