<?php


use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\NutrientController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionTypeController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\AlimentController;
use App\Http\Controllers\PeriodController;
/*Route::get('/', function () {
    return view('auth/login');
});*/

Route::get('/', function () {
    return view('vista');
});
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class);

Route::resource('exercises', ExerciseController::class);

Route::resource('exercise-types', ExerciseTypeController::class);

Route::resource('routines', RoutineController::class);

Route::resource('questions', QuestionController::class);

Route::resource('question-types', QuestionTypeController::class);
Route::post('questions/store-answers', [QuestionController::class, 'storeAnswers']);



Route::get('preguntas', [QuestionController::class, 'questions']);
Route::get('inicio', [QuestionController::class, 'startQuestion']);


// tipo alimento

Route::resource('food-types', FoodTypeController::class);
Route::get('food-types/export/pdf', [FoodTypeController::class, 'exportPDF'])->name('food-types.export.pdf');
Route::get('food-types/export/excel', [FoodTypeController::class, 'exportExcel'])->name('food-types.export.excel');

// gestion de alimento 

Route::resource('aliments', AlimentController::class);

// Ruta para exportar a PDF
Route::get('aliments/export/pdf', [AlimentController::class, 'exportPdf'])->name('aliments.exportPdf');


// nutriente
Route::resource('nutrients', NutrientController::class);
Route::get('nutrients/export/pdf', [NutrientController::class, 'exportPdf'])->name('nutrients.export.pdf');

//Route::get('nutrients/export/excel', [FoodTypeController::class, 'exportExcel'])->name('nutrients.export.excel');

//usuario
Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');


// period
Route::resource('periods', PeriodController::class);
