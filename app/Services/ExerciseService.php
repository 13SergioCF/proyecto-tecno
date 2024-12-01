<?php

namespace App\Services;

use App\Models\Routine;
use App\Models\Exercise;
use App\Models\Muscle;

class ExerciseService
{
    /**
     * Guarda una rutina y sus ejercicios asociados.
     *
     * @param array $routineData
     * @return Routine
     * @throws \Exception
     */
    public function saveExercisesAndRoutines(array $routineData)
    {
        // Crear la rutina
        $routine = Routine::create([
            'nombre' => $routineData['name'],
            'descripcion' => $routineData['description'],
            'nivel' => $routineData['level'],
            'duracion_estimada' => $routineData['duration_estimated'],
            'objetivo' => $routineData['objective'],
            'frecuencia_semanal' => $routineData['weekly_frequency'],
            'estado' => $routineData['status'],
        ]);

        // Guardar ejercicios relacionados
        foreach ($routineData['exercises'] as $exerciseData) {
            $this->saveExercise($routine, $exerciseData);
        }

        return $routine;
    }

    /**
     * Guarda un ejercicio y sus músculos asociados.
     *
     * @param Routine $routine
     * @param array $exerciseData
     * @throws \Exception
     */
    private function saveExercise(Routine $routine, array $exerciseData)
    {
        // Crear el ejercicio
        $exercise = Exercise::create([
            'nombre' => $exerciseData['name'],
            'descripcion' => $exerciseData['description'],
            'dificultad' => $exerciseData['difficulty'],
            'duracion_estimada' => $exerciseData['duration_estimated'],
            'estado' => $exerciseData['status'],
        ]);

        // Guardar músculos relacionados
        foreach ($exerciseData['muscles'] as $muscleData) {
            $muscle = Muscle::firstOrCreate(['nombre' => $muscleData['name']]);
            $exercise->muscles()->attach($muscle->id, ['intensidad' => $muscleData['intensity']]);
        }

        // Asociar el ejercicio a la rutina
        $routine->exercises()->attach($exercise->id);
    }
}
