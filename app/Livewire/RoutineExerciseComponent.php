<?php

namespace App\Livewire;

use App\Models\{
    Routine,
    Exercise,
    ExerciseType,
    RoutineExercise,
    Recommendation,
    User,
    Measurement,
    MedicalDetail,
    Answer
};
use Carbon\Carbon;
use Livewire\Component;

class RoutineExerciseComponent extends Component
{
    public $data;

    public function render()
    {
        return view('livewire.routine-exercise-component');
    }

    public function generateRoutineExerciseForUser()
    {
        try {
            // Obtener usuario autenticado
            $userId = auth()->id();
            $user = User::find($userId);

            if (!$user) {
                throw new \Exception("Usuario no encontrado.");
            }

            // Obtener datos relacionados al usuario
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

            // Obtener recomendación más reciente
            $recommendation = Recommendation::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$recommendation || empty($recommendation->content)) {
                throw new \Exception("No se encontró contenido en la recomendación más reciente.");
            }

            // Generar datos de rutina a partir del contenido de la recomendación
            $routineData = $this->generateRoutineDataFromContent($recommendation->content, $measurements, $medicalDetails, $answer, $userMuscles, $age, $gender);

            // Guardar rutina en la base de datos
            $routine = Routine::create($routineData);

            // Guardar ejercicios asociados a la rutina
            foreach ($routineData['exercises'] as $exerciseData) {
                $exerciseType = ExerciseType::firstOrCreate([
                    'nombre' => $exerciseData['exercise_type']['type_name']
                ], [
                    'descripcion' => $exerciseData['exercise_type']['description'],
                    'estado' => 'activo',
                ]);

                $exercise = Exercise::create([
                    'nombre' => $exerciseData['exercise_name'],
                    'descripcion' => $exerciseData['description'],
                    'dificultad' => $exerciseData['difficulty'],
                    'duracion_estimada' => $exerciseData['estimated_duration'],
                    'imagen_url' => $exerciseData['image_url'],
                    'video_url' => $exerciseData['video_url'],
                    'estado' => 'activo',
                    'exercise_type_id' => $exerciseType->id,
                ]);

                RoutineExercise::create([
                    'routine_id' => $routine->id,
                    'exercise_id' => $exercise->id,
                ]);
            }

            // Generar JSON de todos los datos
            $this->data = json_encode($routineData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            return response()->json([
                'status' => 'success',
                'message' => 'Rutina y ejercicios generados exitosamente.',
                'data' => $this->data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function generateRoutineDataFromContent($content, $measurements, $medicalDetails, $answer, $userMuscles, $age, $gender)
    {
        // Generar el prompt basado en el contenido
        $prompt = $this->generatePrompt($content, $measurements, $medicalDetails, $answer, $userMuscles, $age, $gender);

        // Aquí deberías integrar la llamada a la API de IA para procesar el prompt y generar datos
        // Simulación de respuesta de la IA basada en el prompt
        $parsedContent = $this->parseContentToExercises($content);

        return [
            'nombre' => "Rutina personalizada según recomendaciones",
            'descripcion' => "Rutina generada a partir de las recomendaciones y los datos del usuario.",
            'nivel' => 'Intermedio',
            'objetivo' => 'Fortalecer músculos seleccionados',
            'duracion_estimada' => 60,
            'frecuencia_semanal' => 3,
            'estado' => 'activo',
            'exercises' => $parsedContent,
        ];
    }

    private function parseContentToExercises($content)
    {
        $lines = explode("\n", $content);
        $exercises = [];

        foreach ($lines as $line) {
            if (stripos($line, 'ejercicio') !== false) {
                $exercises[] = [
                    'exercise_name' => 'Ejercicio generado',
                    'description' => $line,
                    'difficulty' => 'media',
                    'estimated_duration' => 15,
                    'image_url' => 'default.png',
                    'video_url' => 'default.mp4',
                    'exercise_type' => [
                        'type_name' => 'General',
                        'description' => 'Ejercicio generado automáticamente.',
                    ],
                ];
            }
        }

        return $exercises;
    }

    private function generatePrompt($content, $measurements, $medicalDetails, $answer, $userMuscles, $age, $gender)
    {
        return <<<EOD
        Genera una rutina personalizada basada en los siguientes datos:

        ### Información del Usuario:
        - Edad: {$age}
        - Género: {$gender}
        - Mediciones: Peso: {$measurements->peso}, Talla: {$measurements->talla}, IMC: {$measurements->imc}
        - Detalles médicos: Enfermedad Base: {$medicalDetails->enfermedad_base}, Alergias: {$medicalDetails->alergia_alimento}
        - Músculos a entrenar: {$userMuscles->join(', ')}

        ### Contenido de Recomendación:
        {$content}

        Genera:
        1. Una rutina única con un nombre descriptivo.
        2. Una lista de ejercicios, incluyendo nombre, descripción, dificultad, duración estimada, imágenes y tipo de ejercicio.
        3. Clasifica los ejercicios en tipos claros.
        4. Responde con un JSON estructurado con los datos completos.
        EOD;
    }

    private function calculateAge($dateOfBirth)
    {
        if (!$dateOfBirth) {
            throw new \Exception("La fecha de nacimiento no está disponible.");
        }

        return Carbon::parse($dateOfBirth)->age;
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
}
