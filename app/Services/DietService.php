<?php

namespace App\Services;

use App\Models\Diet;
use App\Models\Period;
use App\Models\FoodType;
use App\Models\Aliment;
use App\Models\NutritionalsDetail;
use App\Models\Nutrient;

class DietService
{
    /**
     * Guarda una dieta y sus alimentos asociados.
     *
     * @param array $dietData
     * @return Diet
     * @throws \Exception
     */
    public function saveDiet(array $dietData)
    {
        // Crear el período de la dieta
        $period = Period::create([
            'fecha_inicio' => $dietData['period']['start_date'],
            'fecha_final' => $dietData['period']['end_date'],
            'estado' => $dietData['period']['status'],
        ]);

        // Crear la dieta
        $diet = Diet::create([
            'descripcion' => $dietData['description'],
            'tipo' => $dietData['type'],
            'id_periodo' => $period->id,
        ]);

        // Guardar alimentos relacionados
        foreach ($dietData['aliments'] as $alimentData) {
            $this->saveAliment($diet, $alimentData);
        }

        return $diet;
    }

    /**
     * Guarda un alimento y sus nutrientes relacionados.
     *
     * @param Diet $diet
     * @param array $alimentData
     * @throws \Exception
     */
    private function saveAliment(Diet $diet, array $alimentData)
    {
        // Buscar o crear el tipo de alimento
        $foodType = FoodType::firstOrCreate(['nombre' => $alimentData['food_type']]);

        // Crear el alimento
        $aliment = Aliment::create([
            'nombre' => $alimentData['name'],
            'descripcion' => $alimentData['description'],
            'estado' => $alimentData['status'],
            'food_type_id' => $foodType->id,
        ]);

        // Guardar nutrientes relacionados
        foreach ($alimentData['nutrients'] as $nutrientData) {
            $this->saveNutrientDetails($aliment, $nutrientData);
        }

        // Asociar el alimento a la dieta
        $diet->aliments()->attach($aliment->id);
    }

    /**
     * Guarda los detalles nutricionales de un alimento.
     *
     * @param Aliment $aliment
     * @param array $nutrientData
     * @throws \Exception
     */
    private function saveNutrientDetails(Aliment $aliment, array $nutrientData)
    {
        // Buscar o crear el nutriente
        $nutrient = Nutrient::firstOrCreate(['nombre' => $nutrientData['name']]);

        // Crear el detalle nutricional
        NutritionalsDetail::create([
            'id_alimento' => $aliment->id,
            'id_nutriente' => $nutrient->id,
            'cantidad_calorias' => $nutrientData['calories'],
        ]);
    }
}
