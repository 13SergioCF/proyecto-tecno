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
        Schema::create('days_thunders', function (Blueprint $table) {
             // Claves foráneas que también actúan como claves primarias
             $table->unsignedBigInteger('id_dia');
             $table->unsignedBigInteger('id_turno');
             $table->timestamps();
 
             // Clave primaria compuesta
             $table->primary(['id_dia', 'id_turno']);
 
             // Relación con la tabla 'days'
             $table->foreign('id_dia')->references('id_dia')->on('days')->onDelete('cascade');
 
             // Relación con la tabla 'thunders'
             $table->foreign('id_turno')->references('id_turno')->on('thunders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('days_thunders');
    }
};
