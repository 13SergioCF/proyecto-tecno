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
            ['nombre' => 'Pectorales', 'descripcion' => 'Músculos del pecho', 'estado' => 'activo', 'image_path' => 'img/muscles/pectorales.gif'],
            ['nombre' => 'Dorsales', 'descripcion' => 'Músculos de la espalda', 'estado' => 'activo', 'image_path' => 'img/muscles/dorsales.jpg'],
            ['nombre' => 'Trapecios', 'descripcion' => 'Músculos entre el cuello y la espalda', 'estado' => 'activo', 'image_path' => 'img/muscles/trapecios.png'],
            ['nombre' => 'Deltoides', 'descripcion' => 'Músculos de los hombros', 'estado' => 'activo', 'image_path' => 'img/muscles/deltoides.jpg'],
            ['nombre' => 'Bíceps', 'descripcion' => 'Músculos frontales del brazo', 'estado' => 'activo', 'image_path' => 'img/muscles/biceps.png'],
            ['nombre' => 'Tríceps', 'descripcion' => 'Músculos posteriores del brazo', 'estado' => 'activo', 'image_path' => 'img/muscles/triceps.png'],
            ['nombre' => 'Abdominales', 'descripcion' => 'Músculos del abdomen', 'estado' => 'activo', 'image_path' => 'img/muscles/abdominales.gif'],
            ['nombre' => 'Cuádriceps', 'descripcion' => 'Músculos frontales del muslo', 'estado' => 'activo', 'image_path' => 'img/muscles/cuadriceps.gif'],
            ['nombre' => 'Glúteos', 'descripcion' => 'Músculos de los glúteos', 'estado' => 'activo', 'image_path' => 'img/muscles/gluteos.jpg'],
            ['nombre' => 'Isquiotibiales', 'descripcion' => 'Músculos posteriores del muslo', 'estado' => 'activo', 'image_path' => 'img/muscles/isquiotibiales.gif'],
            ['nombre' => 'Pantorrillas', 'descripcion' => 'Músculos de la parte inferior de la pierna', 'estado' => 'activo', 'image_path' => 'img/muscles/pantorrillas.png'],
        ];
        DB::table('muscles')->insert($muscles);
    }
}
