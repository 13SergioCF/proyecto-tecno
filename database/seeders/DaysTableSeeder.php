<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            ['name' => 'Lunes', 'diet_id' => 1],
            ['name' => 'Martes', 'diet_id' => 1],
            ['name' => 'Miércoles', 'diet_id' => 1],
            ['name' => 'Jueves', 'diet_id' => 1],
            ['name' => 'Viernes', 'diet_id' => 1],
            ['name' => 'Sábado', 'diet_id' => 1],
            ['name' => 'Domingo', 'diet_id' => 1],
        ];

        $now = Carbon::now();
        foreach ($days as &$day) {
            $day['created_at'] = $now;
            $day['updated_at'] = $now;
        }

        DB::table('days')->insert($days);
    }
}
