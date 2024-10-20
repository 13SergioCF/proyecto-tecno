<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TypeExerciseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class);
Route::resource('exercises', ExerciseController::class);
Route::resource('types', TypeExerciseController::class);




// para pdf y excel

Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
