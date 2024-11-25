<?php

namespace App\Http\Controllers;

use App\Models\Muscle;
use App\Models\Question;
use Illuminate\Http\Request;

class MuscleController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        $muscles = Muscle::where('estado', 'activo')->get();
        return view('layouts.form', compact('questions', 'muscles'));
    }
}
