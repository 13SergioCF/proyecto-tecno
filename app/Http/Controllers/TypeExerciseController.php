<?php

namespace App\Http\Controllers;

use App\Models\ExerciseType;
use Illuminate\Http\Request; // Asegúrate de importar la clase Request

class TypeExerciseController extends Controller
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
        $exerciseType = new ExerciseType();
        $exerciseType->nombre = $request->nombre;
        $exerciseType->descripcion = $request->descripcion;
        $exerciseType->save();
        return redirect()->route('types.index')->with('success', 'Tipo de Ejercicio agregado exitosamente.');
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
        ]);

        try {
            $type = ExerciseType::findOrFail($id);
            $type->nombre = $request->input('nombre');
            $type->descripcion = $request->input('descripcion');
            $type->save();

            return redirect()->route('types.index')->with('success', 'Tipo de Ejercicio actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el Tipo de Ejercicio.');
        }
    }


    public function destroy($id)
    {
        $exerciseType = ExerciseType::findOrFail($id);
        $exerciseType->delete(); // Soft delete

        return redirect()->route('exercises.index')->with('success', 'Tipo de ejercicio eliminado con éxito.');
    }
}
