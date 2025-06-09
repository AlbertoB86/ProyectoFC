<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluaciones;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EvaluacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        //Mostrar las evaluaciones del usuario logueado
        $evaluaciones = Evaluaciones::where('id_user', Auth::id())->orderBy('fecha', 'desc')->get();
        return view('evaluaciones.index', compact('user', 'evaluaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener la última evaluación del usuario logueado
        $ultimaEvaluacion = Evaluaciones::where('id_user', Auth::id())->orderBy('fecha', 'desc')->first();

        // Verificar si han pasado al menos 3 meses desde la última evaluación
        if ($ultimaEvaluacion){
            $fechaUltimaEvaluacion = strtotime($ultimaEvaluacion->fecha);
            $tresMesesDespues = strtotime('+3 months', $fechaUltimaEvaluacion);
            
            if (time() < $tresMesesDespues){
                return redirect()->route('evaluaciones.index')->with('error', 'Debe esperar al menos 3 meses para realizar una nueva evaluación.');
            }
        }
        //Mostrar el formulario para crear una nueva evaluación
        return view('evaluaciones.create');        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if(!$user instanceof \App\Models\User){
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para realizar esta acción.');
        }

        $nivel = $this->calcularNivel($request);

        Evaluaciones::create([
            'id_user' => Auth::id(),
            'fecha' => now(),
            'nivel' => $nivel,
            'peso' => $request->peso,
            'altura' => $request->altura,
            'dominadas_fallo' => $request->dominadas_fallo,
            'flexiones_fallo' => $request->flexiones_fallo,
            'max_tiempo_regleta_40mm' => $request->max_tiempo_regleta_40mm,
            'minima_regleta_10seg' => $request->minima_regleta_10seg,
            'bloque_max' => $request->bloque_max,
        ]);

        // Reiniciar planes_completados después de una nueva evaluación
        $user->planes_completados = 0;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Evaluación creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function calcularNivel($request){
        $dominadas = $request->dominadas_fallo;
        $flexiones = $request->flexiones_fallo;
        $tiempo_regleta_40mm = $request->max_tiempo_regleta_40mm;
        $minima_regleta_10seg = $request->minima_regleta_10seg;
        $bloque_max = $request->bloque_max;    

        $puntos = 0;

        // Condiciones físicas
        if ($dominadas >= 20){
            $puntos++;
        }            
        if ($flexiones >= 30){
            $puntos++;
        }
        if ($tiempo_regleta_40mm >= 30){
            $puntos++;
        }

        // Fuerza de dedos (cuanto más pequeña la regleta, mejor)
        if ($minima_regleta_10seg <= 10){
            $puntos += 2;
        } elseif ($minima_regleta_10seg <= 15){
            $puntos += 1;
        }

        // Nivel técnico (bloque máximo)
        // Puntuacion nivel grado de bloque
        $niveles = [
            '3' => 0,
            '4' => 0,
            '5a' => 1,
            '5b' => 1,
            '6a' => 2,
            '6b' => 2,
            '6c' => 3,
            '7a' => 4,
            '7b' => 4,
            '7c' => 4,
            '8a' => 4,
        ];

        $puntosBloque = $niveles[$bloque_max] ?? 0;
        $puntos += $puntosBloque;

        // Resultado
        if ($puntos >= 8){
            return 'Avanzado';
        }elseif ($puntos >= 5){
            return 'Intermedio';
        }else{
            return 'Iniciación';
        }
    }
}
