<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Venue;
use App\Models\Student;
use App\Models\Lecturer;
use App\Rules\crashVenue;
use Illuminate\Http\Request;
use App\Models\EvaluatorList;
use App\Models\EvaluationSchedule;
use Illuminate\Support\Facades\DB;
use App\Rules\evaluatorCrashTimeslot;

class EvaluationScheduleController extends Controller
{
    public function showEvaluationSchedule(Request $request) {
        if(auth('student')->check()) {
            return view('evaluation_schedule.student_schedule');
        }
        else if(auth('web')->check()) {
            if(isset($request->date) && $request->date != null) {
                session(['date' => $request->date]);
            }

            $timeslots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
            $schedules = DB::table('students')
                        ->join('projects', 'students.student_id', '=', 'projects.student_id')
                        ->join('slots', 'students.student_id', 'slots.student_id')
                        ->join('venues', 'slots.venue_id', 'venues.venue_id')
                        ->join('evaluation_schedules', 'slots.schedule_id', '=', 'evaluation_schedules.schedule_id')
                        ->select('students.student_id', 'students.name', 'projects.project_title', 'evaluation_schedules.schedule_date', 'slots.slot_id', 'slots.start_time', 'venues.venue_id', 'venues.venue_name')
                        ->where('evaluation_schedules.schedule_date', '=', session('date'))
                        ->orderBy('venues.venue_id')
                        ->get();

            $venues = Venue::all(); 

            return view('evaluation_schedule.manage_schedule', ['schedules' => $schedules, 'venues' => $venues, 'timeslots' => $timeslots]);
        }
    }

    public function viewSchedule() {
        if(auth('web')->check()) {
            $evaluatees = Lecturer::find(auth('web')->user()->lecturer_id)->evaluatees()->paginate(10);
            
            return view('evaluation_schedule.evaluator_schedule', ['evaluatees' => $evaluatees]);
        }
        else if(auth('student')->check()) {
            $student = Student::find(auth('student')->user()->student_id);
            $industrial_evaluation = null; 

            return view('evaluation_schedule.student_schedule', ['student' => $student, 'industrial_evaluation' => $industrial_evaluation]);
        }
    }

