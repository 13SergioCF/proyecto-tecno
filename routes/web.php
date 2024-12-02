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
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PeriodController;

use App\Http\Controllers\DietController;
use App\Http\Controllers\NutritionalsDetailController;
use App\Http\Controllers\ThunderController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\DayThunderController;
use App\Http\Controllers\DietsAlimentController;
use App\Http\Controllers\DetailsDaysThunderController;
use App\Http\Controllers\ExercisePlanController;
use App\Http\Controllers\LoadingController;
use App\Http\Controllers\MuscleController;
use App\Http\Controllers\NutritionalPlanController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ContactoController;

/*Route::get('/', function () {
    return view('auth/login');
});*/

Route::get('/', function () {
    return view('vista');
});
Auth::routes();



// Route::middleware('auth')->group(function () {



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class);

Route::resource('exercises', ExerciseController::class);
Route::get('/getExerciseHours/{day}', [ExerciseController::class, 'getExerciseHours']);

Route::get('/exercises/export-pdf', [ExerciseController::class, 'exportPdf'])->name('exercises.exportPdf');

Route::resource('exercise-types', ExerciseTypeController::class);

Route::post('routines', [RoutineController::class, 'index']);
Route::resource('routines', RoutineController::class);

Route::resource('questions', QuestionController::class);

Route::resource('question-types', QuestionTypeController::class);
Route::post('answers', [AnswerController::class, 'store']);
Route::post('muscles', [MuscleController::class, 'index']);
// Route::match(['get', 'post'], 'recomendations/generate', [ChatController::class, 'generate']);

Route::post('recomendations/generate', [ChatController::class, 'generate']);
Route::post('plan/generate', [ExercisePlanController::class, 'generateFullPlan']);




Route::get('preguntas', [QuestionController::class, 'questions']);
Route::get('inicio', [QuestionController::class, 'startQuestion']);
// tipo alimento
Route::resource('food-types', FoodTypeController::class);
Route::get('food-types/export/pdf', [FoodTypeController::class, 'exportPDF'])->name('food-types.export.pdf');
Route::get('food-types/export/excel', [FoodTypeController::class, 'exportExcel'])->name('food-types.export.excel');

// gestion de alimento 
Route::resource('aliments', AlimentController::class);

Route::put('/aliments/{id}', [AlimentController::class, 'update'])->name('aliments.update');


// Ruta para exportar a PDF

// gestion de alimento 

Route::resource('aliments', AlimentController::class);



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
// detalle nutricional
Route::resource('nutritional_details', DietController::class);
// diet
Route::resource('diets', DietController::class);
// truno
Route::resource('thunders', ThunderController::class);
// dia
Route::resource('days', DayController::class);
//dia turno
Route::resource('daythunders', DayThunderController::class);
Route::get('daythunders/{id_dia}/{id_turno}/edit', [DayThunderController::class, 'edit'])->name('daythunders.edit');
Route::put('/daythunders/{id_dia}/{id_turno}', [DayThunderController::class, 'update'])->name('daythunders.update');
// Route::delete('/daythunders/{id_dia}/{id_turno}', [DayThunderController::class, 'destroy'])->name('daythunders.destroy');


Route::delete('daythunders/{id_dia}/{id_turno}', [DayThunderController::class, 'destroy'])->name('daythunders.destroy');

Route::get('daythunders', [DayThunderController::class, 'index'])->name('daythunders.index');
Route::get('daythunders/create', [DayThunderController::class, 'create'])->name('daythunders.create');
Route::post('daythunders', [DayThunderController::class, 'store'])->name('daythunders.store');

// detalle nutricional
Route::resource('nutritionals_details', NutritionalsDetailController::class);
//dieta alimento
Route::resource('diets_aliments', DietsAlimentController::class);
// detalle dia turno
Route::resource('details_days_thunders', DetailsDaysThunderController::class);

Route::get('plan-nutricional', [NutritionalPlanController::class, 'index']);
Route::get('/plan-nutricional', [NutritionalPlanController::class, 'showPlan']);
Route::get('/plan-nutricional-ejercicios', [ExercisePlanController::class, 'showNutritionalAndExercisePlan']);

Route::post('/loading', [LoadingController::class, 'index']);

Route::get('/api/recommendation/{id}/json', [RecommendationController::class, 'getRecommendationJson']);
Route::get('/recommendation/{id}/view', [RecommendationController::class, 'showRecommendation']);




Route::resource('/contacto',ContactoController::class)->names('contacto');

// });