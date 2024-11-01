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
        return view('routines.index', compact('routines'));
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
            'duracion_estimada' => 'nullable|integer',
            'objetivo' => 'nullable|string|max:255',
            'frecuencia_semanal' => 'nullable|integer',
            'estado' => 'required|in:activo,inactivo',
        ]);

        try {
            $routine->update($validated);
            return response()->json([
                'message' => 'Rutina actualizada exitosamente.',
                'data' => $routine
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al actualizar el rutina.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $routines = Routine::findOrFail($id);
            $routines->delete();
            return response()->json(['message' => 'Rutina eliminada exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la rutina.', 'error' => $e->getMessage()], 500);
        }
    }
}