    public function newSlot(Request $request) {
        $students = Student::all()->sortBy('name');
        (isset($request->student_id))? $selected_student = Student::find($request->student_id) : ((null !== $request->old('name'))? $selected_student = Student::find($request->old('name')) : $selected_student = Student::all()->sortBy('name')->first());
 

        $venues = Venue::all();
        $timeslots = ['8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $available_evaluators = Lecturer::where('research_group_id', $selected_student->research_group_id)->get();

        return view('evaluation_schedule.create_slot', ["students" => $students, 
                                                "selected_student" => $selected_student, 
                                                "venues" => $venues, 
                                                "timeslots" => $timeslots, 
                                                "available_evaluators" => $available_evaluators]);
    }

    public function createSlot(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'unique:App\Models\Slot,student_id'],
            'venue' => ['required',  new crashVenue],
            'date' => ['required', 'date'], 
            'timeslot' => 'required',
            'evaluator1' => ['required', 'different:evaluator2',  new evaluatorCrashTimeslot], 
            'evaluator2' => ['required', 'different:evaluator1',  new evaluatorCrashTimeslot]
        ], ['name.unique' => 'Student has already been assigned a slot']); 

        $date = $formFields['date'];
        $time = $formFields['timeslot'];
        $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        $end_time_converted = date('H:i:s', strtotime($time) + 30*60);
        $end_time = date('Y-m-d H:i:s', strtotime("$date $end_time_converted"));
        $schedule = EvaluationSchedule::where('schedule_date', "=", $date)->first();
        $schedule !== null ? $schedule = $schedule : $schedule = EvaluationSchedule::create(['schedule_date' => $date]);

        Slot::create([
            'student_id' => $formFields['name'],
            'venue_id' => $formFields['venue'],
            'schedule_id' => $schedule->schedule_id, 
            'start_time' => $start_time,
            'end_time' => $end_time, 
        ]);

        EvaluatorList::create([
            'student_id' => $formFields['name'],
            'lecturer_id' => $formFields['evaluator1']
        ]); 

        EvaluatorList::create([
            'student_id' => $formFields['name'],
            'lecturer_id' => $formFields['evaluator2']
        ]); 

        return redirect('/evaluation schedule')->with('success-message', 'Slot Created Successfully');
    }

    public function editSlot($slot_id, Request $request) {
        $students = Student::all()->sortBy('name');
        $slot = Slot::find($slot_id);

        isset($request->student_id) ? $selected_student = Student::find($request->student_id) : $selected_student = Student::find($slot->student_id);

        $evaluators = $selected_student->evaluators->toArray();
        $venues = Venue::all();
        $timeslots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $available_evaluators = Lecturer::where('research_group_id', $selected_student->research_group_id)->get();

        return view('evaluation_schedule.edit_slot', ["students" => $students, 
                                                "slot" => $slot,
                                                "selected_student" => $selected_student, 
                                                "venues" => $venues, 
                                                "timeslots" => $timeslots, 
                                                "evaluators" => $evaluators, 
                                                "available_evaluators" => $available_evaluators]);
    }

    public function updateSlot($slot_id, Request $request) { 
        $formFields = $request->validate([
            'name' => ['required'],
            'venue' => ['required',  new crashVenue],
            'date' => ['required', 'date'], 
            'timeslot' => 'required',
            'evaluator1' => ['required', 'different:evaluator2',  new evaluatorCrashTimeslot], 
            'evaluator2' => ['required', 'different:evaluator1',  new evaluatorCrashTimeslot]
        ]); 

        $date = $formFields['date'];
        $time = $formFields['timeslot'];
        $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        $end_time_converted = date('H:i:s', strtotime($time) + 30*60);
        $end_time = date('Y-m-d H:i:s', strtotime("$date $end_time_converted"));
        $schedule = EvaluationSchedule::where('schedule_date', "=", $date)->first();
        $schedule !== null ? $schedule = $schedule : $schedule = EvaluationSchedule::create(['schedule_date' => $date]);
        
        $slot = Slot::find($slot_id);
        $evaluators = EvaluatorList::where('student_id', "=", $slot->student_id)->limit(2)->get();

        if($evaluators === null) {
            EvaluatorList::create([
                'student_id' => $formFields['name'],
                'lecturer_id' => $formFields['evaluator1']
            ]); 
    
            EvaluatorList::create([
                'student_id' => $formFields['name'],
                'lecturer_id' => $formFields['evaluator2']
            ]); 
        }
        else {
            foreach($evaluators as $i => $evaluator) {
                EvaluatorList::where('evaluator_list_id', '=', $evaluator->evaluator_list_id)->update([
                    'lecturer_id' => $formFields['evaluator' . ($i + 1)]
                ]);
            }
        }

        $slot->update([
            'student_id' => $formFields['name'],
            'venue_id' => $formFields['venue'],
            'schedule_id' => $schedule->schedule_id, 
            'start_time' => $start_time,
            'end_time' => $end_time, 
        ]);
        
        return back()->with('success-message', 'Slot Updated Successfully');
    }

    public function deleteSlot($slot_id) {
        $slot = Slot::find($slot_id);
        EvaluatorList::where('student_id', '=', $slot->student_id)->delete();
 
        $slot->delete();
        return redirect('/evaluation schedule')->with('success-message', 'Slot Deleted Successfully');
    }

    public function scheduleEvaluationSchedule(Request $request) {
        $global_best_position = $this->particle_swarm_optimization();
        $schedule = array();
        for ($i = 0; $i < count($global_best_position); $i += 4) {
            $timeslot = $timeslots[$global_best_position[$i]];
            $room = $rooms[$global_best_position[$i + 1]];
            $evaluator1 = $evaluators1[$global_best_position[$i + 2]];
            $evaluator2 = $evaluators2[$global_best_position[$i + 3]];
            $schedule[] = array($timeslot, $room, $evaluator1, $evaluator2);
        }

        foreach ($schedule as $i => $slot) {
            echo $i+1 . " " . $slot[0] . " " .$slot[1] . " " . $slot[2] . " " . $slot[3] . "\n";
        }
    }

    private function evaluate($position) {
        global $timeslots, $rooms, $evaluators1, $evaluators2;
        $schedule = array();
        $evaluator_student_counts = array();
    
        for ($i = 0; $i < count($position); $i += 4) {
            $timeslot = $timeslots[$position[$i]];
            $room = $rooms[$position[$i + 1]];
            $evaluator1 = $evaluators1[$position[$i + 2]];
            $evaluator2 = $evaluators2[$position[$i + 3]];
            $schedule[] = array($timeslot, $room, $evaluator1, $evaluator2);
    
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
        $max_student_count = max($evaluator_student_counts);
        $min_student_count = min($evaluator_student_counts);
        $balance_penalty = $max_student_count - $min_student_count;
        
        if($balance_penalty > 1) {
            $cost += 1;
        }
    
        return 1 / ($cost + 1); // minimize conflicts
    }

    // initialize the particles
    private function generate_particles() {
        $particles = array();
        global $timeslots, $rooms, $evaluators1, $evaluators2, $num_particles;
        for ($i = 0; $i < $num_particles; $i++) {
            $position = array();
            for ($j = 0; $j < 10; $j++) {
                $position[] = rand(0, count($timeslots) - 1);
                $position[] = rand(0, count($rooms) - 1);
                $position[] = rand(0, count($evaluators1) - 1);
                $position[] = rand(0, count($evaluators2) - 1);
            }
            $particles[] = array(
                'position' => $position,
                'velocity' => array_fill(0, 40, 0),
                'best_position' => $position,
                'best_fitness' => $this->evaluate($position),
                'fitness' => $this->evaluate($position)
            );
        }
        return $particles; 
    }

    private function particle_swarm_optimization() {
        // initialize the global best position and fitness
        global $num_particles, $timeslots, $rooms, $evaluators1, $evaluators2; 
    
        // PSO parameters
        $c1 = 3.0;
        $c2 = 1.0;
        $w = 0.5;
        $particles = $this->generate_particles();
        $best_position = $particles[0]['position'];
        $best_fitness = $particles[0]['fitness'];
        $iterations = 0; 
    
        // run the PSO algorithm
        while($best_fitness < 1 ) {
            if($best_fitness < 0 && $iterations == 100) {
                $iterations = 0;
                $particles = $this->generate_particles();
                $best_position = $particles[0]['position'];
                $best_fitness = $particles[0]['fitness'];
            }
            for ($i = 0; $i <$num_particles; $i++) {
                // update the particle velocity
                for ($j = 0; $j < 40; $j++) {
                    $r1 = mt_rand() / mt_getrandmax();
                    $r2 = mt_rand() / mt_getrandmax();
                    $particles[$i]['velocity'][$j] = $w * $particles[$i]['velocity'][$j]
                        + $c1 * $r1 * ($particles[$i]['best_position'][$j] - $particles[$i]['position'][$j])
                        + $c2 * $r2 * ($best_position[$j] - $particles[$i]['position'][$j]);
                }
                // update the particle position
                for ($j = 0; $j < 40; $j++) {
                    $particles[$i]['position'][$j] += $particles[$i]['velocity'][$j];
                    // handle out-of-bounds positions
                    if ($j % 4 == 0 && $particles[$i]['position'][$j] >= count($timeslots)) {
                        $particles[$i]['position'][$j] = count($timeslots) - 1;
                    } else if ($j % 4 == 1 && $particles[$i]['position'][$j] >= count($rooms)) {
                        $particles[$i]['position'][$j] = count($rooms) - 1;
                    } else if ($j % 4 == 2 && $particles[$i]['position'][$j] >= count($evaluators1)) {
                        $particles[$i]['position'][$j] = count($evaluators1) - 1;
                    } else if ($j % 4 == 3 && $particles[$i]['position'][$j] >= count($evaluators2)) {
                        $particles[$i]['position'][$j] = count($evaluators2) - 1;
                    } else if ($particles[$i]['position'][$j] < 0) {
                        $particles[$i]['position'][$j] = 0;
                    }
                }
                // update the particle fitness
                $particles[$i]['fitness'] = $this->evaluate($particles[$i]['position']);
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


}
