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
        Schema::create('plan_ejercicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('ejercicio_id');
            $table->integer('dia'); // Día del plan al que pertenece el ejercicio
            $table->boolean('completado')->default(false); // Estado del ejercicio
            $table->timestamps();
            $table->foreign('plan_id')->references('id')->on('plan_entrenamientos')->onDelete('cascade');
            $table->foreign('ejercicio_id')->references('id')->on('t4c_ejercicios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_ejercicios');
    }
};
