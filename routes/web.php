<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    return view('index');
})->name('index');

Route::post('/', function (Request $request) {
    $students = $request->all();

    $mathAverage = 0;
    $physicsAverage = 0;
    $programingAverage = 0;

    $mathMaxGrade = 0;
    $physicsMaxGrade = 0;
    $programingMaxGrade = 0;

    $mathApproved = 0;
    $physicsApproved = 0;
    $programingApproved = 0;

    $mathFailed = 0;
    $physicsFailed = 0;
    $programingFailed = 0;

    $approvedAll = 0;
    $approvedOneOnly = 0;
    $approvedTwoOnly = 0;

    foreach ($students as $student) {
        $mathAverage += $student['math'];
        if ($student['math'] >= 9.5) $mathApproved += 1; else $mathFailed += 1;
        if ($student['math'] > $mathMaxGrade) $mathMaxGrade = $student['math'];

        $physicsAverage += $student['physics'];
        if ($student['physics'] >= 9.5) $physicsApproved += 1; else $physicsFailed += 1;
        if ($student['physics'] > $physicsMaxGrade) $physicsMaxGrade = $student['math'];

        $programingAverage += $student['programing'];
        if ($student['programing'] >= 9.5) $programingApproved += 1; else $programingFailed += 1;
        if ($student['programing'] > $programingMaxGrade) $programingMaxGrade = $student['programing'];

        if ($student['math'] >= 9.5 && $student['physics'] >= 9.5 && $student['programing'] >= 9.5) $approvedAll += 1;
        else if (
            ($student['math'] >= 9.5 && $student['physics'] < 9.5 && $student['programing'] < 9.5) ||
            ($student['physics'] >= 9.5 && $student['math'] < 9.5 && $student['programing'] < 9.5) ||
            ($student['programing'] >= 9.5 && $student['math'] < 9.5 && $student['physics'] < 9.5)
        ) $approvedOneOnly += 1;
        else if (
            ($student['math'] >= 9.5 && $student['physics'] >= 9.5 && $student['programing'] < 9.5) ||
            ($student['physics'] >= 9.5 && $student['programing'] >= 9.5 && $student['math'] < 9.5) ||
            ($student['programing'] >= 9.5 && $student['math'] >= 9.5 && $student['physics'] < 9.5)
        ) $approvedTwoOnly += 1;
    }
    $mathAverage = $mathAverage / count($students);
    $physicsAverage = $physicsAverage / count($students);
    $programingAverage = $programingAverage / count($students);

    return response()->json([
        'mathAverage' => $mathAverage,
        'physicsAverage' => $physicsAverage,
        'programingAverage' => $programingAverage,
        'mathMaxGrade' => $mathMaxGrade,
        'physicsMaxGrade' => $physicsMaxGrade,
        'programingMaxGrade' => $programingMaxGrade,
        'mathApproved' => $mathApproved,
        'physicsApproved' => $physicsApproved,
        'programingApproved' => $programingApproved,
        'mathFailed' => $mathFailed,
        'physicsFailed' => $physicsFailed,
        'programingFailed' => $programingFailed,
        'approvedAll' => $approvedAll,
        'approvedOneOnly' => $approvedOneOnly,
        'approvedTwoOnly' => $approvedTwoOnly
    ], 200);
})->name('index.submit');
