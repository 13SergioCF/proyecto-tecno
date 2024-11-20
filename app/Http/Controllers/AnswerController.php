<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Measurement;
use App\Models\MedicalDetail;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la entrada del formulario
        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
            'peso' => 'nullable|numeric|min:0',
            'talla' => 'nullable|numeric|min:0',
            'enfermedadBase' => 'required|string|in:si,no',
            'tipoEnfermedad' => 'nullable|string',
            'alergiaAlimento' => 'required|string|in:si,no',
            'tipoAlergia' => 'nullable|string',
        ]);

        // Obtener el ID del usuario autenticado
        $user_id = auth()->user()->id;

        // Guardar las respuestas de las preguntas
        $this->saveQuestionAnswers($validatedData['answers'], $user_id);

        // Guardar las mediciones si están presentes
        if ($request->has(['peso', 'talla'])) {
            $this->saveMeasurement($user_id, $validatedData['peso'], $validatedData['talla']);
        }

        // Guardar información médica
        $this->saveMedicalDetails(
            $user_id,
            $validatedData['enfermedadBase'],
            $validatedData['tipoEnfermedad'],
            $validatedData['alergiaAlimento'],
            $validatedData['tipoAlergia']
        );

        // Responder con éxito
        return response()->json([
            'status' => 'success',
            'message' => 'Respuestas guardadas exitosamente, incluyendo peso, talla e información médica.',
        ]);
    }

    /**
     * Guardar respuestas de las preguntas.
     */
    private function saveQuestionAnswers(array $answers, int $user_id)
    {
        foreach ($answers as $question_id => $answer) {
            $question = Question::find($question_id);

            if (!$question) {
                continue; // Saltar si la pregunta no existe
            }

            $respuesta_json = $this->formatAnswer($question, $answer);

            Answer::create([
                'user_id' => $user_id,
                'question_id' => $question_id,
                'respuesta_json' => $respuesta_json,
            ]);
        }
    }

    /**
     * Formatear la respuesta según el formato de la pregunta.
     */
    private function formatAnswer(Question $question, $answer): string
    {
        if ($question->formato === 'eleccion_multiple') {
            if ($question->seleccion_multiple === 'si') {
                $selectedOptionTexts = QuestionOption::whereIn('id', $answer)->pluck('texto')->toArray();
                return json_encode([
                    'tipo' => 'seleccion_multiple',
                    'valor' => $selectedOptionTexts
                ]);
            } else {
                $selectedOptionText = QuestionOption::where('id', $answer)->value('texto');
                return json_encode([
                    'tipo' => 'seleccion_unica',
                    'valor' => [$selectedOptionText]
                ]);
            }
        }

        return json_encode([
            'tipo' => 'redaccion',
            'valor' => [$answer]
        ]);
    }

    /**
     * Guardar mediciones (peso, talla, IMC).
     */
    private function saveMeasurement(int $user_id, float $peso, float $talla)
    {
        if ($talla > 10) {
            $talla = $talla / 100; // Convertir a metros si está en centímetros
        }

        $imc = null;
        if ($peso > 0 && $talla > 0) {
            $imc = round($peso / ($talla * $talla), 2);
        }

        Measurement::create([
            'user_id' => $user_id,
            'peso' => $peso,
            'talla' => $talla,
            'imc' => $imc,
        ]);
    }

    /**
     * Guardar detalles médicos.
     */
    private function saveMedicalDetails(
        int $user_id,
        string $enfermedadBase,
        ?string $tipoEnfermedad,
        string $alergiaAlimento,
        ?string $tipoAlergia
    ) {
        $data = [
            'enfermedad_base' => $enfermedadBase === 'si' ? ($tipoEnfermedad ?? 'No especificado') : 'No tiene enfermedad',
            'alergia_alimento' => $alergiaAlimento === 'si' ? ($tipoAlergia ?? 'No especificado') : 'No tiene alergias',
        ];

        MedicalDetail::updateOrCreate(['user_id' => $user_id], $data);
    }
    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
