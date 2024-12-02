<?php

namespace App\Livewire;

use App\Models\Recommendation;
use Livewire\Component;

class ConvertRecommendation extends Component
{
    public $recommendationsJson = [];
    public function render()
    {
        return view('livewire.convert-recommendation');
    }
    public function fetchRecommendations()
    {
        try {
            $userId = auth()->id();
            $recommendations = Recommendation::where('user_id', $userId)->get();

            if ($recommendations->isEmpty()) {
                throw new \Exception("No se encontraron recomendaciones para este usuario.");
            }

            $this->recommendationsJson = $recommendations->map(function ($recommendation) {
                return [
                    'id' => $recommendation->id,
                    'content' => $this->processRecommendationToJson($recommendation->content),
                    'created_at' => $recommendation->created_at->toDateTimeString(),
                ];
            });
        } catch (\Exception $e) {
            $this->recommendationsJson = ['error' => $e->getMessage()];
        }
    }

    private function processRecommendationToJson(string $recommendationText): array
    {
        // Procesa el contenido para extraer datos específicos
        try {
            preg_match('/Nombre de la rutina:\s*(.*?)\n/', $recommendationText, $routineNameMatch);
            preg_match('/Dieta:\s*(.*?)\n/', $recommendationText, $dietMatch);

            return [
                'routine_name' => $routineNameMatch[1] ?? 'No especificado',
                'diet' => $dietMatch[1] ?? 'No especificado',
            ];
        } catch (\Exception $e) {
            return ['error' => 'Error al procesar la recomendación: ' . $e->getMessage()];
        }
    }
}
