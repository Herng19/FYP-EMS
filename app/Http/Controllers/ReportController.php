<?php

namespace App\Http\Controllers;

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
            // Get lecturer's supervisees
            $lecturer = auth()->user();
            $supervisees = $lecturer->supervisees; 
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

            // If user is coordinator, get data for all student's grade and co level
            if(auth()->user()->hasRole('coordinator')) {
                $all_students_grade = ['A' => 0, 'A-' => 0, 'B+' => 0, 'B' => 0, 'B-' => 0, 'C+' => 0, 'C' => 0, 'F' => 0]; 
                $evaluated_students = Evaluation::all()->groupBy('student_id'); 

                // For each student, calculate the total marks and add the grade number to the array
                foreach($evaluated_students as $student_id => $evaluations) {
                    $total_marks = 0; 

                    // For each evaluations of that student, calculate the total marks
                    foreach($evaluations as $evaluation) {
                        if($evaluation->evaluation_type == 'evaluation2') {
                            $total_marks += $evaluation->marks * 0.2;
                        }
                        else {
                            $total_marks += $evaluation->marks * 0.3;
                        }
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

                $all_students_co = ['CO1' => 0, 'CO2' => 0, 'CO3' => 0];

                // Get all students' co level
                foreach($evaluated_students as $student_id => $evaluations) {
                    $student_all_pass = ['CO1' => 0, 'CO2' => 0, 'CO3' => 0]; 
                    foreach($evaluations as $evaluation) {
                        // Get the rubric for that evaluation
                        $rubric = $evaluation->criteria_marks[0]->sub_criteria->criteria->rubric; 

                        // For each criteria in that rubric, get the sub criteria group by co level
                        foreach($rubric->rubric_criterias as $criteria) {
                            $co_levels = SubCriteria::where('criteria_id', $criteria->criteria_id)->get()->groupBy('co_level');
                            $co_total_marks = 0; 
                            $co_total_weightage = 0;

                            foreach($co_levels as $co_level => $sub_criterias) {
                                // For each sub criteria, get the scale and calculate the weightage 
                                foreach($sub_criterias as $sub_criteria) {
                                    // Get the scale and weightage for that sub criteria
                                    $scale = CriteriaMark::where('sub_criteria_id', '=', $sub_criteria->sub_criteria_id)
                                            ->where('evaluation_id', '=', $evaluation->evaluation_id)->first()->scale;
                                    $total_weightage = CriteriaScale::where('sub_criteria_id', $sub_criteria->sub_criteria_id)->count();
                                    $weightage = $sub_criteria->weightage; 
                                    
                                    // Calculate the total weightage and marks for that co level
                                    $sub_criteria_mark = $weightage * ($scale/$total_weightage);
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
            }
            
            return view('report.report_and_progress', compact('all_supervisee_marks', 'all_students_grade', 'all_students_co')); 
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
