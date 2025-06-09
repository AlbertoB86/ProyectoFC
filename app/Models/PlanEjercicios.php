<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanEjercicios extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'ejercicio_id', 'dia', 'completado'];

    public function plan(){
        return $this->belongsTo(PlanEntrenamientos::class, 'plan_id');
    }

    public function ejercicio(){
        return $this->belongsTo(Ejercicios::class, 'ejercicio_id');
    }
}
