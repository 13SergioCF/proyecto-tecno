<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Measurement;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionType;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('opciones', 'questionType')->get();
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
            'formato' => 'required|in:eleccion_multiple,redaccion',
            'seleccion_multiple' => 'required_if:formato,eleccion_multiple|in:si,no',
        ]);

        if ($request->formato === 'eleccion_multiple') {
            $request->validate([
                'opciones' => 'required|array',
                'opciones.*' => 'string|max:255',
            ]);
        }

        try {
            $question = Question::create($request->only(['contenido', 'question_type_id', 'formato', 'seleccion_multiple']));

            if ($request->formato === 'eleccion_multiple' && isset($request->opciones)) {
                foreach ($request->opciones as $opcion) {
                    $question->opciones()->create(['texto' => $opcion]);
                }
            }

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
        $questions = Question::with('opciones')->where('estado', 'activo')->whereNull('deleted_at')->get();
        return view('questions.modal_index', compact('questions'));
    }
    public function startQuestion()
    {
        return view('questions.start');
    }
 
}
