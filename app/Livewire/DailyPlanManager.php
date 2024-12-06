<?php

namespace App\Livewire;

use App\Services\UserDataLoader;
use App\Models\{Day, DaysThunder, DayThunder, DetailsDaysThunder, DietAliment};
use Livewire\Component;
use OpenAI;

class DailyPlanManager extends Component
{
    public $userData;

    public function mount()
    {
        $this->userData = new UserDataLoader(auth()->id());
    }

    public function generateDailyPlan()
    {
        $prompt = $this->buildPrompt();

        $client = OpenAI::client(env('OPENIA_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un experto en planificación diaria de actividades.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 1500,
        ]);

        $responseContent = $response['choices'][0]['message']['content'] ?? null;

        if (!$responseContent) {
            throw new \Exception("No se recibió una respuesta válida de la IA.");
        }

        $jsonContent = json_decode($responseContent, true);
        if (!$jsonContent) {
            throw new \Exception("La respuesta de la IA no contiene un JSON válido.");
        }

        $this->saveDailyPlanData($jsonContent);
    }

    private function saveDailyPlanData($jsonContent)
    {
        foreach ($jsonContent['asignaciones'] as $asignacion) {
            $day = Day::firstOrCreate(['name' => $asignacion['dia']]);

            $dayThunder = DayThunder::firstOrCreate([
                'id_dia' => $day->id,
                'id_turno' => $asignacion['turno_id'],
            ]);

            DetailsDaysThunder::create([
                'id_day_thunder' => $dayThunder->id,
                'id_diet_aliment' => $asignacion['diet_aliment_id'],
            ]);
        }
    }

    private function buildPrompt()
    {
        return "
        Basado en estos datos del usuario, genera un plan diario de actividades asignando días y turnos:
        - Edad: {$this->userData->age}
        - Género: {$this->userData->gender}
        - Mediciones: " . json_encode($this->userData->measurements) . "
        - Detalles médicos: " . json_encode($this->userData->medicalDetails) . "
        - Respuestas: " . json_encode($this->userData->answer) . "
        - Recomendación más reciente: {$this->userData->latestRecommendation->content}
        Devuelve un JSON con la siguiente estructura:
        {
            \"asignaciones\": [
                {
                    \"dia\": \"Nombre del día (Monday, Tuesday, ...)\",
                    \"turno_id\": \"ID del turno (1, 2, ...)\",
                    \"diet_aliment_id\": \"ID del diet_aliment relacionado\"
                }
            ]
        }
        ";
    }

    public function render()
    {
        return view('livewire.daily-plan-manager');
    }
}
