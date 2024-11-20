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
        Schema::create('nutritionals_details', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('id_alimento') // Clave foránea hacia la tabla 'aliments'
                  ->constrained('aliments')
                  ->onDelete('cascade');
            $table->foreignId('id_nutriente') // Clave foránea hacia la tabla 'nutrients'
                  ->constrained('nutrients')
                  ->onDelete('cascade');
            $table->decimal('cantidad_calorias', 8, 2); // El atributo cantidad_calorias
            $table->timestamps(); // Los campos 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritionals_details');
    }
};
