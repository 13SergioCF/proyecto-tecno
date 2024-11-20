<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('details_days_thunders', function (Blueprint $table) {
            $table->id(); // Clave primaria de la tabla intermedia
            // Definir las claves foráneas de las tablas intermedias
            $table->foreignId('id_day_thunder') // Clave foránea hacia la tabla 'days_thunders'
                  ->constrained('days_thunders')
                  ->onDelete('cascade');
            $table->foreignId('id_diet_aliment') // Clave foránea hacia la tabla 'diets_aliments'
                  ->constrained('diets_aliments')
                  ->onDelete('cascade');
            $table->timestamps(); // Campos 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_days_thunders');
    }
};
