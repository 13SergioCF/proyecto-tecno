<?php

namespace App\Livewire;

use App\Models\{
    Answer,
    Measurement,
    MedicalDetail,
    Muscle,
    Recommendation,
    User,
};

use Carbon\Carbon;
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
        try {
            $userId = auth()->id();
            $user = User::find($userId);

            if (!$user) {
                throw new \Exception("Usuario no encontrado.");
            }

            $measurements = $this->getLatestMeasurement($userId);
            if (!$measurements) {
                throw new \Exception("No se encontraron mediciones recientes para el usuario.");
            }

            $medicalDetails = $this->getMedicalDetails($userId);
            if (!$medicalDetails) {
                throw new \Exception("No se encontraron detalles médicos para el usuario.");
            }

            $answer = $this->getLatestAnswer($userId);
            if (!$answer) {
                throw new \Exception("No se encontraron respuestas recientes para el usuario.");
            }

            $userMuscles = $user->muscles()->pluck('muscles.id');
            if ($userMuscles->isEmpty()) {
                throw new \Exception("No se encontraron músculos seleccionados para el usuario.");
            }

            $age = $this->calculateAge($user->fecha_nacimiento);
            $gender = $user->genero;
            $prompt = $this->generatePrompt($measurements, $medicalDetails, $answer, $age, $gender);
            $aiResponse = $this->fetchAIRecommendations($prompt);

            // Procesar contenido JSON
            $contentJson = $this->processContentToJson($aiResponse);

            // Guardar en la base de datos
            Recommendation::create([
                'user_id' => $userId,
                'content' => $aiResponse,
                'content_json' => $contentJson,
            ]);

            $this->recommendations = $aiResponse;

            return response()->json([
                'status' => 'success',
                'message' => 'Recomendación generada y almacenada exitosamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    private function processContentToJson($content)
    {
        // Aquí defines la lógica para convertir el contenido en JSON estructurado.
        // Ejemplo de estructura JSON basada en el contenido.
        $lines = explode("\n", $content);
        $json = [];

        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$type, $value] = explode(':', $line, 2);
                $json[] = [
                    'type' => trim($type),
                    'value' => trim($value),
                ];
            }
        }

        return json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    private function calculateAge($dateOfBirth)
    {
        if (!$dateOfBirth) {
            throw new \Exception("La fecha de nacimiento no está disponible.");
        }

        return Carbon::parse($dateOfBirth)->age;
    }

    private function fetchAIRecommendations($prompt)
    {
        $client = OpenAI::client(env('OPENIA_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return $response['choices'][0]['message']['content'] ?? 'No se pudo generar una recomendación.';
    }
    private function getLatestMeasurement($userId)
    {
        return Measurement::where('user_id', $userId)->latest()->first();
    }

    private function getMedicalDetails($userId)
    {
        return MedicalDetail::where('user_id', $userId)->first();
    }

    private function getLatestAnswer($userId)
    {
        return Answer::where('user_id', $userId)->latest()->first();
    }

    private function generatePrompt($measurements, $medicalDetails, $answer, $age, $gender)
    {
        $name = auth()->user()->name;
        $peso = $measurements->peso ?? 'no especificado';
        $talla = $measurements->talla ?? 'no especificado';
        if ($peso === 'no especificado' || $talla === 'no especificado') {
            throw new \Exception("Los datos de peso y talla no son suficientes para generar el prompt.");
        }
        $imc = $measurements->imc ?? 'no calculado';
        $enfermedad_base = $medicalDetails->enfermedad_base ?? 'ninguna';
        $alergias = $medicalDetails->alergia_alimento ?? 'ninguna';
        $musculos_entrenar = auth()->user()->muscles->pluck('nombre')->join(', ') ?? 'no especificado';
        $userAnswers = is_array($answer) ? $answer : (is_object($answer) && isset($answer->respuesta_json) ? json_decode($answer->respuesta_json, true) : []);
        $userAnswers = $userAnswers ?? [];

        $prompt = <<<EOD
    Por favor, asegúrate de iniciar tu respuesta con un saludo personalizado dirigido al usuario, como "Hola {$name}, soy tu guía nutricionista virtual".
    Tambien no te olvides de rellenar la base de datos en las tablas de nutrients, diets_aliments, aliments, food_types, nutritionals_details y nutrients.
    Aquí tienes la información del usuario para que generes una recomendación personalizada:

    ### Información Personal:
    - **Edad:** {$age} años
    - **Sexo:** {$gender}
    - **Peso:** {$peso} kg
    - **Talla:** {$talla}       
    - **IMC:** {$imc}
    - **Enfermedad Base:** {$enfermedad_base}
    - **Alergias Alimentarias:** {$alergias}
    - **Músculos que desea entrenar:** {$musculos_entrenar}

    ### Respuestas del Formulario:
    EOD;

        foreach ($userAnswers as $question => $response) {
            $responseText = is_array($response) ? implode(', ', $response) : $response;
            $prompt .= "\n- **{$question}:** {$responseText}";
        }

        $prompt .= <<<EOD

    Ahora, genera un plan personalizado que incluya:
    1. Menciones sobre su peso y talla del paciente.
    2. Menciones sobre sus alergias y enfermedades de base.
    3. Recomendaciones de ejercicios específicos basados en los músculos que desea entrenar, las condiciones médicas, las respuestas del formulario sexo y su edad.
    4. Dietas recomendadas considerando las alergias, enfermedades y respuestas del formulario. Ten en cuenta que los alimentos recomendados deben ser adecuados a las necesidades nutricionales del usuario, y que si un alimento no tiene un tipo asignado en la base de datos, debe crearse uno nuevo.
    5. Un análisis general del IMC y cómo podría mejorar su estado físico.
    6. Asigna un **nombre único** a la rutina que se está recomendando. Este nombre debe ser asignado a la variable `routineName`.
    7. Evita usar símbolos como: "*","#" ,"-", trata que la charla sea fluida como conversando con signos puntuales.
    8. Recomendaciones de alimentos con sus nutrientes específicos basados en las condiciones médicas, peso y talla y las respuestas del formulario.
    9. Especificar los nutrientes que tienen dichos aliementos recomendados.
    10. Para los alimentos recomendados, asegúrate de asignarles el tipo correcto (por ejemplo, "Fruta" si es una manzana). Si el tipo no existe, debes crearlo de acuerdo con la clasificación nutricional.

    Responde siempre comenzando con el saludo personalizado que incluye el nombre del usuario: "Hola {$name}, soy tu guía nutricionista virtual".
    El nombre de la rutina debe aparecer en la siguiente forma: **Nombre de la rutina: [Aquí tu nombre sugerido]**.
    EOD;

        return $prompt;
    }
}
