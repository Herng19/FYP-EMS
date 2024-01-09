<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopStudentController extends Controller
{
    // Function to show top students
    public function showTopStudents() {
        // Select the top students according to requested top student number
        DB::statement("SET SQL_MODE=''");
        $students = Student::where('top_student', '=', '1')
                    ->where('psm_year', '=', '2')
                    // ->join('evaluations', 'students.student_id', '=', 'evaluations.student_id')
                    // ->where('evaluation_type', '=', 'evaluation2')
                    // ->groupBy('students.student_id')
                    // ->orderBy(DB::raw('SUM(marks)'), 'desc')
                    ->paginate(10);

        // Calculate the students' total FYPro marks
        $marks = array();
        foreach($students as $student) {
            $total_marks = 0;
            $evaluations = Evaluation::where('student_id', '=', $student->student_id)
                            ->where('evaluation_type', '=', 'evaluation2')
                            ->get();

            foreach($evaluations as $evaluation) {
                $total_marks += $evaluation->marks * 20 / 100 ;
            }
            $marks[$student->student_id] = $total_marks;
        }
        
        return view('top_student.top_student_list', ['students' => $students, 'marks' => $marks]);
    }

    public function sortTopStudents(Request $request) {
        // Validate if all psm students are evaluated in evalaution 2 (FYPro)
        // Getting all psm 2 students, and all number of evaluation 2(by evaluators)
        $all_psm2_students = Student::where('psm_year', '=', '2')->pluck('student_id')->toArray();
        $total_evaluations = Evaluation::where('evaluation_type', '=', 'evaluation2')
                             ->whereIn('student_id', $all_psm2_students)
                             ->count();

        // If there are 2 evaluations for each psm 2 student, then proceed, else return error message
        if((count($all_psm2_students)*2) != $total_evaluations) {
            return redirect('/top students')->with('error-message', 'Please make sure all students are evaluated in FYPro.');
        }

        // Clear all top students
        Student::where('top_student', '=', '1')->update(['top_student' => 0]);  

        // Select the top students according to requested top student number
        $top_students = DB::table('evaluations')
                            ->select(DB::raw('AVG(marks) as total_marks, student_id'))
                            ->whereIn('student_id', $all_psm2_students)
                            ->where('evaluation_type', '=', 'evaluation2')
                            ->groupBy('student_id')
                            ->orderBy(DB::raw('AVG(marks)'), 'desc')
                            ->take($request->top_student_num)
                            ->get();

        // Update the top students
        Student::whereIn('student_id', $top_students->pluck('student_id')->toArray())->update(['top_student' => 1]);       

        return redirect('/top students')->with('success-message', 'Top Students has been updated successfully.');
    }

    // Function to navigate to edit top students page
    public function editTopStudents() {
        $students = Student::where('psm_year', '=', '2')
                    ->get()
                    ->sortBy('research_group_id');

        // Calculate the students' total FYPro marks
        $marks = array();
        foreach($students as $student) {
            $total_marks = 0;
            $evaluations = Evaluation::where('student_id', '=', $student->student_id)
                            ->where('evaluation_type', '=', 'evaluation2')
                            ->get();

            foreach($evaluations as $evaluation) {
                $total_marks += $evaluation->marks * 20 / 100 ;
            }
            $marks[$student->student_id] = $total_marks;
        }

        return view('top_student.edit_top_student', ['students' => $students, 'marks' => $marks]);
    }

    // Function to update top students
    public function updateTopStudents(Request $request) {
        // Get all students
        $students = Student::where('psm_year', '=', '2')->get();

        // If request is null, set all students to not top students
        if($request->top_students == null) {
            foreach($students as $student) {
                $student->top_student = 0;
                $student->save();
            }
            return redirect("/top students")->with('success-message', 'Top Students has been updated successfully.');
        }

        // Foreach student, check if student is top studentl; if yes, update top_student to 1, if not, update top_student to 0
        foreach($students as $student) {
            if($student->top_student == 1 && !(in_array($student->student_id, $request->top_students))) {
                $student->top_student = 0;
                $student->save();
            }
            else if($student->top_student == 0 && in_array($student->student_id, $request->top_students)) {
                $student->top_student = 1;
                $student->save();
            } 
        }
        return redirect("/top students")->with('success-message', 'Top Students has been updated successfully.');
    }
}
