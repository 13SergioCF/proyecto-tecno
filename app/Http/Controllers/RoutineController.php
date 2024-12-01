<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoutineController extends Controller
{
    public function index()
    {
        $routines = Routine::all();
        return view('routines.indexx', compact('routines'));
    }
    public function create()
    {
        return view('routines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel' => 'required|in:principiante,intermedio,avanzado',
            'duracion_estimada' => 'nullable|integer',
            'objetivo' => 'nullable|string|max:255',
            'frecuencia_semanal' => 'nullable|integer',
        ]);

        try {
            Routine::create($request->all());

            return response()->json([
                'message' => 'Rutina agregada exitosamente.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al agregar la rutina.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $routine = Routine::findOrFail($id);
        return view('routines.edit', compact('routine'));
    }

    public function update(Request $request, Routine $routine)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'nivel' => 'required|in:principiante,intermedio,avanzado',
            'duracion_estimada' => 'required|integer',
            'objetivo' => 'required|string|max:255',
            'frecuencia_semanal' => 'required|integer',
            'estado' => 'required|string',
        ]);

        try {
            $routine->update($validated);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Rutina actualizada exitosamente.',
                    'data' => $routine,
                ], 200);
            }

            return redirect()->route('routines.index')->with('success', 'rutina actualizado exitosamente.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Ocurrió un error al actualizar el rutina.',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Error al actualizar la rutina.');
        }
    }

    public function show($id)
    {
        $routine = Routine::findOrFail($id);
        $ejercicios = $routine->ejercicios;  // Suponemos que esta es la relación con los ejercicios
        $muscleFocusData = $this->getMuscleFocusData($ejercicios);
        $difficultyDistribution = $this->getDifficultyDistribution($ejercicios);
        return view('routines.show', compact('routine', 'muscleFocusData', 'difficultyDistribution'));
    }


    private function getMuscleFocusData($ejercicios)
    {
        $muscleFocusData = [];
        if ($ejercicios) {
            foreach ($ejercicios as $ejercicio) {
                $musculos = $ejercicio->muscles; // Esto debería ser una colección de músculos
                if ($musculos && $musculos->isNotEmpty()) {
                    foreach ($musculos as $musculo) {
                        $musculoName = $musculo->nombre; // Asegúrate de que 'nombre' esté presente en el modelo 'Muscle'
                        if (isset($muscleFocusData[$musculoName])) {
                            $muscleFocusData[$musculoName]++;
                        } else {
                            $muscleFocusData[$musculoName] = 1;
                        }
                    }
                }
            }
        }
        return $muscleFocusData;
    }


    private function getDifficultyDistribution($ejercicios)
    {
        $difficultyDistribution = [
            'principiante' => 0,
            'intermedio' => 0,
            'avanzado' => 0,
        ];
        if ($ejercicios) {
            foreach ($ejercicios as $ejercicio) {
                $dificultad = $ejercicio->dificultad;
                if (isset($difficultyDistribution[$dificultad])) {
                    $difficultyDistribution[$dificultad]++;
                }
            }
        }
        return $difficultyDistribution;
    }

    public function destroy($id)
    {
        $routines = Routine::find($id);
        if ($routines) {
            $routines->delete();
            return response()->json(['message' => 'Rutina Eliminada Satisfactoriamente.']);
        } else {
            return response()->json(['message' => 'routines not found.'], 404);
        }
    }
}
