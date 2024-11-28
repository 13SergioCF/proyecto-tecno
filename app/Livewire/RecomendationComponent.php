<?php

namespace App\Livewire;

use App\Models\{
    Aliment,
    Answer,
    Diet,
    DietsAliment,
    Exercise,
    ExerciseMuscle,
    Measurement,
    MedicalDetail,
    Routine,
    RoutineExercise,
    ExerciseType,
    FoodType,
    Recommendation,
    Muscle,
    Nutrient,
    NutritionalsDetail,
    Period
};
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
        $userId = auth()->id();
        $measurements = $this->getLatestMeasurement($userId);
        $medicalDetails = $this->getMedicalDetails($userId);
        $answer = $this->getLatestAnswer($userId);

        $userMuscles = auth()->user()->muscles()->pluck('muscles.id');
        if ($userMuscles->isEmpty()) {
            $this->recommendations = "No se encontraron músculos seleccionados para el usuario.";
            return;
        }

        $prompt = $this->generatePrompt($measurements, $medicalDetails, [], $answer);
        $this->recommendations = $this->fetchAIRecommendations($prompt);

        Recommendation::create([
            'user_id' => $userId,
            'content' => $this->recommendations,
        ]);

        $this->saveExercisesAndRoutines($userId, $userMuscles, $measurements);
        $this->saveDiet($userId, $this->recommendations);
    }


    private function saveDiet($userId, $recommendations)
    {
        $foodItems = $this->extractFoodItems($recommendations);
        $period = $this->savePeriod($recommendations);

        $diet = Diet::create([
            'descripcion' => 'Dieta personalizada basada en recomendaciones',
            'tipo' => 'nutrición',
            'id_periodo' => $period->id,
        ]);

        foreach ($foodItems as $food) {
            $foodType = $this->saveFoodType($food['type']);
            $aliment = $this->saveAliment($food, $foodType);
            $this->saveNutritionalDetails($aliment, $food);
            $this->saveDietsAliment($diet, $aliment);
        }
    }
    private function savePeriod($recommendations)
    {
        // Aquí puedes extraer la fecha de inicio y final de las recomendaciones si está disponible
        $startDate = now();
        $endDate = now()->addWeeks(4);  // Ejemplo: 4 semanas

        return Period::create([
            'fecha_inicio' => $startDate,
            'fecha_final' => $endDate,
            'estado' => 'activo',
        ]);
    }

    private function saveFoodType($foodTypeName)
    {
        return FoodType::firstOrCreate([
            'nombre' => $foodTypeName,
            'descripcion' => "Descripción del tipo de alimento",
            'estado' => 'activo',
        ]);
    }
    private function saveAliment($food, $foodType)
    {
        return Aliment::create([
            'nombre' => $food['name'],
            'food_type_id' => $foodType->id,
            'descripcion' => $food['description'] ?? null,
            'estado' => 'activo',
            'imagen_url' => $food['image_url'] ?? null,
            'video_url' => $food['video_url'] ?? null,
        ]);
    }
    private function saveNutrient($nutrientName)
    {
        return Nutrient::firstOrCreate([
            'nombre' => $nutrientName,
            'descripcion' => 'Descripción del nutriente',
            'estado' => 'activo',
        ]);
    }

    private function saveNutritionalDetails($aliment, $food)
    {
        // Verifica que los nutrientes se extraigan correctamente
        if (!isset($food['nutrients']) || empty($food['nutrients'])) {
            return; // Si no hay nutrientes, no intentamos guardar nada
        }

        foreach ($food['nutrients'] as $nutrientName => $quantity) {
            // Verificar si el nutriente ya existe
            $nutrient = Nutrient::firstOrCreate([
                'nombre' => $nutrientName,
                'descripcion' => "Descripción de {$nutrientName}",
                'estado' => 'activo',
            ]);

            // Ahora creamos la relación entre el alimento y el nutriente, guardando la cantidad de calorías
            NutritionalsDetail::create([
                'id_alimento' => $aliment->id,
                'id_nutriente' => $nutrient->id,
                'cantidad_calorias' => $quantity['calories'] ?? 0, // Asegúrate de tener un valor válido para las calorías
            ]);
        }
    }

    private function saveDietsAliment(Diet $diet, Aliment $aliment)
    {
        DietsAliment::create([
            'id_dieta' => $diet->id,
            'id_alimento' => $aliment->id,
        ]);
    }


    private function extractFoodItems($recommendations)
    {
        preg_match_all('/(alimento:|comida:|recomienda:)\s*([a-zA-Z\s]+)\s*\((\w+)\)\s*([0-9]+)\s*(g|ml)\s*(\d+)\s*calorias.*proteinas: (\d+)\sg.*carbohidratos: (\d+)\sg.*grasa: (\d+)/', $recommendations, $matches, PREG_SET_ORDER);
        $foodItems = [];

        foreach ($matches as $match) {
            $foodItems[] = [
                'name' => trim($match[2]),
                'type' => $this->getFoodTypeFromName($match[2]),
                'quantity' => $match[4],
                'unit' => $match[5],
                'calories' => $match[6],
                'nutrients' => [
                    'proteina' => ['calories' => $match[7]],
                    'carbohidratos' => ['calories' => $match[8]],
                    'grasa' => ['calories' => $match[9]],
                ],
            ];
        }

        return $foodItems;
    }

    private function getFoodTypeFromName($foodName)
    {
        // Función básica para determinar el tipo de alimento según su nombre
        $fruits = ['manzana', 'banana', 'naranja']; // Lista de frutas
        $vegetables = ['espinaca', 'zanahoria', 'brócoli']; // Lista de vegetales

        if (in_array(strtolower($foodName), $fruits)) {
            return 'fruta';
        } elseif (in_array(strtolower($foodName), $vegetables)) {
            return 'verdura';
        } else {
            return 'otros';
        }
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

    private function saveExercisesAndRoutines($userId, $userMuscles, $measurements)
    {
        $exerciseType = ExerciseType::where('nombre', 'Fuerza')->first();
        $muscles = Muscle::whereIn('id', $userMuscles)->get();

        $this->createExercisesForMuscles($muscles, $exerciseType, $measurements);

        [$routineName, $routineLevel, $routineObjective] = $this->analyzeRoutineData($this->recommendations, $measurements);
        $routine = $this->createRoutine($userId, $routineName, $routineLevel, $routineObjective);

        $this->assignExercisesToRoutine($routine, $userMuscles);
    }

    private function createExercisesForMuscles($muscles, $exerciseType, $measurements)
    {
        foreach ($muscles as $muscle) {
            $difficulty = $this->determineExerciseDifficulty($measurements);

            $exercise = Exercise::create([
                'nombre' => "Ejercicio para {$muscle->nombre}",
                'descripcion' => "Ejercicio diseñado para fortalecer el músculo {$muscle->nombre}",
                'dificultad' => $difficulty,
                'duracion_estimada' => rand(10, 30),
                'exercise_type_id' => $exerciseType->id,
                'estado' => 'activo',
            ]);

            ExerciseMuscle::create([
                'exercise_id' => $exercise->id,
                'muscle_id' => $muscle->id,
                'intensidad' => 'media',
            ]);
        }
    }

    private function createRoutine($userId, $routineName, $routineLevel, $routineObjective)
    {
        return Routine::create([
            'nombre' => $routineName,
            'descripcion' => "Rutina adaptada a los objetivos del usuario.",
            'nivel' => $routineLevel,
            'duracion_estimada' => 60,
            'objetivo' => $routineObjective,
            'frecuencia_semanal' => 3,
            'estado' => 'activo',
        ]);
    }

    private function assignExercisesToRoutine($routine, $userMuscles)
    {
        $exercises = Exercise::whereIn('id', function ($query) use ($userMuscles) {
            $query->select('exercise_id')
                ->from('exercise_muscle')
                ->whereIn('muscle_id', $userMuscles);
        })->get();

        foreach ($exercises as $exercise) {
            RoutineExercise::create([
                'routine_id' => $routine->id,
                'exercise_id' => $exercise->id,
            ]);
        }
    }

    private function analyzeRoutineData($recommendations, $measurements)
    {
        $routineName = "Rutina Personalizada";
        $routineLevel = "principiante";
        $routineObjective = $this->determineRoutineObjective($measurements);

        if (preg_match('/Nombre de la rutina:\s*(.+)/i', $recommendations, $matches)) {
            $routineName = trim($matches[1]);
        }

        if (preg_match('/Nivel:\s*(.+)/i', $recommendations, $matches)) {
            $routineLevel = trim($matches[1]);
        }

        return [$routineName, $routineLevel, $routineObjective];
    }

    private function determineRoutineObjective($measurements)
    {
        if ($measurements->peso < 70) {
            return 'perder peso';
        } elseif ($measurements->peso > 90) {
            return 'ganar músculo';
        }

        return 'mantener';
    }

    private function determineExerciseDifficulty($measurements)
    {
        if ($measurements->peso < 70) {
            return 'fácil';
        } elseif ($measurements->peso > 90) {
            return 'difícil';
        }

        return 'medio';
    }

    private function generatePrompt($measurements, $medicalDetails, $answer)
    {
        $name = auth()->user()->name;
        $peso = $measurements->peso ?? 'no especificado';
        $talla = $measurements->talla ?? 'no especificado';
        $imc = $measurements->imc ?? 'no calculado';
        $enfermedad_base = $medicalDetails->enfermedad_base ?? 'ninguna';
        $alergias = $medicalDetails->alergia_alimento ?? 'ninguna';
        $musculos_entrenar = auth()->user()->muscles->pluck('nombre')->join(', ') ?? 'no especificado';
        // Verificar si $answer es un array o un objeto
        $userAnswers = null;
        if (is_array($answer)) {
            // Si es un array, acceder a la clave respuesta_json
            $userAnswers = json_decode($answer['respuesta_json'] ?? '[]', true);
        } elseif (is_object($answer) && isset($answer->respuesta_json)) {
            // Si es un objeto, acceder a la propiedad respuesta_json
            $userAnswers = json_decode($answer->respuesta_json, true);
        }

        // Si no hay respuestas, asignar un array vacío
        $userAnswers = $userAnswers ?? [];

        $prompt = <<<EOD
        Por favor, asegúrate de iniciar tu respuesta con un saludo personalizado dirigido al usuario, como "Hola {$name}, soy tu guía nutricionista virtual".
        Tambien no te olvides de rellenar la base de datos en las tablas de nutrients, diets_aliments, aliments, food_types, nutritionals_details y nutrients.
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

        foreach ($userAnswers as $question => $response) {
            $responseText = is_array($response) ? implode(', ', $response) : $response;
            $prompt .= "\n- **{$question}:** {$responseText}";
        }

        $prompt .= <<<EOD
    
        Ahora, genera un plan personalizado que incluya:
        1. Menciones sobre su peso y talla del paciente.
        2. Menciones sobre sus alergias y enfermedades de base.
        3. Recomendaciones de ejercicios específicos basados en los músculos que desea entrenar, las condiciones médicas y las respuestas del formulario.
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
