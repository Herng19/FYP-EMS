<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class TopStudentController extends Controller
{
    // Function to show top students
    public function showTopStudents() {
        $students = Student::where('top_student', '=', 1)
                    ->paginate(10);
        
        return view('top_student.top_student_list', ['students' => $students]);
    }

    // Function to navigate to edit top students page
    public function editTopStudents() {
        $students = Student::all()->sortBy('research_group_id');

        return view('top_student.edit_top_student', ['students' => $students]);
    }

    // Function to update top students
    public function updateTopStudents(Request $request) {
        // Get all students
        $students = Student::all();

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
