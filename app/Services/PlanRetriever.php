<?php

namespace App\Services;

use App\Models\Diet;
use App\Models\Exercise;
use App\Models\NutritionalsDetail;
use Carbon\Carbon;
use OpenAI;

class PlanRetriever
{
    /**
     * Obtiene los datos del plan de ejercicios.
     *
     * @return array
     */
    public function getExercisePlan()
    {
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $exercisePlan = [];

        foreach ($days as $day) {
            $exercisePlan[$day] = Exercise::inRandomOrder()
                ->take(3)
                ->pluck('nombre')
                ->toArray();
        }

        return $exercisePlan;
    }

    /**
     * Obtiene los datos del plan nutricional.
     *
     * @return array
     */
    public function getNutritionPlan()
    {
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $nutritionPlan = [];

        foreach ($days as $day) {
            $nutritionPlan[$day] = Diet::inRandomOrder()
                ->take(3)
                ->pluck('descripcion')
                ->toArray();
        }

        return $nutritionPlan;
    }

    /**
     * Obtiene consejos diarios dinámicos utilizando la IA.
     *
     * @return array
     */
    public function getDailyTips()
    {
        $client = OpenAI::client(env('OPENAI_API_KEY'));
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $dailyTips = [];

        foreach ($days as $day) {
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un experto en nutrición y salud.'],
                    ['role' => 'user', 'content' => "Dame un consejo nutricional breve y efectivo para el día $day."],
                ],
                'max_tokens' => 50,
            ]);

            $dailyTips[$day] = $response['choices'][0]['message']['content'] ?? "Recuerda llevar una dieta balanceada.";
        }

        return $dailyTips;
    }

    /**
     * Calcula las estadísticas semanales basadas en datos nutricionales y de ejercicio.
     *
     * @param array $nutritionPlan
     * @param array $exercisePlan
     * @return array
     */
    public function getWeeklyStats($nutritionPlan, $exercisePlan)
    {
        $totalCalories = 0;
        $totalExerciseHours = 0;

        foreach ($nutritionPlan as $day => $diets) {
            foreach ($diets as $dietDescription) {
                $diet = Diet::where('descripcion', $dietDescription)->first();
                if ($diet) {
                    $nutritionalDetails = NutritionalsDetail::where('id_alimento', $diet->id)
                        ->pluck('cantidad_calorias')
                        ->toArray();

                    $totalCalories += array_sum($nutritionalDetails);
                }
            }
        }

        foreach ($exercisePlan as $day => $exercises) {
            foreach ($exercises as $exerciseName) {
                $exercise = Exercise::where('nombre', $exerciseName)->first();
                if ($exercise) {
                    // Asume que cada ejercicio dura 30 minutos.
                    $totalExerciseHours += 0.5; // 0.5 horas = 30 minutos
                }
            }
        }

        return [
            'calories' => $totalCalories,
            'exerciseHours' => $totalExerciseHours,
            'completedDays' => rand(1, 7) // Simula días completados (puedes cambiar esta lógica)
        ];
    }
}
