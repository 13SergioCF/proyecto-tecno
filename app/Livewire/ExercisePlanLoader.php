<?php

namespace App\Livewire;

use App\Models\Answer;
use App\Models\Measurement;
use Livewire\Component;
use App\Models\Routine;
use App\Models\Exercise;
use App\Models\MedicalDetail;
use App\Models\Recommendation;
use App\Models\RoutineExercise;
use App\Models\User;
use Carbon\Carbon;
use OpenAI;

class ExercisePlanLoader extends Component
{
    public $isLoading = true;
    public $progress = 0;
    public $userId;
    public $age;
    public $gender;
    public $fitness_level = 'Intermedio';
    public $goal = 'Tonificar';
    public $days = 7;

    // Variables adicionales
    public $measurements;
    public $medicalDetails;
    public $answer;
    public $userMuscles;
    public $latestRecommendation;

    public function mount()
    {
        $this->userId = auth()->id();

        $user = User::find($this->userId);
        if (!$user) {
            throw new \Exception("Usuario no encontrado.");
        }

        $this->measurements = $this->getLatestMeasurement($this->userId);
        if (!$this->measurements) {
            throw new \Exception("No se encontraron mediciones recientes para el usuario.");
        }

        $this->medicalDetails = $this->getMedicalDetails($this->userId);
        if (!$this->medicalDetails) {
            throw new \Exception("No se encontraron detalles médicos para el usuario.");
        }

        $this->answer = $this->getLatestAnswer($this->userId);
        if (!$this->answer) {
            throw new \Exception("No se encontraron respuestas recientes para el usuario.");
        }

        $this->latestRecommendation = $this->getLatestRecommendation($this->userId);
        if (!$this->latestRecommendation) {
            throw new \Exception("No se encontraron recomendaciones recientes para el usuario.");
        }

        $this->userMuscles = $user->muscles()->pluck('muscles.id');
        if ($this->userMuscles->isEmpty()) {
            throw new \Exception("No se encontraron músculos seleccionados para el usuario.");
        }

        $this->age = $this->calculateAge($user->fecha_nacimiento);
        $this->gender = $user->genero;
        $this->fitness_level = $user->fitness_level ?? $this->fitness_level; // Asignar desde el usuario o mantener el predeterminado
        $this->goal = $user->goal ?? $this->goal;
    }

    public function generateExercisePlan()
    {
        $prompt = $this->buildPrompt();

        $client = OpenAI::client(env('OPENIA_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un experto en fitness y creación de rutinas de ejercicio.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 1500,
        ]);

        $responseContent = $response['choices'][0]['message']['content'] ?? null;

        if (!$responseContent) {
            throw new \Exception("No se recibió una respuesta válida de la IA.");
        }

        // Log para depuración
        \Log::info('Contenido bruto recibido de la IA: ' . $responseContent);

        // Limpiar contenido
        $responseContent = trim($responseContent);
        $responseContent = preg_replace('/^```json/', '', $responseContent); // Remover prefijo ```json
        $responseContent = preg_replace('/```$/', '', $responseContent);    // Remover sufijo ```
        $responseContent = trim($responseContent); // Asegurarse de que no haya espacios extras

        // Intentar decodificar el JSON
        $jsonContent = json_decode($responseContent, true);

        if (!$jsonContent) {
            throw new \Exception("La respuesta de la IA no contiene un JSON válido. Respuesta limpia: " . $responseContent);
        }

        $exerciseTypeMapping = [
            'fuerza' => 4,
            'cardio' => 5,
            'flexibilidad' => 6,
        ];

        // Guardar la rutina en la base de datos
        try {
            $routine = Routine::create([
                'nombre' => $jsonContent['nombre'],
                'descripcion' => $jsonContent['descripcion'],
                'nivel' => $this->fitness_level,
                'frecuencia_semanal' => $jsonContent['frecuencia_semanal'],
                'objetivo' => $this->goal,
                'duracion_estimada' => $this->days * 7,
            ]);

            foreach ($jsonContent['ejercicios'] as $exerciseData) {
                $exerciseType = strtolower($exerciseData['tipo']);
                $exerciseTypeId = $exerciseTypeMapping[$exerciseType] ?? null;

                if (!$exerciseTypeId) {
                    throw new \Exception("Tipo de ejercicio no válido: " . $exerciseData['tipo']);
                }

                $exercise = Exercise::firstOrCreate(
                    ['nombre' => $exerciseData['nombre']],
                    [
                        'descripcion' => $exerciseData['tipo'],
                        'duracion_estimada' => $exerciseData['duracion_estimada'],
                        'estado' => 'activo',
                        'exercise_type_id' => $exerciseTypeId,
                    ]
                );

                RoutineExercise::create([
                    'routine_id' => $routine->id,
                    'exercise_id' => $exercise->id,
                ]);
            }
        } catch (\Exception $e) {
            throw new \Exception("Error al guardar la rutina o ejercicios: " . $e->getMessage());
        }

        $this->isLoading = false;
    }

    private function buildPrompt()
    {
        return "
        Basado en los siguientes datos de un usuario, genera un plan de ejercicios personalizado. La salida debe estar estrictamente en formato JSON válido y debe seguir esta estructura exacta:
        {
            \"nombre\": \"Nombre de la rutina\",
            \"descripcion\": \"Descripción de la rutina\",
            \"frecuencia_semanal\": \"Número de días por semana\",
            \"ejercicios\": [
                {
                    \"nombre\": \"Nombre del ejercicio\",
                    \"tipo\": \"Tipo del ejercicio (fuerza, cardio, flexibilidad)\",
                    \"duracion_estimada\": \"Duración en minutos\"
                }
            ]
        }

        Datos del usuario:
        - Edad: {$this->age}
        - Género: {$this->gender}
        - Objetivo: {$this->goal}
        - Duración: {$this->days} días
        - Mediciones: " . json_encode($this->measurements) . "
        - Detalles médicos: " . json_encode($this->medicalDetails) . "
        - Respuestas recientes: " . json_encode($this->answer) . "
        - Músculos seleccionados: " . $this->userMuscles->implode(', ') . "
        ";
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

    private function getLatestRecommendation($userId)
    {
        return Recommendation::where('user_id', $userId)->latest()->first();
    }

    public function calculateAge($birthdate)
    {
        return Carbon::parse($birthdate)->age;
    }
    public function getWeeklyExercisePlan()
    {
        $weeklyPlan = [];
        $routines = Routine::with('exercises')->get();

        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        foreach ($days as $day) {
            $dailyExercises = $routines->map(function ($routine) {
                return $routine->exercises->map(function ($exercise) {
                    return "{$exercise->duracion_estimada} min: {$exercise->nombre}";
                })->toArray();
            })->flatten()->toArray();

            $weeklyPlan[$day] = !empty($dailyExercises) ? $dailyExercises : ["No hay datos de ejercicios para {$day}."];
        }

        return $weeklyPlan;
    }



    public function render()
    {
        return view('livewire.exercise-plan-loader');
    }
}
