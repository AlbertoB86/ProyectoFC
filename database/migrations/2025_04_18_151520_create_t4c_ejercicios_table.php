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
        Schema::create('t4c_ejercicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('tipo'); // Calentamiento, Fuerza, etc.
            $table->string('nivel'); // Básico, Intermedio, Avanzado
            $table->integer('series')->nullable();
            $table->integer('repeticiones')->nullable();
            $table->integer('duracion')->nullable(); // En segundos
            $table->integer('descanso')->nullable(); // En segundos
            $table->string('modo_calculo')->nullable(); // 'estatico', 'dominadas', 'suspensiones'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t4c_ejercicios');
    }
};
