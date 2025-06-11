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
        Schema::create('rocodromos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->unique();
            $table->string('direccion')->nullable();        
            $table->string('ciudad')->nullable();
            $table->string('provincia')->nullable();
            $table->string('pais')->nullable();    
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('horario')->nullable();
            $table->string('telefono')->nullable();            
            $table->string('web')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rocodromos');
    }
};
