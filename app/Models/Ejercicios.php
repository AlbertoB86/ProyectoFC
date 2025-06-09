<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicios extends Model
{
    protected $table = 't4c_ejercicios';
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo', 
        'nivel',
        'series',
        'repeticiones',
        'duracion',
        'descanso',
        'modo_calculo',        
    ];   
}
