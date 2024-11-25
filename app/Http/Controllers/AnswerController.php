<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Measurement;
use App\Models\MedicalDetail;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\User;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
            'peso' => 'nullable|numeric|min:0',
            'talla' => 'nullable|numeric|min:0',
            'enfermedadBase' => 'required|string|in:si,no',
            'tipoEnfermedad' => 'nullable|string',
            'alergiaAlimento' => 'required|string|in:si,no',
            'tipoAlergia' => 'nullable|string',
            'muscles' => 'nullable|array',
            'muscles.*' => 'exists:muscles,id',
        ]);

        $user_id = auth()->id();

        $this->saveQuestionAnswers($validatedData['answers'], $user_id);

        if ($request->has(['peso', 'talla'])) {
            $this->saveMeasurement($user_id, $validatedData['peso'], $validatedData['talla']);
        }

        $this->saveMedicalDetails(
            $user_id,
            $validatedData['enfermedadBase'],
            $validatedData['tipoEnfermedad'],
            $validatedData['alergiaAlimento'],
            $validatedData['tipoAlergia']
        );

        if ($request->has('muscles')) {
            $this->saveSelectedMuscles($user_id, $validatedData['muscles']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Respuestas guardadas exitosamente.',
        ]);
    }

    private function saveQuestionAnswers(array $answers, int $user_id): void
    {
        foreach ($answers as $question_id => $answer) {
            $question = Question::find($question_id);
            if (!$question) {
                continue;
            }

            Answer::create([
                'user_id' => $user_id,
                'question_id' => $question_id,
                'respuesta_json' => $this->formatAnswer($question, $answer),
            ]);
        }
    }

    private function formatAnswer(Question $question, $answer): string
    {
        if ($question->formato === 'eleccion_multiple') {
            return $this->formatMultipleChoiceAnswer($question, $answer);
        }

        return json_encode(['tipo' => 'redaccion', 'valor' => [$answer]]);
    }

    private function formatMultipleChoiceAnswer(Question $question, $answer): string
    {
        if ($question->seleccion_multiple === 'si') {
            $options = QuestionOption::whereIn('id', $answer)->pluck('texto')->toArray();
            return json_encode(['tipo' => 'seleccion_multiple', 'valor' => $options]);
        }

        $option = QuestionOption::where('id', $answer)->value('texto');
        return json_encode(['tipo' => 'seleccion_unica', 'valor' => [$option]]);
    }

    private function saveMeasurement(int $user_id, float $peso, float $talla): void
    {
        $talla = $talla > 10 ? $talla / 100 : $talla;

        $imc = ($peso > 0 && $talla > 0) ? round($peso / ($talla * $talla), 2) : null;

        Measurement::create([
            'user_id' => $user_id,
            'peso' => $peso,
            'talla' => $talla,
            'imc' => $imc,
        ]);
    }

    private function saveMedicalDetails(
        int $user_id,
        string $enfermedadBase,
        ?string $tipoEnfermedad,
        string $alergiaAlimento,
        ?string $tipoAlergia
    ): void {
        $data = [
            'enfermedad_base' => $enfermedadBase === 'si' ? ($tipoEnfermedad ?? 'No especificado') : 'No tiene enfermedad',
            'alergia_alimento' => $alergiaAlimento === 'si' ? ($tipoAlergia ?? 'No especificado') : 'No tiene alergias',
        ];

        MedicalDetail::updateOrCreate(['user_id' => $user_id], $data);
    }

    private function saveSelectedMuscles(int $user_id, array $muscles): void
    {
        User::findOrFail($user_id)->muscles()->sync($muscles);
    }
}
