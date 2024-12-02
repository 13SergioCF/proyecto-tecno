<?php

namespace App\Livewire;

use App\Models\Measurement;
use App\Models\Nutrient;
use App\Models\Aliment;
use App\Models\Answer;
use App\Models\FoodType;
use App\Models\Diet;
use App\Models\MedicalDetail;
use App\Models\NutritionalsDetail;
use App\Models\Recommendation;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use OpenAI;

class NutritionalPlanLoader extends Component
{
    public $isLoading = true;
    public $progress = 0;
    public $userId;
    public $age;
    public $gender;
    public $days = 7; // Duración predeterminada
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
    }

    public function generateNutritionalPlan()
    {
        $prompt = $this->buildPrompt();

        $client = OpenAI::client(env('OPENIA_API_KEY'));
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un experto en planes nutricionales y dietas.'],
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

        // Limpiar el contenido
        $responseContent = trim($responseContent);
        $responseContent = preg_replace('/^```json/', '', $responseContent);
        $responseContent = preg_replace('/```$/', '', $responseContent);
        $responseContent = trim($responseContent);

        // Decodificar el JSON
        $jsonContent = json_decode($responseContent, true);

        if (!$jsonContent) {
            throw new \Exception("La respuesta de la IA no contiene un JSON válido. Respuesta limpia: " . $responseContent);
        }

        try {
            // Crear tipos de alimentos, alimentos y nutrientes
            foreach ($jsonContent['alimentos'] as $alimentData) {
                $foodType = FoodType::firstOrCreate(
                    ['nombre' => $alimentData['food_type']['nombre']],
                    ['descripcion' => $alimentData['food_type']['descripcion'] ?? null, 'estado' => 'activo']
                );

                $aliment = Aliment::firstOrCreate(
                    ['nombre' => $alimentData['nombre']],
                    [
                        'descripcion' => $alimentData['descripcion'],
                        'estado' => 'activo',
                        'food_type_id' => $foodType->id,
                    ]
                );

                foreach ($alimentData['nutrientes'] as $nutrientData) {
                    $nutrient = Nutrient::firstOrCreate(
                        ['nombre' => $nutrientData['nombre']],
                        ['descripcion' => $nutrientData['descripcion'], 'estado' => 'activo']
                    );

                    NutritionalsDetail::firstOrCreate(
                        [
                            'id_alimento' => $aliment->id,
                            'id_nutriente' => $nutrient->id,
                        ],
                        [
                            'cantidad_calorias' => $this->extractCalories($nutrientData['cantidad_calorias']),
                        ]
                    );
                }
            }

            foreach ($jsonContent['diets'] as $dietData) {
                Diet::create([
                    'descripcion' => $dietData['descripcion'],
                    'tipo' => $dietData['tipo'],
                    'duration_in_days' => $this->days,
                ]);
            }
        } catch (\Exception $e) {
            throw new \Exception("Error al guardar el plan nutricional o los detalles: " . $e->getMessage());
        }

        $this->isLoading = false;
    }
    private function extractCalories($calorieString)
    {
        // Extraer solo el número de las calorías (por ejemplo: "206 kcal" -> 206)
        if (preg_match('/\d+(\.\d+)?/', $calorieString, $matches)) {
            return (float) $matches[0]; // Convertir el número encontrado a decimal
        }

        // Si no hay un número válido, lanzar una excepción
        throw new \Exception("Valor de calorías inválido: $calorieString");
    }


    private function buildPrompt()
    {
        return "
        Basado en los datos de alimentos, nutrientes y planes nutricionales, genera un plan nutricional personalizado en formato JSON. Sigue esta estructura estricta:
        {
            \"alimentos\": [
                {
                    \"nombre\": \"Nombre del alimento\",
                    \"descripcion\": \"Descripción del alimento\",
                    \"food_type\": {
                        \"nombre\": \"Nombre del tipo de alimento\",
                        \"descripcion\": \"Descripción del tipo de alimento\"
                    },
                    \"nutrientes\": [
                        {
                            \"nombre\": \"Nombre del nutriente\",
                            \"descripcion\": \"Descripción del nutriente\",
                            \"cantidad_calorias\": \"Cantidad en calorías (solo el número, sin unidades como kcal)\"
                        }
                    ]
                }
            ],
            \"diets\": [
                {
                    \"descripcion\": \"Descripción de la dieta\",
                    \"tipo\": \"Tipo de dieta\",
                    \"duration_in_days\": \"Duración de la dieta en días (solo el número)\"
                }
            ]
        }
        ";
    }

    public function render()
    {
        return view('livewire.nutritional-plan-loader');
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
}
