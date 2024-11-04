<?php

namespace App\Http\Controllers;

use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questionTypes = QuestionType::all();
        return view('questionTypes.index', compact('questionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questionTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
        ]);

        try {
            QuestionType::create($request->all());
            return response()->json([
                'message' => 'Tipo de Pregunta agregado exitosamente.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al agregar el Tipo de Pregunta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionType $questionTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $questionType  = QuestionType::findOrFail($id);
        return view('questionTypes.edit', compact('questionType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
        ]);

        try {
            $questionType = QuestionType::findOrFail($id);
            $questionType->nombre = $request->input('nombre');
            $questionType->descripcion = $request->input('descripcion');
            $questionType->estado = $request->input('estado');
            $questionType->save();

            return response()->json([
                'message' => 'Tipo de pregunta actualizado correctamente.',
                'data' => $questionType
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al actualizar el Tipo de Pregunta.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $questionType = QuestionType::find($id);
        if ($questionType) {
            $questionType->delete();
            return response()->json(['message' => 'Question type deleted successfully.']);
        } else {
            return response()->json(['message' => 'Question type not found.'], 404);
        }
    }
}
