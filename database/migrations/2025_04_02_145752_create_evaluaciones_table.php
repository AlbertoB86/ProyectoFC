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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->date('fecha');
            $table->string('nivel');
            $table->float('peso');
            $table->float('altura');
            $table->integer('dominadas_fallo');
            $table->integer('flexiones_fallo');
            $table->integer('max_tiempo_regleta_40mm');
            $table->integer('minima_regleta_10seg');
            $table->string('bloque_max');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
