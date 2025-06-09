<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluaciones extends Model
{
    use HasFactory;
    protected $table = 'evaluaciones';
    protected $fillable = [
        'id_user',
        'fecha',
        'nivel',
        'peso',
        'altura',
        'dominadas_fallo',
        'flexiones_fallo',
        'max_tiempo_regleta_40mm',
        'minima_regleta_10seg',
        'bloque_max',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
