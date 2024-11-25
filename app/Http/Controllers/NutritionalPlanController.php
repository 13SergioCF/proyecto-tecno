<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NutritionalPlanController extends Controller
{
    public function index()
    {
        return view('nutritionalPlan.index');
    }
    public function showPlan()
    {
        $nutritionPlan = [
            'Lunes' => ['Desayuno: Avena con frutas', 'Almuerzo: Ensalada de pollo', 'Cena: Salmón al horno'],
            'Martes' => ['Desayuno: Tostadas integrales', 'Almuerzo: Wrap de pavo', 'Cena: Pasta integral con verduras'],
            'Miércoles' => ['Desayuno: Yogur con granola', 'Almuerzo: Sopa de lentejas', 'Cena: Pechuga de pollo a la plancha'],
            'Jueves' => ['Desayuno: Batido de proteínas', 'Almuerzo: Ensalada de atún', 'Cena: Tofu salteado con verduras'],
            'Viernes' => ['Desayuno: Huevos revueltos', 'Almuerzo: Bowl de quinoa', 'Cena: Pescado a la parrilla'],
            'Sábado' => ['Desayuno: Pancakes de avena', 'Almuerzo: Sandwich integral', 'Cena: Pavo asado con vegetales'],
            'Domingo' => ['Desayuno: Frutas variadas', 'Almuerzo: Paella de mariscos', 'Cena: Ensalada mixta con nueces']
        ];

        $exercisePlan = [
            'Lunes' => ['30 min cardio', '3 series de sentadillas', '3 series de flexiones'],
            'Martes' => ['45 min natación', '3 series de press de banca', '3 series de remo'],
            'Miércoles' => ['1 hora yoga', '3 series de zancadas', '3 series de elevaciones laterales'],
            'Jueves' => ['40 min bicicleta', '3 series de peso muerto', '3 series de curl de bíceps'],
            'Viernes' => ['30 min HIIT', '3 series de fondos', '3 series de plancha'],
            'Sábado' => ['1 hora caminata', '3 series de burpees', '3 series de abdominales'],
            'Domingo' => ['Día de descanso activo', 'Estiramientos suaves', 'Meditación']
        ];

        return view('nutritionalPlan.index', compact('nutritionPlan', 'exercisePlan'));
    }
}
