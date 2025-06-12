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
        Schema::create('horarios_centros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('centro_id')->constrained('centros')->onDelete('cascade');
            $table->enum('dia_semana', ['lunes','martes','miercoles','jueves','viernes','sabado','domingo']);
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->unsignedTinyInteger('aforo')->default(1); // personas por bloque
            $table->unsignedTinyInteger('duracion_bloque')->default(60); // en minutos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_centros');
    }
};
