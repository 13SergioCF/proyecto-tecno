<?php

namespace App\Http\Controllers;

use App\Models\ExerciseType;
use Illuminate\Http\Request; // Asegúrate de importar la clase Request

class ExerciseTypeController extends Controller
{
    public function index()
    {
        $ejercicios = ExerciseType::all();
        return view('TypeExercises.index', compact('ejercicios'));
    }

    public function create()
    {
        return view('TypeExercises.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
        ]);

        try {
            ExerciseType::create($request->all());
            return response()->json([
                'message' => 'Tipo de Ejercicio agregado exitosamente.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al agregar el Tipo de Ejercicio.',
                'error' => $e->getMessage() // Opcional: para mostrar el error específico
            ], 500); // Código 500 indica error del servidor
        }
    }


    public function edit($id)
    {
        $type  = ExerciseType::findOrFail($id);
        return view('TypeExercises.edit', compact('type'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
        ]);

        try {
            $type = ExerciseType::findOrFail($id);
            $type->nombre = $request->input('nombre');
            $type->descripcion = $request->input('descripcion');
            $type->estado = $request->input('estado');
            $type->save();

            return response()->json([
                'message' => 'Tipo de Ejercicio actualizado correctamente.',
                'data' => $type
            ], 200); // Código 200 para éxito
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al actualizar el Tipo de Ejercicio.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $exerciseType = ExerciseType::find($id);
        if ($exerciseType) {
            $exerciseType->delete();
            return response()->json(['message' => 'Exercise type deleted successfully.']);
        } else {
            return response()->json(['message' => 'Exercise type not found.'], 404);
        }
    }
}
