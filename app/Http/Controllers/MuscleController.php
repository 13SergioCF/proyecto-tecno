<?php

namespace App\Http\Controllers;

use App\Models\Muscle;
use App\Models\Question;
use Illuminate\Http\Request;
use Livewire\Livewire;

class MuscleController extends Controller
{
    public function index()
    {
        // $questions = Question::all();
        // $muscles = Muscle::where('estado', 'activo')->get();
        // return view('layouts.form', compact('questions', 'muscles'));
    }
    // public function showMuscleComponent()
    // {
    //     $muscleComponent = Livewire::mount('muscle');
    //     return view('muscle.show', [
    //         'muscleComponent' => $muscleComponent->html(),
    //     ]);
    // }
}
