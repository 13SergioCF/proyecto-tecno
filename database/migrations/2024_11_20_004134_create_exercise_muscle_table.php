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
        Schema::create('exercise_muscle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('muscle_id')->constrained('muscles')->onDelete('cascade');
            $table->enum('intensidad', ['baja', 'media', 'alta'])->default('media');
            $table->timestamps();
            $table->softDeletes(); // Para manejo de eliminaciones lógicas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_muscle');
    }
};
