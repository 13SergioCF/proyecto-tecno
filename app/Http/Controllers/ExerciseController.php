<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\ExerciseType;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::with('exerciseType')->get();
        $exerciseTypes = ExerciseType::all();
        return view('exercises.index', compact('exercises', 'exerciseTypes'));
    }


    public function create()
    {
        $exerciseTypes = ExerciseType::where('estado', 'activo')->get();
        return view('exercises.create', compact('exerciseTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'dificultad' => 'required|in:fácil,medio,difícil',
            'duracion_estimada' => 'nullable|integer',
            'exercise_type_id' => 'required|exists:exercise_types,id',
        ]);

        try {
            Exercise::create($request->all());

            return response()->json([
                'message' => 'Ejercicio agregado exitosamente.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al agregar el Ejercicio.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $exercise  = Exercise::findOrFail($id);
        $exerciseTypes = ExerciseType::where('estado', 'activo')->get();
        return view('exercises.edit', compact('exercise', 'exerciseTypes'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'dificultad' => 'required|in:fácil,medio,difícil',
            'duracion_estimada' => 'nullable|integer',
            'exercise_type_id' => 'required|exists:exercise_types,id',
            'estado' => 'required|string',
        ]);

        try {
            $exercise->update($validated);
            return response()->json([
                'message' => 'Ejercicio actualizado exitosamente.',
                'data' => $exercise
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al actualizar el ejercicio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {

        $exercise = Exercise::find($id);
        if ($exercise) {
            $exercise->delete();
            return response()->json(['message' => 'Ejercicio Eliminado Satisfactoriamente.']);
        } else {
            return response()->json(['message' => 'Exercise type found.'], 404);
        }
    }

    public function typeExercise()
    {
        return view('exercises.type_exercise');
    }
}
