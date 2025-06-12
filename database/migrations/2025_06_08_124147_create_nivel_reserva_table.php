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
        Schema::create('nivel_reserva', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_sangre', ['O+','O-','A+','A-','B+','B-','AB+','AB-'])->unique();
            $table->integer('cantidad')->default(0);
            $table->enum('nivel', ['bajo', 'medio', 'alto'])->default('bajo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nivel_reserva');
    }
};
