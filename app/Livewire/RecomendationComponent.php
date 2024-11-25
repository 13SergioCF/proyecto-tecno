<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\Diet;
use App\Models\Exercise;
use App\Models\Measurement;
use App\Models\MedicalDetail;
use Livewire\Component;
use OpenAI;

class RecomendationComponent extends Component
{
    public $recommendations;

    public function render()
    {
        return view('livewire.recomendation-component');
    }

    public function generateRecommendations()
    {
        // Obtener datos del paciente
        $user_id = auth()->id();
        $measurements = Measurement::where('user_id', $user_id)->latest()->first();
        $medicalDetails = MedicalDetail::where('user_id', $user_id)->first();
        $exercises = Exercise::whereHas('muscles', function ($query) use ($user_id) {
            $query->whereIn('muscles.id', auth()->user()->muscles->pluck('id'));
        })->get();

        $answer = Answer::where('user_id', $user_id)->latest()->first();

        // Construir el prompt
        $prompt = $this->generatePrompt($measurements, $medicalDetails, $exercises, $answer);

        // Consultar la API de OpenAI
        $client = OpenAI::client(env('OPENIA_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        // Obtener la recomendación generada
        $this->recommendations = $response['choices'][0]['message']['content'] ?? 'No se pudo generar una recomendación.';

        // Guardar la recomendación en la base de datos
        \App\Models\Recommendation::create([
            'user_id' => $user_id,
            'content' => $this->recommendations,
        ]);
    }

    private function generatePrompt($measurements, $medicalDetails, $exercises, $answer)
    {
        $name = auth()->user()->name;

        // Información básica del paciente
        $peso = $measurements->peso ?? 'no especificado';
        $talla = $measurements->talla ?? 'no especificado';
        $imc = $measurements->imc ?? 'no calculado';
        $enfermedad_base = $medicalDetails->enfermedad_base ?? 'ninguna';
        $alergias = $medicalDetails->alergia_alimento ?? 'ninguna';
        $musculos_entrenar = auth()->user()->muscles->pluck('name')->join(', ') ?? 'no especificado';

        // Decodificar las respuestas del usuario en JSON
        $userAnswers = json_decode($answer->respuesta_json, true) ?? [];

        // Comenzar con un saludo
        $prompt = <<<EOD
        Por favor, asegúrate de iniciar tu respuesta con un saludo personalizado dirigido al usuario, como "Hola {$name}, soy tu guía nutricionista virtual".
    
        Aquí tienes la información del usuario para que generes una recomendación personalizada:
    
        ### Información Personal:
        - **Peso:** {$peso} kg
        - **Talla:** {$talla} m
        - **IMC:** {$imc}
        - **Enfermedad Base:** {$enfermedad_base}
        - **Alergias Alimentarias:** {$alergias}
        - **Músculos que desea entrenar:** {$musculos_entrenar}
    
        ### Respuestas del Formulario:
        EOD;

        // Agregar las respuestas específicas del usuario desde el JSON
        foreach ($userAnswers as $question => $response) {
            $responseText = is_array($response) ? implode(', ', $response) : $response;
            $prompt .= "\n- **{$question}:** {$responseText}";
        }

        $prompt .= "\n\n### Ejercicios Disponibles:";
        foreach ($exercises as $exercise) {
            $prompt .= "\n- **{$exercise->name}:** {$exercise->description}";
        }

        $prompt .= <<<EOD
    
        Ahora, genera un plan personalizado que incluya:
        1. Menciones sobre su peso y talla del paciente 
        2. Menciones sobre su alergias y enfermedades de base
        3. Recomendaciones de ejercicios específicos basados en los músculos que desea entrenar, las condiciones médicas y las respuestas del formulario.
        4. Dietas recomendadas considerando las alergias, enfermedades y respuestas del formulario.
        5. Un análisis general del IMC y cómo podría mejorar su estado físico.
    
        Responde siempre comenzando con el saludo personalizado que incluye el nombre del usuario: "Hola {$name}, soy tu guía nutricionista virtual".
        EOD;

        return $prompt;
    }
}
