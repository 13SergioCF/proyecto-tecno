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
        Schema::create('recommendation_json', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recommendation_id');
            $table->json('content_json');
            $table->timestamps();
            $table->foreign('recommendation_id')->references('id')->on('recommendation')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation_json');
    }
};
