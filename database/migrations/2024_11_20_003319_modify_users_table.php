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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['peso', 'talla', 'imc']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('talla', 3, 2)->nullable();
            $table->decimal('imc', 5, 2)->nullable()->comment('Indice de Masa Corporal calculado a partir del peso y la talla');
        });
    }
};
