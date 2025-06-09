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
        Schema::create('plan_entrenamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('nivel');
            $table->string('nombre'); 
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio')->nullable(); // Fecha en la que se activa o comienza a usar este plan
            $table->date('fecha_fin')->nullable(); // Fecha en la que finaliza este plan (opcional)
            $table->date('ciclo_inicio')->nullable(); // Fecha de inicio del ciclo de entrenamiento (para el mesociclo)
            $table->integer('dia_actual')->default(1); // Día actual del plan de entrenamiento
            $table->boolean('iniciado')->default(false); // Indica si el plan ha comenzado
            $table->boolean('completado')->default(false); // Indica si el plan ha sido completado
            $table->json('dias_completados')->nullable(); // Array de días completados
            $table->integer('planes_completados')->default(0); // Número de planes completados        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_entrenamientos');
    }
};
