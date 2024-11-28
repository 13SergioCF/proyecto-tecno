<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foodTypes = [
            ['nombre' => 'Frutas', 'descripcion' => 'Alimentos de origen vegetal, comestibles y ricos en vitaminas y minerales.'],
            ['nombre' => 'Verduras', 'descripcion' => 'Plantas comestibles que generalmente se consumen cocidas o crudas, ricas en fibra y nutrientes.'],
            ['nombre' => 'Cereales y granos', 'descripcion' => 'Semillas de plantas cultivadas, como el trigo, maíz, arroz y avena, ricos en carbohidratos.'],
            ['nombre' => 'Legumbres', 'descripcion' => 'Frutos comestibles de plantas como frijoles, lentejas, garbanzos, que son fuentes de proteínas vegetales.'],
            ['nombre' => 'Tubérculos', 'descripcion' => 'Raíces o tallos subterráneos comestibles, como papas, batatas, ricos en carbohidratos.'],
            ['nombre' => 'Lácteos', 'descripcion' => 'Productos derivados de la leche, como queso, yogurt, que son fuente de calcio y proteínas.'],
            ['nombre' => 'Carnes', 'descripcion' => 'Tejidos musculares comestibles de animales, como res, cerdo, pollo, ricos en proteínas y grasas.'],
            ['nombre' => 'Pescados y mariscos', 'descripcion' => 'Alimentos provenientes del mar, como peces, camarones, ricos en proteínas y ácidos grasos omega-3.'],
            ['nombre' => 'Huevos', 'descripcion' => 'Producto alimenticio de aves, generalmente de gallina, rico en proteínas y nutrientes esenciales.'],
            ['nombre' => 'Frutos secos y semillas', 'descripcion' => 'Frutos comestibles y semillas que se destacan por su alto contenido de grasas saludables y proteínas.'],
            ['nombre' => 'Aceites y grasas', 'descripcion' => 'Líquidos grasos o sólidos derivados de plantas o animales, utilizados para cocinar o como ingredientes.'],
            ['nombre' => 'Dulces y postres', 'descripcion' => 'Alimentos ricos en azúcar y otros ingredientes como chocolate, pasteles, galletas, generalmente altos en calorías.'],
            ['nombre' => 'Bebidas', 'descripcion' => 'Líquidos consumidos, como agua, jugos, refrescos, té y café, que hidratan o complementan la alimentación.'],
            ['nombre' => 'Especias y condimentos', 'descripcion' => 'Sustancias que se utilizan para dar sabor o mejorar el aroma de los alimentos, como sal, pimienta, ajo, orégano.'],
            ['nombre' => 'Alimentos procesados y en conserva', 'descripcion' => 'Alimentos que han sido modificados a través de procesos industriales para su conservación y facilidad de uso.'],
        ];

        foreach ($foodTypes as $type) {
            DB::table('food_types')->insert([
                'nombre' => $type['nombre'],
                'descripcion' => $type['descripcion'],
                'estado' => 'activo',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
