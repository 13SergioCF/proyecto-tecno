<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionTypes = [
            [
                'nombre' => 'Sobre dieta',
                'descripcion' => 'Preguntas relacionadas con hábitos alimenticios, planes nutricionales y recomendaciones dietéticas.',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Sobre ejercicios',
                'descripcion' => 'Preguntas relacionadas con rutinas, tipos de ejercicios y recomendaciones físicas.',
                'estado' => 'activo',
            ],
        ];

        DB::table('question_types')->insert($questionTypes);
    }
}
