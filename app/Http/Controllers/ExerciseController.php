<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\ExerciseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class ExerciseController extends Controller
{
    // Mostrar lista de ejercicios
    public function index(Request $request)
    {
        $estado = $request->input('estado', 'all');
        $exerciseType = $request->input('exercise_type', null);

        $exercises = Exercise::query();

        if ($estado !== 'all') {
            $exercises->where('estado', $estado);
        }

        if ($exerciseType) {
            $exercises->where('exercise_type_id', $exerciseType);
        }

        $exercises = $exercises->with('exerciseType')->get();

        $exerciseTypes = ExerciseType::where('estado', 'activo')->get();

        return view('exercises.index', compact('exercises', 'exerciseTypes', 'estado', 'exerciseType'));
    }

    // Crear un nuevo ejercicio
    public function create()
    {
        $exerciseTypes = ExerciseType::all();
        return view('exercises.create', compact('exerciseTypes'));
    }

    // Mostrar un ejercicio específico
    public function show($id)
    {
        try {
            $exercise = Exercise::findOrFail($id);
            return view('exercises.show', compact('exercise'));
        } catch (\Exception $e) {
            return redirect()->route('exercises.index')->with('error', 'Ejercicio no encontrado.');
        }
    }

    // Almacenar un nuevo ejercicio
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'exercise_type_id' => 'required|exists:exercise_types,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'video' => 'nullable|mimes:mp4,avi,mov|max:50000',
        ]);

        try {
            $exercise = new Exercise();
            $exercise->nombre = $request->nombre;
            $exercise->descripcion = $request->descripcion;
            $exercise->exercise_type_id = $request->exercise_type_id;
            $exercise->estado = 'activo';

            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('public/imagenes');
                $exercise->imagen_url = Storage::url($imagenPath);
            }

            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('public/videos');
                $exercise->video_url = Storage::url($videoPath);
            }

            $exercise->save();

            return redirect()->route('exercises.index')->with('success', 'Ejercicio agregado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al agregar el ejercicio: ' . $e->getMessage());
        }
    }

    // Editar ejercicio
    public function edit($id)
    {
        try {
            $exercise = Exercise::findOrFail($id);
            $exerciseTypes = ExerciseType::all(); 
            return view('exercises.edit', compact('exercise', 'exerciseTypes'));
        } catch (\Exception $e) {
            return redirect()->route('exercises.index')->with('error', 'El ejercicio no fue encontrado.');
        }
    }

    // Actualizar ejercicio
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
            'exercise_type_id' => 'required|exists:exercise_types,id',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'video' => 'nullable|mimes:mp4,avi,mov|max:50000',
        ]);

        try {
            $exercise = Exercise::findOrFail($id);
            $exercise->nombre = $request->nombre;
            $exercise->descripcion = $request->descripcion;
            $exercise->estado = $request->estado;
            $exercise->exercise_type_id = $request->exercise_type_id;

            if ($request->hasFile('imagen')) {
                if ($exercise->imagen_url) {
                    Storage::delete('public/imagenes/' . basename($exercise->imagen_url));
                }
                $imagenPath = $request->file('imagen')->store('public/imagenes');
                $exercise->imagen_url = Storage::url($imagenPath);
            }

            if ($request->hasFile('video')) {
                if ($exercise->video_url) {
                    Storage::delete('public/videos/' . basename($exercise->video_url));
                }
                $videoPath = $request->file('video')->store('public/videos');
                $exercise->video_url = Storage::url($videoPath);
            }

            $exercise->save();

            return redirect()->route('exercises.index')->with('success', 'Ejercicio actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el ejercicio: ' . $e->getMessage());
        }
    }

    // Cambiar estado a "inactivo" en lugar de eliminar
    public function destroy($id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Ejercicio no encontrado.'], 404);
        }

        try {
            $exercise->update(['estado' => 'inactivo']);
            return response()->json(['message' => 'El estado del ejercicio se actualizó a inactivo.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el estado: ' . $e->getMessage()], 500);
        }
    }

    // Exportar a PDF
    public function exportPdf(Request $request)
    {
        $estado = $request->input('estado', null);
        $exerciseType = $request->input('exercise_type', null);

        $exercises = Exercise::query();

        if ($estado) {
            $exercises = $exercises->where('estado', $estado);
        }

        if ($exerciseType) {
            $exercises = $exercises->where('exercise_type_id', $exerciseType);
        }

        $exercises = $exercises->with('exerciseType')->get();

        $pdf = PDF::loadView('exercises.pdf', compact('exercises'));
        return $pdf->download('ejercicios.pdf');
    }

    // Subir multimedia (imagen y video)
    public function uploadMedia(Request $request, $id)
    {
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'video' => 'nullable|mimes:mp4,avi,mov|max:50000',
        ]);

        $exercise = Exercise::findOrFail($id);

        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('public/imagenes');
            $exercise->imagen_url = Storage::url($imagenPath);
        }

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('public/videos');
            $exercise->video_url = Storage::url($videoPath);
        }

        $exercise->save();

        return response()->json(['message' => 'Archivos cargados exitosamente.']);
    }
}
