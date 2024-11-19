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
        Schema::create('diets_aliments', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('id_dieta') // Clave foránea hacia la tabla 'diets'
                  ->constrained('diets')
                  ->onDelete('cascade');
            $table->foreignId('id_alimento') // Clave foránea hacia la tabla 'aliments'
                  ->constrained('aliments')
                  ->onDelete('cascade');
            $table->timestamps(); // Campos 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets_aliments');
    }
};
