<?php

namespace App\Http\Controllers;

use App\Models\CoLevel;
use App\Models\Student;
use App\Models\Evaluation;
use App\Models\SubCriteria;
use App\Models\CriteriaMark;
use Illuminate\Http\Request;
use App\Models\CriteriaScale;
use Illuminate\Support\Facades\DB;
use App\Models\IndustrialEvaluation;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ReportController extends Controller
{
    public function showReport() {
        if(auth('web')->check()) {
            if(auth()->user()->hasRole('supervisor')) {
                // Get lecturer's supervisees
                $lecturer = auth()->user();
                $supervisees = $lecturer->supervisees; 
                $all_supervisee_marks = [];
                $all_students_grade = [];
                $all_students_co = [];

                // Get all supervisee marks
                foreach($supervisees as $supervisee) {
                    $total_mark = 0; 

                    // Get student name
                    $student_name = Student::where('student_id', $supervisee->student_id)->first()->name;

                    // Get total marks for that student
                    $supervisee_marks = Evaluation::where('student_id', $supervisee->student_id)->get();

                    // Calculate the total marks for the student of psm 1
                    if($supervisee->psm_year == 1) {
                        foreach($supervisee_marks as $mark) {
                            if($mark->evaluation_type == 'evaluation2') {
                                $total_mark += $mark->marks * 0.2;
                            }
                            else {
                                $total_mark += $mark->marks * 0.3;
                            }
                        }
                    }
                    else {
                        foreach($supervisee_marks as $mark) {
                            if($mark->evaluation_type == 'evaluation3') {
                                $total_mark += $mark->marks * 0.4;
                            }
                            else {
                                $total_mark += $mark->marks * 0.2;
                            }
                        }
                    }

                    // Insert into array
                    $all_supervisee_marks[$student_name] = $total_mark;
                }

                return view('report.report_and_progress', compact('all_supervisee_marks'));
            }
            // If user is coordinator, get data for all student's grade and co level
            else if(auth()->user()->hasRole('coordinator')) {
                $research_group_pass = [];
                $research_group_fail = [];
                $all_students_grade = ['A' => 0, 'A-' => 0, 'B+' => 0, 'B' => 0, 'B-' => 0, 'C+' => 0, 'C' => 0, 'F' => 0]; 
                $evaluated_students = Evaluation::all()->groupBy('student_id'); 

                // For each student, calculate the total marks and add the grade number to the array
                foreach($evaluated_students as $student_id => $evaluations) {
                    $psm_year = Student::where('student_id', $student_id)->first()->psm_year;
                    $total_marks = 0; 

                    // For each evaluations of that student, calculate the total marks
                    foreach($evaluations as $evaluation) {
                        if($evaluation->evaluation_type == 'evaluation2') {
                            $total_marks += $evaluation->marks * 0.2;
                        }
                        else {
                            // for evaluation 1 and 3 for psm 1, both are 30%
                            if($psm_year == 1) {
                                $total_marks += $evaluation->marks * 0.3;
                            }
                            else {
                                // for evaluation 1 for PSM 2 is 20%, evaluation 3 is 40%
                                if($evaluation->evaluation_type == 'evaluation3') {
                                    $total_marks += $evaluation->marks * 0.4;
                                }
                                else {
                                    $total_marks += $evaluation->marks * 0.2;
                                }
                            }
                        }
                    }

                    $research_group = Student::where('student_id', $student_id)->first()->research_group->research_group_short_form;

                    // Add pass/fail to the research gorup
                    if($total_marks >= 40) {
                        (isset($research_group_pass[$research_group])) ? $research_group_pass[$research_group] += 1 : $research_group_pass[$research_group] = 1;
                    }
                    else {
                        (isset($research_group_fail[$research_group])) ? $research_group_fail[$research_group] += 1 : $research_group_fail[$research_group] = 1;
                    }

                    // Add the grade number to the array
                    switch ($total_marks) {
                        case $total_marks >= 80:
                            $all_students_grade['A'] += 1;
                            break;
                        case $total_marks >= 75:
                            $all_students_grade['A-'] += 1;
                            break;
                        case $total_marks >= 70:
                            $all_students_grade['B+'] += 1;
                            break;
                        case $total_marks >= 65:
                            $all_students_grade['B'] += 1;
                            break;
                        case $total_marks >= 60:
                            $all_students_grade['B-'] += 1;
                            break;
                        case $total_marks >= 55:
                            $all_students_grade['C+'] += 1;
                            break;
                        case $total_marks >= 50:
                            $all_students_grade['C'] += 1;
                            break;
                        default:
                            $all_students_grade['F'] += 1;
                    }


                }

                // Initiate the CO array
                $all_students_co = [];
                $co_levels = CoLevel::all()->count();

                for($i = 1; $i <= $co_levels; $i++) {
                    $all_students_co['CO'.$i] = 0;
                }

                // Get all students' co level
                foreach($evaluated_students as $student_id => $evaluations) {
                    // Initiate the CO array for that student
                    $co_levels = CoLevel::all()->count();
                    for($i = 1; $i <= $co_levels; $i++) {
                        $student_all_pass['CO'.$i] = 0;
                    }

                    // For each evaluations of that student, calculate the total marks
                    foreach($evaluations as $evaluation) {
                        // Get the rubric for that evaluation
                        $rubric = $evaluation->criteria_marks[0]->sub_criteria->criteria->rubric; 

                        // For each criteria in that rubric, get the sub criteria group by co level
                        foreach($rubric->rubric_criterias as $criteria) {
                            $co_levels = SubCriteria::where('criteria_id', $criteria->criteria_id)->get()->groupBy('co_level_id');
                            $co_total_marks = 0; 
                            $co_total_weightage = 0;

                            foreach($co_levels as $co_level_id => $sub_criterias) {
                                $co_level = CoLevel::where('co_level_id', $co_level_id)->first()->co_level_name;
                                // For each sub criteria, get the scale and calculate the weightage 
                                foreach($sub_criterias as $sub_criteria) {
                                    // Get the scale and weightage for that sub criteria
                                    $scale = CriteriaMark::where('sub_criteria_id', '=', $sub_criteria->sub_criteria_id)
                                            ->where('evaluation_id', '=', $evaluation->evaluation_id)->first()->scale;
                                    $total_scale = CriteriaScale::where('sub_criteria_id', $sub_criteria->sub_criteria_id)->count()-1;
                                    $weightage = $sub_criteria->weightage; 

                                    // Calculate the total weightage and marks for that co level
                                    $sub_criteria_mark = $weightage * ($scale/$total_scale);
                                    $co_total_weightage += $weightage;
                                    $co_total_marks += $sub_criteria_mark;
                                }

                                // If the total marks is more than half of the total weightage, add 1 to the co level
                                if($co_total_marks >= ($co_total_weightage / 2)) {
                                    $student_all_pass['CO'.$co_level[-1]] = 1;
                                }
                            }
                        }
                    }
                    // For each co level, if the student pass 50% then student number for that co + 1
                    foreach($student_all_pass as $co_level => $pass) {
                        $all_students_co[$co_level] += $pass;
                    }
                }
                return view('report.report_and_progress', compact('research_group_pass', 'research_group_fail', 'all_students_grade', 'all_students_co')); 
            }
            else if(auth()->user()->hasRole('head of research group')) {
                $research_group_pass = ['PSM1' => 0, 'PSM2' => 0];
                $research_group_fail = ['PSM1' => 0, 'PSM2' => 0];

                $research_group_students = auth()->user()->research_group->students;

                // Calculate the total marks for each student
                foreach($research_group_students as $student) {
                    $total_marks = 0;
                    $evaluations = Evaluation::where('student_id', $student->student_id)->get();
                    if($evaluations->count() == 0) {
                        break;
                    }

                    // For each evaluations of that student, calculate the total marks
                    foreach($evaluations as $evaluation) {
                        if($evaluation->evaluation_type == 'evaluation2') {
                            $total_marks += $evaluation->marks * 0.2;
                        }
                        else {
                            // for evaluation 1 and 3 for psm 1, both are 30%
                            if($student->psm_year == 1) {
                                $total_marks += $evaluation->marks * 0.3;
                            }
                            else {
                                // for evaluation 1 for PSM 2 is 20%, evaluation 3 is 40%
                                if($evaluation->evaluation_type == 'evaluation3') {
                                    $total_marks += $evaluation->marks * 0.4;
                                }
                                else {
                                    $total_marks += $evaluation->marks * 0.2;
                                }
                            }
                        }
                    }

                    // Add pass/fail to the research group student
                    if($total_marks >= 40) {
                        $research_group_pass['PSM'.$student->psm_year] += 1;
                    }
                    else {
                        $research_group_fail['PSM'.$student->psm_year] += 1;
                    }
                }

                return view('report.report_and_progress', compact('research_group_pass', 'research_group_fail'));
            }
        }
        else if(auth('student')->check()) {
            $student = Student::find(auth()->user()->student_id);

            // Get each evaluation marks for that student
            $all_marks = Evaluation::where('student_id', auth()->user()->student_id)->get();

            $all_supervisee_marks = $all_marks->mapWithKeys(function($item) {
                return [$item['evaluation_type'] => $item['marks']];
            });
            
            if($student->top_student == 1) {
                $industrial_evaluation= IndustrialEvaluation::where('student_id', auth()->user()->student_id)->get();
                $industrial_mark = $industrial_evaluation->mapWithKeys(function($item) {
                    return ['Industrial Evaluation' => $item['marks']];
                });
                $all_supervisee_marks = $all_supervisee_marks->merge($industrial_mark);
            }

            $all_students_grade = []; 
            $all_students_co = [];

            return view('report.report_and_progress', compact('all_supervisee_marks', 'all_students_grade', 'all_students_co'));
        }
    }
}
