<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 300);

use App\Models\Slot;
use App\Models\Booth;
use App\Models\Venue;
use App\Models\Student;
use App\Models\Lecturer;
use App\Rules\crashVenue;
use Illuminate\Http\Request;
use App\Models\EvaluatorList;
use App\Models\SupervisorList;
use App\Models\EvaluationSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Rules\evaluatorCrashTimeslot;
use App\Rules\evaluatorCrashSupervisor;

class EvaluationScheduleController extends Controller
{
    // Function to show evalaution schedule
    public function showEvaluationSchedule(Request $request) {
        if(auth('student')->check()) {
            return view('evaluation_schedule.student_schedule');
        }
        else if(auth('web')->check()) {
            if(isset($request->date) && $request->date != null) {
                session(['date' => $request->date]);
            }
            if(isset($request->psm_year) && $request->psm_year != null) {
                session(['psm_year' => $request->psm_year]);
            }

            $timeslots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
            if(session('psm_year') == '1') {
                $schedules = DB::table('students')
                            ->join('slots', 'students.student_id', 'slots.student_id')
                            ->join('venues', 'slots.venue_id', 'venues.venue_id')
                            ->join('evaluation_schedules', 'slots.schedule_id', '=', 'evaluation_schedules.schedule_id')
                            ->select('students.student_id', 'students.name', 'slots.slot_id', 'slots.start_time', 'venues.venue_id', 'venues.venue_name')
                            ->where('evaluation_schedules.schedule_date', '=', session('date'))
                            ->where('students.psm_year', '=', session('psm_year'))
                            ->orderBy('venues.venue_id')
                            ->get();
            }
            else {
                $schedules = DB::table('students')
                ->join('slots', 'students.student_id', 'slots.student_id')
                ->join('booths', 'slots.booth_id', 'booths.booth_id')
                ->join('evaluation_schedules', 'slots.schedule_id', '=', 'evaluation_schedules.schedule_id')
                ->select('students.student_id', 'students.name', 'slots.slot_id', 'slots.start_time', 'booths.booth_id as venue_id', 'booths.booth_name as venue_name')
                ->where('evaluation_schedules.schedule_date', '=', session('date'))
                ->where('students.psm_year', '=', session('psm_year'))
                ->orderBy('booths.booth_id')
                ->get();
            }

            (session('psm_year') == '1')? $venues = Venue::all() : $venues = Booth::all(); 

            return view('evaluation_schedule.manage_schedule', ['schedules' => $schedules, 'venues' => $venues, 'timeslots' => $timeslots]);
        }
    }

    // Function to show evaluator schedule or student schedule
    public function viewSchedule() {
        if(auth('web')->check()) {
            if(Auth::user()->hasRole('supervisor')) {
                $evaluatees = Lecturer::find(auth('web')->user()->lecturer_id)->evaluatees()->paginate(10);

                return view('evaluation_schedule.evaluator_schedule', ['evaluatees' => $evaluatees]);
            }
            else {
                $students_had_slot = Slot::all()->pluck('student_id')->toArray();
                $evaluatees = Student::where('research_group_id', '=', auth()->user()->research_group->research_group_id)
                            ->whereIn('student_id', $students_had_slot)
                            ->orderBy('psm_year')
                            ->paginate(10);

                return view('evaluation_schedule.evaluator_schedule', ['evaluatees' => $evaluatees]);
            }
        }
        else if(auth('student')->check()) {
            $student = Student::find(auth('student')->user()->student_id);
            $industrial_evaluation = null; 

            return view('evaluation_schedule.student_schedule', ['student' => $student, 'industrial_evaluation' => $industrial_evaluation]);
        }
    }

