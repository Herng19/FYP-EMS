<?php

namespace App\Http\Controllers;

use App\Models\Rubric;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Evaluation;
use App\Models\CriteriaMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    // Show all supervisees and evaluatees
    public function showEvaluateeList() {
        // Get all evaluatees
        $evaluatees = DB::table('evaluator_lists')
                    ->join('students', 'evaluator_lists.student_id', '=', 'students.student_id')
                    ->join('projects', 'students.student_id', '=', 'projects.student_id')
                    ->select('students.*', 'projects.project_title', 'evaluator_lists.lecturer_id')
                    ->where('evaluator_lists.lecturer_id', '=', auth()->user()->lecturer_id);

        // Get all supervisees
        $supervisees = DB::table('supervisor_lists')
                    ->join('students', 'supervisor_lists.student_id', '=', 'students.student_id')
                    ->join('projects', 'students.student_id', '=', 'projects.student_id')
                    ->select('students.*', 'projects.project_title', 'supervisor_lists.lecturer_id')
                    ->where('supervisor_lists.lecturer_id', '=', auth()->user()->lecturer_id);

        // Union both queries
        $all_evaluatees = $supervisees->unionAll($evaluatees)->paginate(10);

        // Get all marks that given by this lecturer
        $all_marks = Evaluation::where('lecturer_id', '=', auth()->user()->lecturer_id)->get();
        $all_marks_converted = array(); 

        // Convert the marks to an array with student_id as key and marks as value, if same student exist, average the marks to 100%
        foreach($all_marks as $mark) {
            if(array_key_exists($mark->student_id, $all_marks_converted)) {
                $all_marks_converted[$mark->student_id] = ($all_marks_converted[$mark->student_id] + $mark->marks)/2 ;
            }else {
                $all_marks_converted[$mark->student_id] = $mark->marks; 
            }
        }

        return view('evaluation.student_list', [
            'evaluatees' => $all_evaluatees, 
            'total_marks' => $all_marks_converted, 
        ]);
    }

    // Show evaluation form
    public function showEvaluationForm($student_id) {
        $student = Student::find($student_id);

        $supervisees = Lecturer::find(auth()->user()->lecturer_id)->supervisees->pluck('student_id')->toArray();
        $evaluatees = Lecturer::find(auth()->user()->lecturer_id)->evaluatees->pluck('student_id')->toArray();

        // Check if student is supervisee or evaluatee
        if(in_array($student_id, $supervisees)) {
            // For supervisee there will be 2 rubrics, Evaluation 1 and 3
            $rubric_1 =  Rubric::where('research_group_id', '=', $student->research_group_id)
                            ->where('psm_year', '=', $student->psm_year)
                            ->where('evaluation_type', '=', 'evaluation1')
                            ->first();

            $rubric_2 = Rubric::where('research_group_id', '=', $student->research_group_id)
                            ->where('psm_year', '=', $student->psm_year)
                            ->where('evaluation_type', '=', 'evaluation3')
                            ->first();
        }
        else if(in_array($student_id, $evaluatees)) {
            $rubric_1 =  Rubric::where('research_group_id', '=', $student->research_group_id)
                            ->where('psm_year', '=', $student->psm_year)
                            ->where('evaluation_type', '=', 'evaluation2')
                            ->first();
            $rubric_2 = null;
        }

        // If no rubric found, return
        if($rubric_1 == null) {
            return redirect()->route('evaluation')->with('error-message', 'Rubric not found');
        }

        // Get every evaluation ids for the student and this lecturer
        $evaluation_ids = Evaluation::where('student_id', '=', $student_id)
                                    ->where('lecturer_id', '=', auth()->user()->lecturer_id)
                                    ->get()
                                    ->pluck('evaluation_id')
                                    ->toArray();

        // If there is only 1 evaluation, then it is evaluation 1 or evaluation 2
        if( count($evaluation_ids) == 1 ) {
            $evaluation_id = $evaluation_ids[0];
            $evaluation_id_2 = null;
        }
        // If there is 2 evaluation, then it is evaluation 1 and evaluation 3
        else if( count($evaluation_ids) == 2 ) {
            $evaluation_id = $evaluation_ids[0];
            $evaluation_id_2 = $evaluation_ids[1];
        }
        // Else there is no evaluation
        else {
            $evaluation_id = null;
            $evaluation_id_2 = null;
        }

        // Get all recorded marks for the first evaluation (1/2)
        $marks = CriteriaMark::where('evaluation_id', '=', $evaluation_id)->get();
        $marks_keyed = $marks->mapWithKeys(function ($item) {
            return [$item['sub_criteria_id'] => $item['scale']];
        });

        // Get all recorded marks for the evaluation 3
        $marks_2 = CriteriaMark::where('evaluation_id', '=', $evaluation_id_2)->get();
        $marks_2_keyed = $marks_2->mapWithKeys(function ($item) {
            return [$item['sub_criteria_id'] => $item['scale']];
        });
        
        return view('evaluation.edit_evaluation', [
            'student' => $student,
            'rubric' => $rubric_1, 
            'rubric_2' => $rubric_2, 
            'marks' => $marks_keyed, 
            'marks_2' => $marks_2_keyed,
        ]);
    }

    // Record evaluation
    public function evaluateStudent($student_id, Request $request) {
        // Calculate total marks
        $marks = 0; 
        foreach($request->scale as $i => $mark) {
            $marks += ($request->weightage[$i])*($mark/($request->scale_num-1));
        }

        // Insert evaluation record
        $evaluation_id = Evaluation::updateOrCreate(
            ['student_id' => $student_id, 'lecturer_id' => auth()->user()->lecturer_id, 'evaluation_type' => $request->evaluation_type], 
            ['marks' => $marks]
        )->evaluation_id;

        // insert each sub criteria scale
        foreach($request->sub_criteria_id as $i => $criteria_id ) {
            CriteriaMark::updateOrCreate(
                ['sub_criteria_id' => $criteria_id, 'evaluation_id' => $evaluation_id], 
                ['scale' => $request->scale[$i]], 
            );
        }

        // Insert evaluation record for second evaluation for supervisees
        if($request->sub_criteria_id_2) {
            // Calculate total marks
            $marks_2 = 0; 
            foreach($request->scale_2 as $i => $mark) {
                $marks_2 += ($request->weightage_2[$i])*($mark/($request->scale_num_2-1));
            }

            // Insert evaluation record
            $evaluation_id = Evaluation::updateOrCreate(
                ['student_id' => $student_id, 'lecturer_id' => auth()->user()->lecturer_id, 'evaluation_type' => $request->evaluation_type_2], 
                ['marks' => $marks_2]
            )->evaluation_id;

            // insert each sub criteria scale
            foreach($request->sub_criteria_id_2 as $i => $criteria_id ) {
                CriteriaMark::updateOrCreate(
                    ['sub_criteria_id' => $criteria_id, 'evaluation_id' => $evaluation_id], 
                    ['scale' => $request->scale_2[$i]], 
                );
            }
        }

        return redirect('/evaluation')->with('success-message', 'Evaluation recorded successfully');
    }
}
