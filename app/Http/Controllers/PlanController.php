<?php

namespace App\Http\Controllers;

use App\Livewire\NutritionalPlanLoader;
use App\Livewire\ExercisePlanLoader;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Muestra el plan nutricional y de ejercicios.
     */
    public function showNutritionalAndExercisePlan()
    {
        try {
            $nutritionLoader = new NutritionalPlanLoader();
            $exerciseLoader = new ExercisePlanLoader();

            // Obtener los datos
            $nutritionPlan = $nutritionLoader->getWeeklyNutritionPlan(); // Plan semanal de nutrición
            $exercisePlan = $exerciseLoader->getWeeklyExercisePlan(); // Plan semanal de ejercicios
            $dailyTips = $nutritionLoader->getDailyTips(); // Consejos dinámicos diarios
            $weeklyStats = $nutritionLoader->getWeeklyStats($nutritionPlan, $exercisePlan); // Estadísticas semanales

            // Pasar los datos a la vista
            return view('nutritional-plan.index', compact('nutritionPlan', 'exercisePlan', 'dailyTips', 'weeklyStats'));
        } catch (\Exception $e) {
            // Manejo de errores
            return back()->with('error', $e->getMessage());
        }
    }
}
