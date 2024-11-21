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
        Schema::create('aliments', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo'); // Nuevo atributo estado
            $table->foreignId('food_type_id') // Llave foránea a food_types
                  ->constrained('food_types')
                  ->onDelete('cascade');
            $table->string('imagen_url')->nullable();  // Columna para almacenar la ruta de la imagen
            $table->string('video_url')->nullable();   // Columna para almacenar la ruta del video
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aliments');
    }
};
