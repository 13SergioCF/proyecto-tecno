<?php

namespace App\Http\Controllers;

use App\Livewire\ExercisePlanLoader;
use App\Livewire\NutritionalPlanLoader;
use Illuminate\Http\Request;

class ExercisePlanController extends Controller
{
    public function generateExercisePlan(Request $request)
    {
        try {
            $component = new ExercisePlanLoader();
            $component->mount();
            $component->generateExercisePlan();

            return response()->json([
                'status' => 'success',
                'message' => 'Plan de ejercicios generado exitosamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function generateNutritionalPlan(Request $request)
    {
        try {
            $component = new NutritionalPlanLoader();
            $component->mount();
            $component->generateNutritionalPlan();

            return response()->json([
                'status' => 'success',
                'message' => 'Plan nutricional generado exitosamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function generateFullPlan(Request $request)
    {
        try {
            // Generar plan de ejercicios
            $exerciseComponent = new ExercisePlanLoader();
            $exerciseComponent->mount();
            $exerciseComponent->generateExercisePlan();

            // Generar plan nutricional
            $nutritionalComponent = new NutritionalPlanLoader();
            $nutritionalComponent->mount();
            $nutritionalComponent->generateNutritionalPlan();

            return response()->json([
                'status' => 'success',
                'message' => 'Plan completo (ejercicios y nutricional) generado exitosamente.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
