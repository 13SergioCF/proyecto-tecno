<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseMuscleSeeder extends Seeder
{
    public function run()
    {
        // Insertar tipos de ejercicios
        $exerciseTypes = [
            ['nombre' => 'Fuerza', 'descripcion' => 'Ejercicios diseñados para aumentar la fuerza muscular', 'estado' => 'activo'],
            ['nombre' => 'Cardio', 'descripcion' => 'Ejercicios para mejorar la resistencia cardiovascular', 'estado' => 'activo'],
            ['nombre' => 'Flexibilidad', 'descripcion' => 'Ejercicios para mejorar la amplitud de movimiento', 'estado' => 'activo'],
        ];
        DB::table('exercise_types')->insert($exerciseTypes);

        // Insertar músculos
        $muscles = [
            ['nombre' => 'Pectorales', 'descripcion' => 'Músculos del pecho', 'estado' => 'activo'],
            ['nombre' => 'Dorsales', 'descripcion' => 'Músculos de la espalda', 'estado' => 'activo'],
            ['nombre' => 'Trapecios', 'descripcion' => 'Músculos entre el cuello y la espalda', 'estado' => 'activo'],
            ['nombre' => 'Deltoides', 'descripcion' => 'Músculos de los hombros', 'estado' => 'activo'],
            ['nombre' => 'Bíceps', 'descripcion' => 'Músculos frontales del brazo', 'estado' => 'activo'],
            ['nombre' => 'Tríceps', 'descripcion' => 'Músculos posteriores del brazo', 'estado' => 'activo'],
            ['nombre' => 'Abdominales', 'descripcion' => 'Músculos del abdomen', 'estado' => 'activo'],
            ['nombre' => 'Cuádriceps', 'descripcion' => 'Músculos frontales del muslo', 'estado' => 'activo'],
            ['nombre' => 'Glúteos', 'descripcion' => 'Músculos de los glúteos', 'estado' => 'activo'],
            ['nombre' => 'Isquiotibiales', 'descripcion' => 'Músculos posteriores del muslo', 'estado' => 'activo'],
            ['nombre' => 'Pantorrillas', 'descripcion' => 'Músculos de la parte inferior de la pierna', 'estado' => 'activo'],
        ];
        DB::table('muscles')->insert($muscles);

        // Insertar ejercicios
        $exercises = [
            ['nombre' => 'Press de banca', 'descripcion' => 'Ejercicio de pecho con barra o mancuernas', 'dificultad' => 'medio', 'duracion_estimada' => 120, 'exercise_type_id' => 1, 'estado' => 'activo'],
            ['nombre' => 'Dominadas', 'descripcion' => 'Ejercicio de espalda y brazos', 'dificultad' => 'difícil', 'duracion_estimada' => 60, 'exercise_type_id' => 1, 'estado' => 'activo'],
            ['nombre' => 'Sentadilla', 'descripcion' => 'Ejercicio de piernas', 'dificultad' => 'medio', 'duracion_estimada' => 90, 'exercise_type_id' => 1, 'estado' => 'activo'],
            ['nombre' => 'Correr', 'descripcion' => 'Ejercicio cardiovascular al aire libre o en cinta', 'dificultad' => 'fácil', 'duracion_estimada' => 180, 'exercise_type_id' => 2, 'estado' => 'activo'],
            ['nombre' => 'Plancha abdominal', 'descripcion' => 'Ejercicio isométrico para abdomen', 'dificultad' => 'fácil', 'duracion_estimada' => 60, 'exercise_type_id' => 3, 'estado' => 'activo'],
        ];
        DB::table('exercises')->insert($exercises);

        // Relacionar ejercicios con músculos
        $exerciseMuscle = [
            // Press de banca
            ['exercise_id' => 1, 'muscle_id' => 1, 'intensidad' => 'alta'],
            ['exercise_id' => 1, 'muscle_id' => 6, 'intensidad' => 'media'],
            ['exercise_id' => 1, 'muscle_id' => 4, 'intensidad' => 'baja'],

            // Dominadas
            ['exercise_id' => 2, 'muscle_id' => 2, 'intensidad' => 'alta'],
            ['exercise_id' => 2, 'muscle_id' => 5, 'intensidad' => 'media'],

            // Sentadilla
            ['exercise_id' => 3, 'muscle_id' => 8, 'intensidad' => 'alta'],
            ['exercise_id' => 3, 'muscle_id' => 9, 'intensidad' => 'media'],
            ['exercise_id' => 3, 'muscle_id' => 11, 'intensidad' => 'baja'],

            // Correr
            ['exercise_id' => 4, 'muscle_id' => 7, 'intensidad' => 'media'],
            ['exercise_id' => 4, 'muscle_id' => 11, 'intensidad' => 'media'],

            // Plancha abdominal
            ['exercise_id' => 5, 'muscle_id' => 7, 'intensidad' => 'alta'],
            ['exercise_id' => 5, 'muscle_id' => 4, 'intensidad' => 'baja'],
        ];
        DB::table('exercise_muscle')->insert($exerciseMuscle);
    }
}
