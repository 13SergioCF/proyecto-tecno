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

    public function update(Request $request, Aliment $aliment)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'food_type_id' => 'required|exists:food_types,id',
        ]);
    
        try {
            $aliment->update($validated);
    
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Alimento actualizado exitosamente.',
                    'data' => $aliment,
                ], 200);
            }
    
            return redirect()->route('aliments.index')->with('success', 'Alimento actualizado exitosamente.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Ocurrió un error al actualizar el alimento.',
                    'error' => $e->getMessage(),
                ], 500);
            }
    
            return redirect()->back()->with('error', 'Error al actualizar el alimento.');
        }
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
