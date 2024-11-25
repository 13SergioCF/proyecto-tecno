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
        Schema::create('user_muscles', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->unsignedBigInteger('user_id'); // Relación con usuarios
            $table->unsignedBigInteger('muscle_id'); // Relación con músculos
            $table->timestamps(); // Timestamps para created_at y updated_at
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('muscle_id')->references('id')->on('muscles')->onDelete('cascade');
            $table->unique(['user_id', 'muscle_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_muscles');
    }
};
