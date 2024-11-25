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
            $table->id();
            $table->unsignedBigInteger('id_dia');
            $table->unsignedBigInteger('id_turno');
            $table->timestamps();
            $table->foreign('id_dia')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('id_turno')->references('id')->on('thunders')->onDelete('cascade');
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
