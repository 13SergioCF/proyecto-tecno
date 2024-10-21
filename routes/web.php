<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TypeExerciseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\NutrientController;
use App\Http\Controllers\AlimentController;

// Ruta para la página de login
Route::get('/', function () {
    return view('auth/login');
});

// Autenticación
Auth::routes();

// Agrupar las rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {

    // Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Gestión de usuarios
    Route::resource('users', UserController::class);
    Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');

    // Ejercicios
    Route::resource('exercises', ExerciseController::class);
    Route::resource('types', TypeExerciseController::class);

    // Tipos de alimentos
    Route::resource('food-types', FoodTypeController::class);
    Route::get('food-types/export/pdf', [FoodTypeController::class, 'exportPDF'])->name('food-types.export.pdf');
    

    // Nutrientes
    Route::resource('nutrients', NutrientController::class);
    Route::get('nutrients/export/pdf', [NutrientController::class, 'exportPdf'])->name('nutrients.export.pdf');


    //Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // gestion de alimento 
    
   
    Route::resource('aliments', AlimentController::class);


// Ruta para exportar a PDF
Route::get('aliments/export/pdf', [AlimentController::class, 'exportPdf'])->name('aliments.exportPdf');


});
