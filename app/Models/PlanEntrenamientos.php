<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanEntrenamientos extends Model
{
    protected $table = 'plan_entrenamientos';

    protected $fillable = [
        'user_id',
        'nivel',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'ciclo_inicio',
        'dia_actual',
        'iniciado',
        'completado',
        'dias_completados',
        'planes_completados',
    ];

    protected $casts = [
        'dias_completados' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ejercicios()
    {
        return $this->hasMany(PlanEjercicios::class, 'plan_id');
    }
}
