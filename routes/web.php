<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperviseeListController;
use App\Http\Controllers\EvaluationScheduleController;

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
    
    // Route for Manage Evaluation Scheduel (Coordinator)
    Route::get('/evaluation schedule', [EvaluationScheduleController::class, 'showEvaluationSchedule'])->name('evaluation schedule');
    Route::post('/evaluation schedule', [EvaluationScheduleController::class, 'showEvaluationSchedule'])->name('evaluation schedule');

    // Create Slot
    Route::get('/evaluation schedule/create-slot', [EvaluationScheduleController::class, 'newSlot'])->name('create_slot');
    Route::put('/evaluation schedule/create-slot', [EvaluationScheduleController::class, 'newSlot'])->name('create_slot');
    Route::post('/evaluation schedule/create-slot', [EvaluationScheduleController::class, 'createSlot'])->name('create_slot');

    // Edit Slot
    Route::get('/evaluation schedule/edit-slot/{slot_id}', [EvaluationScheduleController::class, 'editSlot'])->name('edit_slot');
    Route::post('/evaluation schedule/edit-slot/{slot_id}', [EvaluationScheduleController::class, 'editSlot'])->name('edit_slot');
    Route::put('/evaluation schedule/edit-slot/{slot_id}', [EvaluationScheduleController::class, 'updateSlot']);

    // Delete Slot
    Route::delete('/evaluation schedule/edit-slot/{slot_id}', [EvaluationScheduleController::class, 'deleteSlot']);

    // View Evaluation Schedule
    Route::get('evaluation schedule/view-schedule', [EvaluationScheduleController::class, 'viewSchedule'])->name('view_schedule');
});

Route::middleware('auth:student')->group(function () {
        // Route for manage FYP
        Route::get('/fyp', [ProfileController::class, 'showFYP'])->name('showFYP');
        Route::put('/fyp', [ProfileController::class, 'updateFYP']);
});

// Route for Supervisee List

Route::get('/evaluation', function () {
    return view('evaluation.student_list');
})->name('evaluation');


Route::get('/rubric', function () {
    return view('rubric.rubric_list');
})->name('rubric');

Route::get('/top students', function () {
    return view('top_student.top_student_list');
})->name('top students');

// Industrial Evaluation
Route::get('/industrial evaluator', function () {
    return view('industrial_evaluation.industrial_evaluator.industrial_evaluator_list');
})->name('industrial evaluator');

Route::get('/industrial schedule', function () {
    return view('industrial_evaluation.industrial_schedule.industrial_schedule');
})->name('industrial schedule');

Route::get('/industrial evaluation', function () {
    return view('industrial_evaluation.industrial_evaluation.top_student_list');
})->name('industrial evaluation');

Route::get('/report', function () {
    return view('report.report_and_progress');
})->name('report');
