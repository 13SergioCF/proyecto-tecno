<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AlimentController,
    AnswerController,
    ChatController,
    ContactoController,
    DayController,
    DayThunderController,
    DetailsDaysThunderController,
    DietController,
    DietsAlimentController,
    ExerciseController,
    ExercisePlanController,
    ExerciseTypeController,
    FoodTypeController,
    HomeController,
    LoadingController,
    MuscleController,
    NutrientController,
    NutritionalPlanController,
    NutritionalsDetailController,
    PeriodController,
    QuestionController,
    QuestionTypeController,
    RecommendationController,
    RoutineController,
    ThunderController,
    UserController
};

// Página principal
Route::get('/', fn() => view('vista'));

Auth::routes();

// Ruta de inicio
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Usuarios
Route::resource('users', UserController::class);
Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');

// Ejercicios
Route::resource('exercises', ExerciseController::class);
Route::get('/getExerciseHours/{day}', [ExerciseController::class, 'getExerciseHours']);
Route::get('/exercises/export-pdf', [ExerciseController::class, 'exportPdf'])->name('exercises.exportPdf');
Route::resource('exercise-types', ExerciseTypeController::class);

// Rutinas
Route::resource('routines', RoutineController::class);
Route::post('routines', [RoutineController::class, 'index']);

// Preguntas y respuestas
Route::resource('questions', QuestionController::class);
Route::resource('question-types', QuestionTypeController::class);
Route::post('answers', [AnswerController::class, 'store']);
Route::get('preguntas', [QuestionController::class, 'questions']);
Route::get('inicio', [QuestionController::class, 'startQuestion']);

// Alimentos y nutrientes
Route::resource('food-types', FoodTypeController::class);
Route::get('food-types/export/pdf', [FoodTypeController::class, 'exportPDF'])->name('food-types.export.pdf');
Route::get('food-types/export/excel', [FoodTypeController::class, 'exportExcel'])->name('food-types.export.excel');
Route::resource('aliments', AlimentController::class);
Route::put('/aliments/{id}', [AlimentController::class, 'update'])->name('aliments.update');
Route::get('aliments/export/pdf', [AlimentController::class, 'exportPdf'])->name('aliments.exportPdf');
Route::resource('nutrients', NutrientController::class);
Route::get('nutrients/export/pdf', [NutrientController::class, 'exportPdf'])->name('nutrients.export.pdf');

// Planes y recomendaciones
Route::post('recomendations/generate', [ChatController::class, 'generate']);
Route::post('plan/generate', [ExercisePlanController::class, 'generateFullPlan']);
Route::get('/plan-nutricional', [NutritionalPlanController::class, 'showPlan']);
Route::get('/plan-nutricional-ejercicios', [ExercisePlanController::class, 'showNutritionalAndExercisePlan']);

// Períodos
Route::resource('periods', PeriodController::class);

// Planes de dieta y detalles
Route::resource('diets', DietController::class);
Route::resource('nutritionals_details', NutritionalsDetailController::class);
Route::resource('diets_aliments', DietsAlimentController::class);

// Turnos y días
Route::resource('thunders', ThunderController::class);
Route::resource('days', DayController::class);
Route::resource('daythunders', DayThunderController::class);
Route::get('daythunders/{id_dia}/{id_turno}/edit', [DayThunderController::class, 'edit'])->name('daythunders.edit');
Route::put('/daythunders/{id_dia}/{id_turno}', [DayThunderController::class, 'update'])->name('daythunders.update');
Route::delete('daythunders/{id_dia}/{id_turno}', [DayThunderController::class, 'destroy'])->name('daythunders.destroy');

// Detalles de día y turno
Route::resource('details_days_thunders', DetailsDaysThunderController::class);

// Carga y recomendaciones
Route::post('/loading', [LoadingController::class, 'index']);
Route::get('/api/recommendation/{id}/json', [RecommendationController::class, 'getRecommendationJson']);
Route::get('/recommendation/{id}/view', [RecommendationController::class, 'showRecommendation']);

// Contacto
Route::resource('/contacto', ContactoController::class)->names('contacto');