    // Function to show create slot form
    public function newSlot(Request $request) {
        $students = Student::all()->sortBy('name');
        (isset($request->student_id))? $selected_student = Student::find($request->student_id) : ((null !== $request->old('name'))? $selected_student = Student::find($request->old('name')) : $selected_student = Student::all()->sortBy('name')->first());
 

        ($selected_student->psm_year == 1)? $venues = Venue::all() : $venues = Booth::all();
        $timeslots = ['8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $available_evaluators = Lecturer::where('research_group_id', $selected_student->research_group_id)->role('evaluator')->get();

        return view('evaluation_schedule.create_slot', ["students" => $students, 
                                                "selected_student" => $selected_student, 
                                                "venues" => $venues, 
                                                "timeslots" => $timeslots, 
                                                "available_evaluators" => $available_evaluators]);
    }

    // Function to create slot
    public function createSlot(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'unique:App\Models\Slot,student_id'],
            'venue' => ['required',  new crashVenue],
            'date' => ['required', 'date'], 
            'timeslot' => 'required',
            'evaluator1' => ['required', 'different:evaluator2',  new evaluatorCrashTimeslot, new evaluatorCrashSupervisor], 
            'evaluator2' => ['required', 'different:evaluator1',  new evaluatorCrashTimeslot, new evaluatorCrashSupervisor]
        ], ['name.unique' => 'Student has already been assigned a slot']); 

        $date = $formFields['date'];
        $time = $formFields['timeslot'];
        $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        $end_time_converted = date('H:i:s', strtotime($time) + 30*60);
        $end_time = date('Y-m-d H:i:s', strtotime("$date $end_time_converted"));
        $schedule = EvaluationSchedule::firstOrCreate(['schedule_date' => $date]);

        $psm_year = Student::find($formFields['name'])->psm_year;

        if($psm_year == '1') {
            Slot::create([
                'student_id' => $formFields['name'],
                'venue_id' => $formFields['venue'],
                'schedule_id' => $schedule->schedule_id, 
                'start_time' => $start_time,
                'end_time' => $end_time, 
            ]);
        }
        else {
            Slot::create([
                'student_id' => $formFields['name'],
                'booth_id' => $formFields['venue'],
                'schedule_id' => $schedule->schedule_id, 
                'start_time' => $start_time,
                'end_time' => $end_time, 
            ]);
        }

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

    // Function to show edit slot form
    public function editSlot($slot_id, Request $request) {
        $slot = Slot::find($slot_id);

        isset($request->student_id) ? $selected_student = Student::find($request->student_id) : $selected_student = Student::find($slot->student_id);
        $students = Student::where('psm_year', '=', $selected_student->psm_year)->get()->sortBy('name');

        $evaluators = $selected_student->evaluators->toArray();
        ($selected_student->psm_year == '1')? $venues = Venue::all() : $venues = Booth::all();
        $timeslots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $available_evaluators = Lecturer::where('research_group_id', $selected_student->research_group_id)->role('evaluator')->get();

        return view('evaluation_schedule.edit_slot', ["students" => $students, 
                                                "slot" => $slot,
                                                "selected_student" => $selected_student, 
                                                "venues" => $venues, 
                                                "timeslots" => $timeslots, 
                                                "evaluators" => $evaluators, 
                                                "available_evaluators" => $available_evaluators]);
    }

    // Function to update slot
    public function updateSlot($slot_id, Request $request) { 
        $formFields = $request->validate([
            'name' => ['required'],
            'venue' => ['required',  new crashVenue],
            'date' => ['required', 'date'], 
            'timeslot' => 'required',
            'evaluator1' => ['required', 'different:evaluator2',  new evaluatorCrashTimeslot, new evaluatorCrashSupervisor], 
            'evaluator2' => ['required', 'different:evaluator1',  new evaluatorCrashTimeslot, new evaluatorCrashSupervisor]
        ]); 

        $date = $formFields['date'];
        $time = $formFields['timeslot'];
        $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
        $end_time_converted = date('H:i:s', strtotime($time) + 30*60);
        $end_time = date('Y-m-d H:i:s', strtotime("$date $end_time_converted"));
        $schedule = EvaluationSchedule::firstOrCreate(['schedule_date' => $date]);
        
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

        $psm_year = Student::find($formFields['name'])->psm_year;

        if($psm_year == '1') {
            Slot::create([
                'student_id' => $formFields['name'],
                'venue_id' => $formFields['venue'],
                'schedule_id' => $schedule->schedule_id, 
                'start_time' => $start_time,
                'end_time' => $end_time, 
            ]);
        }
        else {
            Slot::create([
                'student_id' => $formFields['name'],
                'booth_id' => $formFields['venue'],
                'schedule_id' => $schedule->schedule_id, 
                'start_time' => $start_time,
                'end_time' => $end_time, 
            ]);
        }
        
        return back()->with('success-message', 'Slot Updated Successfully');
    }

    // Function to delete slot
    public function deleteSlot($slot_id) {
        $slot = Slot::find($slot_id);
        EvaluatorList::where('student_id', '=', $slot->student_id)->delete();
 
        $slot->delete();
        return redirect('/evaluation schedule')->with('success-message', 'Slot Deleted Successfully');
    }

    // Function to schedule evaluation schedule
    public function scheduleEvaluationSchedule(Request $request) {
        // Clear schdule on requested date
        $schedule_id = EvaluationSchedule::whereDate('schedule_date', $request->date)->pluck('schedule_id')->first();

        // If schedule does not exist, create new schedule
        ($schedule_id !== null)? $schedule_id = $schedule_id : $schedule_id = EvaluationSchedule::create(['schedule_date' => $request->date])->schedule_id;

        // Get all students that scheduled on requested date
        $students_on_schedule_date = Slot::whereDate('start_time', $request->date)->pluck('student_id');

        foreach($students_on_schedule_date as $student) {
            // Determine student's psm year
            $psm_year = Student::find($student)->psm_year; 

            // If student's psm year == requested psm year, delete student's slot and evaluator list
            if($psm_year == $request->psm_year) {
                EvaluatorList::where('student_id', '=', $student)->delete();
                Student::find($student)->slot()->delete(); 
            }
        }

        // Initiate variables for timeslots, particles num
        $timeslots = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '14:00', '14:30','15:00', '15:30','16:00', '16:30','17:00', '17:30'];
        $rooms_available = Venue::all()->pluck('venue_id')->toArray();
        $total_rooms_count = count($rooms_available);
        $rooms = array();
        $num_particles = 100;
        $stud_num = 0; 

        // for each research group, schedule students without slot, max 200 students overall
        define("STUD_NUM", 300);

        // If psm year == 1, schedule as the way of psm 1
        if($request->psm_year == '1') {
            for ($i = 0; $i < ($total_rooms_count*count($timeslots)); $i += (count($rooms)*count($timeslots))) {
                // Getting all variables 
                $students_had_slot = Slot::all()->pluck('student_id')->toArray();

                $first_stud_no_slot = Student::whereNotIn('student_id', $students_had_slot)
                                            ->where('psm_year', '=', $request->psm_year)
                                            ->first();

                // If all students have been scheduled, break
                if($first_stud_no_slot === null) {
                    break;
                }

                $students_pending_slot = Student::whereNotIn('student_id', $students_had_slot)
                                    ->where('research_group_id', '=', $first_stud_no_slot->research_group_id)
                                    ->where('psm_year', '=', $request->psm_year)
                                    ->limit(count($rooms_available)*count($timeslots))
                                    ->pluck('student_id')
                                    ->toArray();

                $stud_num = count($students_pending_slot);

                $rooms = array_slice($rooms_available, 0, ceil($stud_num/count($timeslots)));
                array_splice($rooms_available, 0, ceil($stud_num/count($timeslots)));

                $evaluators1 = array();
                $evaluators2 = array();

                // Only return avaialble evaluator (Except student's supervisor)
                foreach ($students_pending_slot as $student) {
                    $supervisor_id = SupervisorList::where('student_id', '=', $student)->pluck('lecturer_id')->toArray();
                    $evaluators1[] = Lecturer::where('research_group_id', '=', $first_stud_no_slot->research_group_id)
                                            ->role('evaluator')
                                            ->whereNotIn('lecturer_id', $supervisor_id)
                                            ->pluck('lecturer_id')
                                            ->toArray();
                }
                $evaluators2 = $evaluators1;

                // Checking if then number of students is larger than available slots
                if((count($rooms)*16) < count($students_pending_slot)) {
                    break; 
                }

                // Get the schedule for a research group
                $global_best_position = $this->particle_swarm_optimization($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot);
                $schedule = array();
                for ($i = 0; $i < count($global_best_position); $i += 5) {
                    $timeslot = $timeslots[$global_best_position[$i]];
                    $room = $rooms[$global_best_position[$i + 1]];
                    $evaluator1 = $evaluators1[$i/5][$global_best_position[$i + 2]];
                    $evaluator2 = $evaluators2[$i/5][$global_best_position[$i + 3]];
                    $student = $students_pending_slot[$global_best_position[$i + 4]];
                    $schedule[] = array($timeslot, $room, $evaluator1, $evaluator2, $student);
                }

                // Foreach student, insert data into slots, and evaluator list
                foreach($schedule as $slot) {
                    $start_time = date('Y-m-d H:i:s', strtotime("$request->date $slot[0]"));
                    $end_time = date('Y-m-d H:i:s', strtotime("$request->date $slot[0]") + 30*60);

                    Slot::create([
                        'student_id' => $slot[4],
                        'venue_id' => $slot[1],
                        'schedule_id' => $schedule_id, 
                        'start_time' => $start_time,
                        'end_time' => $end_time, 
                    ]);

                    EvaluatorList::create([
                        'student_id' => $slot[4],
                        'lecturer_id' => $slot[2]
                    ]);

                    EvaluatorList::create([
                        'student_id' => $slot[4],
                        'lecturer_id' => $slot[3]
                    ]);
                }
            }
        }
        // else if psm year == 2. schedule as the way of psm 2 (1 student per booth)
        else if($request->psm_year == '2') {
            $all_booths = Booth::all()->pluck('booth_id')->toArray();
            // Schedule students without slot for PSM 2
            for ($i = 0; $i < count($all_booths); $i += $stud_num) {
                // Getting all variables 
                $students_had_slot = Slot::all()->pluck('student_id')->toArray();

                $first_stud_no_slot = Student::whereNotIn('student_id', $students_had_slot)
                                            ->where('psm_year', '=', $request->psm_year)
                                            ->first();
                                            
                // If all students have been scheduled, break
                if($first_stud_no_slot === null) {
                    break;
                }

                $students_pending_slot = Student::whereNotIn('student_id', $students_had_slot)
                                    ->where('research_group_id', '=', $first_stud_no_slot->research_group_id)
                                    ->where('psm_year', '=', $request->psm_year)
                                    ->limit(STUD_NUM-$i)
                                    ->pluck('student_id')
                                    ->toArray();

                $stud_num = count($students_pending_slot);
                $evaluators1 = array();
                $evaluators2 = array();

                // Only return avaialble evaluator (Except student's supervisor)
                foreach ($students_pending_slot as $student) {
                    $supervisor_id = SupervisorList::where('student_id', '=', $student)->pluck('lecturer_id')->toArray();
                    $evaluators1[] = Lecturer::where('research_group_id', '=', $first_stud_no_slot->research_group_id)
                                            ->role('evaluator')
                                            ->whereNotIn('lecturer_id', $supervisor_id)
                                            ->pluck('lecturer_id')
                                            ->toArray();
                }
                $evaluators2 = $evaluators1;

                // Get available booth
                $booths_taken = Slot::where("booth_id", "!=", null)->pluck('booth_id')->toArray();
                $booths_available = Booth::WhereNotIn('booth_id', $booths_taken)->pluck('booth_id')->toArray();

                // Get the schedule for a research group
                $global_best_position = $this->particle_swarm_optimization_psm2($num_particles, $timeslots, $evaluators1, $evaluators2, $students_pending_slot);
                $schedule = array();
                for ($i = 0; $i < count($global_best_position); $i += 4) {
                    $timeslot = $timeslots[$global_best_position[$i]];
                    $evaluator1 = $evaluators1[$i/5][$global_best_position[$i + 1]];
                    $evaluator2 = $evaluators2[$i/5][$global_best_position[$i + 2]];
                    $student = $students_pending_slot[$global_best_position[$i + 3]];
                    $schedule[] = array($timeslot, $evaluator1, $evaluator2, $student);
                }

                // Foreach student, insert data into slots, and evaluator list

                foreach($schedule as $i => $slot) {
                    $start_time = date('Y-m-d H:i:s', strtotime("$request->date $slot[0]"));
                    $end_time = date('Y-m-d H:i:s', strtotime("$request->date $slot[0]") + 30*60);

                    Slot::create([
                        'student_id' => $slot[3],
                        'booth_id' => $booths_available[$i],
                        'schedule_id' => $schedule_id, 
                        'start_time' => $start_time,
                        'end_time' => $end_time, 
                    ]);

                    EvaluatorList::create([
                        'student_id' => $slot[3],
                        'lecturer_id' => $slot[1]
                    ]);

                    EvaluatorList::create([
                        'student_id' => $slot[3],
                        'lecturer_id' => $slot[2]
                    ]);
                }
            }
        }

        return redirect('/evaluation schedule')->with('success-message', 'Schedule Created Successfully');
    }

    // Evaluation function to evaluate psm 1 schedule generated
    private function evaluate($position, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot) {
        $schedule = array();
        $evaluator_student_counts = array();

    
        for ($i = 0; $i < count($position); $i += 5) {
            $timeslot = $timeslots[$position[$i]];
            $room = $rooms[$position[$i + 1]];
            $evaluator1 = $evaluators1[$i/5][$position[$i + 2]];
            $evaluator2 = $evaluators2[$i/5][$position[$i + 3]];
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
        
        // if($balance_penalty > 3) {
        //     $cost += 1;
        // }
    
        return 1 / ($cost + 1); // minimize conflicts
    }

    // initialize the particles for psm 1 schedule
    private function generate_particles($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot) {
        $particles = array();
        for ($i = 0; $i < $num_particles; $i++) {
            $position = array();
            for ($j = 0; $j < count($students_pending_slot); $j++) {
                $position[] = $j%16;
                $position[] = rand(0, count($rooms) - 1);
                $position[] = rand(0, count($evaluators1[$j]) - 1);
                $position[] = rand(0, count($evaluators2[$j]) - 1);
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

    // PSO algorithm for psm 1 schedule
    private function particle_swarm_optimization($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot) {   
        // PSO parameters
        $c1 = 3.0;
        $c2 = 1.0;
        $w = 0.5;
        $particles = $this->generate_particles($num_particles, $timeslots, $rooms, $evaluators1, $evaluators2, $students_pending_slot);
        $best_position = $particles[0]['position'];
        $best_fitness = $particles[0]['fitness'];
        $iterations = 0; 
        $max_iteration = 0;
    
        // run the PSO algorithm
        while($best_fitness < 1 ) {
            if(count($students_pending_slot)>15) {
                $max_iteration = 1000;
                $c1 = 2.5; 
                $c2 = 1.5; 
                $w = 0.7; 
            }
            else {
                $max_iteration = 100; 
            }

            if($iterations >= $max_iteration) {
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
                    } else if ($j % 5 == 2 && $particles[$i]['position'][$j] >= count($evaluators1[floor($j/5)])) {
                        $particles[$i]['position'][$j] = count($evaluators1[floor($j/5)]) - 1;
                    } else if ($j % 5 == 3 && $particles[$i]['position'][$j] >= count($evaluators2[floor($j/5)])) {
                        $particles[$i]['position'][$j] = count($evaluators2[floor($j/5)]) - 1;
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

    // Evaluation function to evaluate psm 2 schedule generated
    private function evaluate_psm2($position, $timeslots, $evaluators1, $evaluators2, $students_pending_slot) {
        $schedule = array();
        $evaluator_student_counts = array();

    
        for ($i = 0; $i < count($position); $i += 4) {
            $timeslot = $timeslots[$position[$i]];
            $evaluator1 = $evaluators1[$i/5][$position[$i + 1]];
            $evaluator2 = $evaluators2[$i/5][$position[$i + 2]];
            $student = $students_pending_slot[$position[$i + 3]];
            $schedule[] = array($timeslot, $evaluator1, $evaluator2, $student);
    
            $evaluator_student_counts[$evaluator1] = 0;
            $evaluator_student_counts[$evaluator2] = 0;
        }
    
        // calculate the cost of the schedule
        $cost = 0;
        for ($i = 0; $i < count($schedule); $i++) {
            $conflicts = 0;
            
            // count the number of students assigned to each evaluator
            $evaluator_student_counts[$schedule[$i][1]]++;
            $evaluator_student_counts[$schedule[$i][2]]++;
            
            for ($j = $i + 1; $j < count($schedule); $j++) {
                // check for timeslot/venue/evaluators conflicts
                if($schedule[$i][1] == $schedule[$i][2] || $schedule[$j][1] == $schedule[$j][2]){
                    $conflicts++;
                }
                else if ($schedule[$i][1] == $schedule[$j][2] || $schedule[$i][2] == $schedule[$j][1] || $schedule[$i][1] == $schedule[$j][1] || $schedule[$i][2] == $schedule[$j][2]) {
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

    // initialize the particles for psm 2 schedule
    private function generate_particles_psm2($num_particles, $timeslots, $evaluators1, $evaluators2, $students_pending_slot) {
        $particles = array();
        for ($i = 0; $i < $num_particles; $i++) {
            $position = array();
            for ($j = 0; $j < count($students_pending_slot); $j++) {
                $position[] = rand(0, count($timeslots) - 1);
                $position[] = rand(0, count($evaluators1[$j]) - 1);
                $position[] = rand(0, count($evaluators2[$j]) - 1);
                $position[] = $j;
            }
            $particles[] = array(
                'position' => $position,
                'velocity' => array_fill(0, count($students_pending_slot)*4, 0),
                'best_position' => $position,
                'best_fitness' => $this->evaluate_psm2($position, $timeslots, $evaluators1, $evaluators2, $students_pending_slot),
                'fitness' => $this->evaluate_psm2($position, $timeslots, $evaluators1, $evaluators2, $students_pending_slot)
            );
        }
        return $particles; 
    }

    // PSO algorithm for psm 2 schedule
    private function particle_swarm_optimization_psm2($num_particles, $timeslots, $evaluators1, $evaluators2, $students_pending_slot) {   
        // PSO parameters
        $c1 = 3.0;
        $c2 = 1.0;
        $w = 0.5;
        $particles = $this->generate_particles_psm2($num_particles, $timeslots, $evaluators1, $evaluators2, $students_pending_slot);
        $best_position = $particles[0]['position'];
        $best_fitness = $particles[0]['fitness'];
        $iterations = 0; 
    
        // run the PSO algorithm
        while($best_fitness < 1 ) {
            if($iterations >= 500) {
                $iterations = 0;
                $particles = $this->generate_particles_psm2($num_particles, $timeslots, $evaluators1, $evaluators2, $students_pending_slot);
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
                for ($j = 0; $j < (count($students_pending_slot) * 4); $j++) {
                    if ( $j % 4 == 3 ) {
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
                for ($j = 0; $j < (count($students_pending_slot) * 4); $j++) {
                    $particles[$i]['position'][$j] += $particles[$i]['velocity'][$j];
                    // handle out-of-bounds positions
                    if ($j % 4 == 0 && $particles[$i]['position'][$j] >= count($timeslots)) {
                        $particles[$i]['position'][$j] = count($timeslots) - 1;
                    } else if ($j % 4 == 1 && $particles[$i]['position'][$j] >= count($evaluators1[floor($j/4)])) {
                        $particles[$i]['position'][$j] = count($evaluators1[floor($j/4)]) - 1;
                    } else if ($j % 4 == 2 && $particles[$i]['position'][$j] >= count($evaluators2[floor($j/4)])) {
                        $particles[$i]['position'][$j] = count($evaluators2[floor($j/4)]) - 1;
                    } else if ($particles[$i]['position'][$j] < 0) {
                        $particles[$i]['position'][$j] = 0;
                    }
                }
                // update the particle fitness
                $particles[$i]['fitness'] = $this->evaluate_psm2($particles[$i]['position'], $timeslots, $evaluators1, $evaluators2, $students_pending_slot);
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
