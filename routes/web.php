<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/layout', function () {
    return view('layout');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/supervisee', function () {
    return view('supervisee.supervisee_list');
})->name('supervisee');

Route::get('/evaluation', function () {
    return view('evaluation.student_list');
})->name('evaluation');

Route::get('/evaluation schedule', function () {
    return view('evaluation_schedule.manage_schedule');
})->name('evaluation schedule');

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
