<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RubricController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\TopStudentController;
use App\Http\Controllers\SuperviseeListController;
use App\Http\Controllers\EvaluationScheduleController;
use App\Http\Controllers\IndustrialEvaluationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/layout', function () {
    return view('layout');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/supervisee', [SuperviseeListController::class, 'showSuperviseeList'])->name('supervisee');
    
    // Route for Manage Evaluation Schedule (Coordinator)
    Route::get('/evaluation schedule', [EvaluationScheduleController::class, 'showEvaluationSchedule'])->name('evaluation schedule');
    Route::put('/evaluation schedule', [EvaluationScheduleController::class, 'showEvaluationSchedule']);
    Route::post('/evaluation schedule', [EvaluationScheduleController::class, 'scheduleEvaluationSchedule']);

    // Route for Create Slot
    Route::get('/evaluation schedule/create-slot', [EvaluationScheduleController::class, 'newSlot'])->name('evaluation schedule.create_slot');
    Route::put('/evaluation schedule/create-slot', [EvaluationScheduleController::class, 'newSlot']);
    Route::post('/evaluation schedule/create-slot', [EvaluationScheduleController::class, 'createSlot']);

    // Route for Edit Slot
    Route::get('/evaluation schedule/edit-slot/{slot_id}', [EvaluationScheduleController::class, 'editSlot'])->name('evaluation schedule.edit_slot');
    Route::post('/evaluation schedule/edit-slot/{slot_id}', [EvaluationScheduleController::class, 'editSlot']);
    Route::put('/evaluation schedule/edit-slot/{slot_id}', [EvaluationScheduleController::class, 'updateSlot']);

    // Route for Delete Slot
    Route::delete('/evaluation schedule/delete-slot/{slot_id}', [EvaluationScheduleController::class, 'deleteSlot']);

    // Route for View Evaluation Schedule
    Route::get('/evaluation schedule/view-schedule', [EvaluationScheduleController::class, 'viewSchedule'])->name('evaluation schedule.view_schedule');

    // Route for Evaluation
    Route::get('/evaluation', [EvaluationController::class, 'showEvaluateeList'])->name('evaluation');
    Route::get('/evaluation/{student_id}', [EvaluationController::class, 'showEvaluationForm'])->name('evaluation.show_evaluation_form');

    // Route for View Rubric List
    Route::get('/rubric', [RubricController::class, 'showRubricList'])->name('rubric');

    // Route for show CO level settings
    Route::get('/rubric/co-level-settings', [RubricController::class, 'showCOLevelSettings'])->name('rubric.co_level');

    // Route for create CO Level
    Route::get('/rubric/create-co-level', [RubricController::class, 'newCOLevel'])->name('rubric.edit_co_level');
    Route::post('/rubric/create-co-level', [RubricController::class, 'createCOLevel']);

    // Route for edit CO Level
    Route::get('/rubric/edit-co-level/{co_level_id}', [RubricController::class, 'editCOLevel'])->name('rubric.edit_co_level');
    Route::put('/rubric/edit-co-level/{co_level_id}', [RubricController::class, 'updateCOLevel'])->name('rubric.edit_co_level');

    // Route for delete CO Level
    Route::delete('/rubric/delete-co-level/{co_level_id}', [RubricController::class, 'deleteCOLevel'])->name('rubric.delete_co_level');

    // Route for View Single Rubric
    Route::get('/rubric/view/{rubric_id}', [RubricController::class, 'showRubric'])->name('rubric.view_rubric');

    // Route for Print Rubric
    Route::get('/rubric/print/{rubric_id}', [RubricController::class, 'printRubric'])->name('rubric.print_rubric');

    // Route for Create Rubric
    Route::get('/rubric/create-rubric', [RubricController::class, 'newRubric'])->name('rubric.new_rubric');
    Route::post('/rubric/create-rubric', [RubricController::class, 'createRubric']);

    // Route for Edit Rubric
    Route::get('/rubric/edit/{rubric_id}', [RubricController::class, 'editRubric'])->name('rubric.edit_rubric');
    Route::put('/rubric/edit/{rubric_id}', [RubricController::class, 'updateRubric']);

    // Route for Delete Rubric
    Route::delete('/rubric/delete/{rubric_id}', [RubricController::class, 'deleteRubric'])->name('rubric.delete_rubric');

    // Route for Delete Criteria, Sub Criteria, and Scale
    Route::delete('/rubric/delete-criteria/{criteria_id}', [RubricController::class, 'deleteCriteria'])->name('rubric.delete_criteria');
    Route::delete('/rubric/delete-sub-criteria/{sub_criteria_id}', [RubricController::class, 'deleteSubCriteria'])->name('rubric.delete_sub_criteria');
    Route::delete('/rubric/delete-scale/{scale_id}', [RubricController::class, 'deleteScale'])->name('rubric.delete_scale');

    // Route for Evaluation
    Route::post('/evaluation/{student_id}', [EvaluationController::class, 'evaluateStudent'])->name('evaluation.evaluate_student');

    // Route for Top Students List
    Route::get('/top students', [TopStudentController::class, 'showTopStudents'])->name('top students');
    Route::post('/top students', [TopStudentController::class, 'sortTopStudents']);

    // Route for edit Top Students
    Route::get('/top students/edit', [TopStudentController::class, 'editTopStudents'])->name('top students.edit_top_student');
    Route::post('/top students/edit', [TopStudentController::class, 'updateTopStudents']);

    // Route for Industrial Evaluator
    Route::get('/industrial evaluator', [IndustrialEvaluationController::class, 'showIndustrialEvaluators'])->name('industrial evaluator');

    // Route for create Industrial Evaluator
    Route::get('/industrial evaluator/create', [IndustrialEvaluationController::class, 'newIndustrialEvaluator'])->name('industrial evaluator.create_industrial_evaluator');
    Route::post('/industrial evaluator/create', [IndustrialEvaluationController::class, 'createIndustrialEvaluator']);

    // Route for edit Industrial Evaluator
    Route::get('/industrial evaluator/edit/{industrial_evaluator_id}', [IndustrialEvaluationController::class, 'editIndustrialEvaluator'])->name('industrial evaluator.edit_industrial_evaluator');
    Route::put('/industrial evaluator/edit/{industrial_evaluator_id}', [IndustrialEvaluationController::class, 'updateIndustrialEvaluator']);
    
    // Route for delete Industrial Evaluator
    Route::delete('industrial evaluator/delete/{industrial_evaluator_id}', [IndustrialEvaluationController::class, 'deleteIndustrialEvaluator'])->name('industrial evaluator.delete_industrial_evaluator');

    // Route for Industrial Schedule
    Route::get('/industrial schedule', [IndustrialEvaluationController::class, 'showIndustrialSchedule'])->name('industrial schedule');
    Route::put('/industrial schedule', [IndustrialEvaluationController::class, 'showIndustrialSchedule']);
    Route::post('/industrial schedule', [IndustrialEvaluationController::class, 'scheduleIndustrialSchedule']);

    // Route for create industrial slot
    Route::get('/industrial schedule/create-slot', [IndustrialEvaluationController::class, 'newIndustrialSlot'])->name('industrial schedule.create_slot');
    Route::put('/industrial schedule/create-slot', [IndustrialEvaluationController::class, 'newIndustrialSlot']);
    Route::post('/industrial schedule/create-slot', [IndustrialEvaluationController::class, 'createIndustrialSlot']);

    // Route for update industrial slot
    Route::get('/industrial schedule/edit-slot/{slot_id}', [IndustrialEvaluationController::class, 'editIndustrialSlot'])->name('industrial schedule.edit_slot');
    Route::post('/industrial schedule/edit-slot/{slot_id}', [IndustrialEvaluationController::class, 'editIndustrialSlot']);
    Route::put('/industrial schedule/edit-slot/{slot_id}', [IndustrialEvaluationController::class, 'updateIndustrialSlot']);

    // Route for Delete Slot
    Route::delete('/industrial schedule/delete-slot/{slot_id}', [IndustrialEvaluationController::class, 'deleteIndustrialSlot']);

    // Route for View Industrial Rubric List
    Route::get('/industrial rubric', [IndustrialEvaluationController::class, 'showIndustrialRubricList'])->name('industrial rubric');

    // Route for show Industrial CO level settings
    Route::get('/industrial rubric/co-level-settings', [IndustrialEvaluationController::class, 'showCOLevelSettings'])->name('industrial rubric.co_level');

    // Route for create CO Level for industrial rubric
    Route::get('/industrial rubric/create-co-level', [IndustrialEvaluationController::class, 'newCOLevel'])->name('industrial rubric.edit_co_level');
    Route::post('/industrial rubric/create-co-level', [IndustrialEvaluationController::class, 'createCOLevel'])->name('industrial rubric.edit_co_level');

    // Route for edit CO Level for industrial rubric
    Route::get('/industrial rubric/edit-co-level/{co_level_id}', [IndustrialEvaluationController::class, 'editCOLevel'])->name('industrial rubric.edit_co_level');
    Route::put('/industrial rubric/edit-co-level/{co_level_id}', [IndustrialEvaluationController::class, 'updateCOLevel'])->name('industrial rubric.edit_co_level');

    // Route for delete CO Level for industrial rubric
    Route::delete('/industrial rubric/delete-co-level/{co_level_id}', [IndustrialEvaluationController::class, 'deleteCOLevel'])->name('industrial rubric.delete_co_level');

    // Route for View Single Rubric
    Route::get('/industrial rubric/view/{rubric_id}', [IndustrialEvaluationController::class, 'showIndustrialRubric'])->name('industrial rubric.view_rubric');
    
    // Route for Print Rubric
    Route::get('/industrial rubric/print/{rubric_id}', [IndustrialEvaluationController::class, 'printIndustrialRubric'])->name('industrial rubric.print_rubric');

    // Route for Create Industrial Rubric
    Route::get('/industrial rubric/create-rubric', [IndustrialEvaluationController::class, 'newIndustrialRubric'])->name('industrial rubric.new_rubric');
    Route::post('/industrial rubric/create-rubric', [IndustrialEvaluationController::class, 'createIndustrialRubric']);

    // Route for Edit Industrial Rubric
    Route::get('/industrial rubric/edit/{rubric_id}', [IndustrialEvaluationController::class, 'editIndustrialRubric'])->name('industrial rubric.edit_rubric');
    Route::put('/industrial rubric/edit/{rubric_id}', [IndustrialEvaluationController::class, 'updateIndustrialRubric']);

    // Route for Delete Industrial Rubric
    Route::delete('/industrial rubric/delete/{rubric_id}', [IndustrialEvaluationController::class, 'deleteIndustrialRubric'])->name('industrial rubric.delete_rubric');

    // Route for Delete Criteria, Sub Criteria, and Scale
    Route::delete('/industrial rubric/delete-criteria/{criteria_id}', [IndustrialEvaluationController::class, 'deleteCriteria'])->name('industrial rubric.delete_criteria');
    Route::delete('/industrial rubric/delete-sub-criteria/{sub_criteria_id}', [IndustrialEvaluationController::class, 'deleteSubCriteria'])->name('industrial rubric.delete_sub_criteria');
    Route::delete('/industrial rubric/delete-scale/{scale_id}', [IndustrialEvaluationController::class, 'deleteScale'])->name('industrial rubric.delete_scale');

    // Route for Industrial Evaluation
    Route::get('/industrial evaluation', [IndustrialEvaluationController::class, 'showTopStudentList'])->name('industrial evaluation');

    // Route for Edit Industrial Evaluation
    Route::get('/industrial evaluation/{student_id}', [IndustrialEvaluationController::class, 'showIndustrialEvaluationForm'])->name('industrial evaluation.show_evaluation_form');
    Route::post('/industrial evaluation/{student_id}', [IndustrialEvaluationController::class, 'evaluateIndustrialStudent'])->name('industrial evaluation.evaluate_student');

    // Route for View Report
    Route::get('/report', [ReportController::class, 'showReport'])->name('report');
});

Route::middleware('auth:student')->group(function () {
    // Route for manage FYP
    Route::get('/fyp', [ProfileController::class, 'showFYP'])->name('showFYP');
    Route::put('/fyp', [ProfileController::class, 'updateFYP']);

    // Route for View Evaluation Schedule
    Route::get('/evaluation schedule/student-schedule', [EvaluationScheduleController::class, 'viewSchedule'])->name('evaluation schedule.student_schedule');

    // Route for View Rubric List
    Route::get('/rubric/student-rubric', [RubricController::class, 'showRubricList'])->name('rubric.student_rubric_list');

    // Route for View Single Rubric
    Route::get('/rubric/student-rubric/view/{rubric_id}', [RubricController::class, 'showRubric'])->name('rubric.view_rubric');

    // Route for Top Students List
    Route::get('/top students/student-view', [TopStudentController::class, 'showTopStudents'])->name('top students.student_top_student_list');

    // Route for Report
    Route::get('/report/student-report', [ReportController::class, 'showReport'])->name('report.student_report');
});
