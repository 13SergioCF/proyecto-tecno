<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('questionType')->get();
        $questionTypes = QuestionType::all();
        return view('questions.index', compact('questions', 'questionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questionTypes = QuestionType::where('estado', 'activo')->get();
        return view('questions.create', compact('questionTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|string|max:255',
            'question_type_id' => 'required|exists:question_types,id',
        ]);

        try {
            Question::create($request->all());

            return response()->json([
                'message' => 'Pregunta agregada exitosamente.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al agregar la pregunta.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        if ($question) {
            $question->delete();
            return response()->json(['message' => 'Question deleted successfully.']);
        } else {
            return response()->json(['message' => 'Question not found.'], 404);
        }
    }
    public function questions()
    {
        $questions = \DB::table('questions')
            ->where('estado', 'activo')
            ->whereNull('deleted_at')
            ->get();
        return view('questions.modal_index', compact('questions'));
    }
    public function startQuestion()
    {
        return view('questions.start');
    }
}
