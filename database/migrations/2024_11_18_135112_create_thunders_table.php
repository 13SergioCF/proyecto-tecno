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
        Schema::create('thunders', function (Blueprint $table) {
            $table->id('id_turno'); // La clave primaria 'id_turno'
            $table->string('nombre'); // El campo 'nombre'
            $table->timestamps(); // Los campos 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thunders');
    }
};
