<?php

namespace App\Http\Controllers;

use App\Models\Exercise;

class ExerciseController extends Controller
{
    public function index()
    {
        // $users = Exercise::all();
        return view('exercises.index');
        // , compact('exercises'));
    }

    public function create()
    {
        return view('exercises.create');
    }
    public function typeExercise()
    {
        return view('exercises.type_exercise');
    }
}
