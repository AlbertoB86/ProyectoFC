<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicios;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Evaluaciones;
use Illuminate\Support\Facades\Session;
use App\Models\PlanEntrenamientos;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PlanEntrenamientosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Obtener todos los planes de entrenamiento del usuario
        $planesEntrenamiento = PlanEntrenamientos::where('user_id', $user->id)->get();

        return view('planesEntrenamiento.index', compact('planesEntrenamiento', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function generarPlan()
    {
        $user = Auth::user();    
        
        if($user->planes_completados >= 2){
            return redirect()->route('evaluaciones.create')->with('error', 'Debes realizar una evaluación antes de generar un nuevo plan de entrenamiento.');
        }

        // Verificar si ya tiene un plan activo
        $planExistente = PlanEntrenamientos::where('user_id', $user->id)->where('iniciado', true)->first();
        if ($planExistente) {
            return redirect()->back()->with('error', 'Ya tienes un plan de entrenamiento activo.');
        }        

        $plan = PlanEntrenamientos::create([
            'user_id' => $user->id,
            'nivel' => $user->evaluaciones->last()->nivel ?? 'Iniciación',
            'nombre' => 'Plan de Entrenamiento de: ' . $user->name . ' ' . $user->primer_apellido,
            'descripcion' => 'Nivel: ' . $user->evaluaciones->last()->nivel,
            'dia_actual' => 1,
            'iniciado' => true,
            'completado' => false,
            'fecha_inicio' => now(),
        ]);   

        // Generar ejercicios para cada día del plan
        for ($dia = 1; $dia <= 12; $dia++){
            $tipoEntrenamiento = $this->determinarTipoEntrenamiento($dia);

            // Calentamientos 
            // El primer ejercicio sera siempre el mismo para todos los dias y planes          
            $plan->ejercicios()->create([
                'ejercicio_id' => 1,
                'dia' => $dia,
                'completado' => false,
            ]); 
            $calentamientos = Ejercicios::where('tipo', 'Calentamiento')->where('id', '!=', 1)->inRandomOrder()->take(3)->get();
            foreach ($calentamientos as $ejercicio){
                $plan->ejercicios()->create([
                    'ejercicio_id' => $ejercicio->id,
                    'dia' => $dia,
                    'completado' => false,
                ]);
            }

            // Ejercicios principales
            if($tipoEntrenamiento === 'Descarga'){
                //Seleccionamos ejercicios de tipo Core y Tecnica
                $ejerciciosCore = Ejercicios::where('tipo', 'Core')->where('nivel', $plan->nivel)->inRandomOrder()->take(2)->get();
                $ejerciciosTecnica = Ejercicios::where('tipo', 'Técnica')->where('nivel', $plan->nivel)->inRandomOrder()->take(2)->get();
                $ejercicios = $ejerciciosCore->merge($ejerciciosTecnica);    
            }else{
                // Seleccionamos ejercicios de tipo Fuerza o REsistencia
                $ejercicios = Ejercicios::where('tipo', $tipoEntrenamiento)
                ->where('nivel', $plan->nivel)
                ->inRandomOrder()
                ->take(4)
                ->get();
            }
            
            foreach ($ejercicios as $ejercicio){
                $plan->ejercicios()->create([
                    'ejercicio_id' => $ejercicio->id,
                    'dia' => $dia,
                    'completado' => false,
                ]);
            }

            // Estiramientos
            $estiramientos = Ejercicios::where('tipo', 'Estiramiento')->inRandomOrder()->take(3)->get();
            foreach ($estiramientos as $ejercicio){
                $plan->ejercicios()->create([
                    'ejercicio_id' => $ejercicio->id,
                    'dia' => $dia,
                    'completado' => false,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Plan de entrenamiento generado correctamente.');
    }

    public function mostrarPlan(Request $request, $dia)
    {
        $user = Auth::user();

        // Obtener el plan de entrenamiento del usuario
        $planEntrenamiento = PlanEntrenamientos::where('user_id', Auth::id())->where('iniciado', true)->first();               

        //------------------------Obtener datos para las graficas -------------------------------------
        $evaluaciones = Evaluaciones::where('id_user', $user->id)
        ->orderBy('fecha', 'desc')
        ->get();
        
        $fechasEvaluaciones = $evaluaciones->pluck('fecha')->map(function ($fecha){
            return \Carbon\Carbon::parse($fecha)->format('d/m/Y');
        })->toArray();
        // Obtener los niveles de bloque_max
        $nivelesBloqueMax = ['3', '4', '5a', '5b', '6a', '6b', '6c', '7a', '7b', '7c', '8a'];
        // Obtener los valores de bloque_max de las evaluaciones
        $dataValues = $evaluaciones->map(function ($evaluacion) use ($nivelesBloqueMax){
            return array_search($evaluacion->bloque_max, $nivelesBloqueMax);
        })->toArray();
        
        $dominadas = $evaluaciones->pluck('dominadas_fallo')->toArray();
        $flexiones = $evaluaciones->pluck('flexiones_fallo')->toArray();
        $minimaRegleta = $evaluaciones->pluck('minima_regleta_10seg')->toArray();
        //------------------------------------------------------------------------------------------

        //Verificar si el usuario tiene un plan de entrenamiento activo
        if (!$planEntrenamiento || !$planEntrenamiento->iniciado){
            return view('dashboard', [
                'planEntrenamiento' => $planEntrenamiento,
                'dia' => $request->input('dia', 1),
                'evaluaciones' => $user->evaluaciones, 
                'nivel' => null,
                'tipoEntrenamiento' => null,
                'ejercicios' => [],
                'calentamientos' => [],
                'estiramientos' => [],
                'progreso' => 0,
                'fechasEvaluaciones' => $fechasEvaluaciones,
                'bloques' => $dataValues,
                'dominadas' => $dominadas,
                'flexiones' => $flexiones,
                'minimaRegleta' => $minimaRegleta,
            ])->with('error', 'No has iniciado ningún plan de entrenamiento.');
        }

        $diasCompletados = count($planEntrenamiento->dias_completados ?? []);   // Contar los días completados
        $progreso = ($diasCompletados / 12) * 100;

        $nivel = $planEntrenamiento->nivel;

        // Recuperar los ejercicios guardados para el día actual
        $ejerciciosDia = $planEntrenamiento->ejercicios()->where('dia', $dia)->with('ejercicio')->get();

        // Separar los ejercicios por tipo
        $calentamientos = $ejerciciosDia->filter(fn($e) => $e->ejercicio->tipo === 'Calentamiento');
        $estiramientos = $ejerciciosDia->filter(fn($e) => $e->ejercicio->tipo === 'Estiramiento');
        $ejercicios = $ejerciciosDia->filter(fn($e) => $e->ejercicio->tipo !== 'Calentamiento' && $e->ejercicio->tipo !== 'Estiramiento');

        $tipoEntrenamiento = $this->determinarTipoEntrenamiento($dia);

        return view('dashboard', [
            'ejercicios' => $ejercicios,
            'calentamientos' => $calentamientos,
            'estiramientos' => $estiramientos,
            'planEntrenamiento' => $planEntrenamiento,
            'dia' => $dia,
            'tipoEntrenamiento' => $tipoEntrenamiento,
            'progreso' => $progreso,
            'nivel' => $nivel,
            'fechasEvaluaciones' => $fechasEvaluaciones,
            'bloques' => $dataValues,
            'dominadas' => $dominadas,
            'flexiones' => $flexiones,
            'minimaRegleta' => $minimaRegleta,
        ]);
    }

    private function determinarTipoEntrenamiento($dia)
    {
        if($dia <= 6){
            return 'Fuerza';
        } 
        if($dia <= 10){
            return 'Resistencia';
        }
        return 'Descarga';
    }  

    public function completarDia(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof \App\Models\User){
            return response()->json(['message' => 'Error interno: Usuario no válido.'], 500);
        }

        // Obtener el plan de entrenamiento del usuario
        $planEntrenamiento = PlanEntrenamientos::where('user_id', $user->id)->where('iniciado', true)->first();

        if (!$planEntrenamiento){
            return response()->json(['message' => 'No tienes un plan de entrenamiento activo'], 404);
        }

        $dia = $request->input('dia');

        // Verificar si el día ya está completado
        $diasCompletados = $planEntrenamiento->dias_completados ?? []; 
        if (in_array($dia, $diasCompletados)){ //
            return response()->json(['message' => 'El día ya está completado'], 200);
        }

        // Agregar el día al array de días completados
        $diasCompletados[] = $dia;
        $planEntrenamiento->dias_completados = $diasCompletados;

        // Si se completaron los 12 días
        if (count($diasCompletados) === 12){        
            $planEntrenamiento->completado = true; 
            $planEntrenamiento->iniciado = false; // Finalizar el plan actual
            $planEntrenamiento->fecha_fin = now(); // Fecha de finalización del plan
            $planEntrenamiento->save();

            $user->planes_completados++;
            $user->save();  

            if($user->planes_completados >= 2){
                return response()->json(['message' => 'Has completado dos planes de entrenamiento. Es hora de realizar una nueva evaluación.'], 200);
            }else {
                $this->generarPlan($user);
                return response()->json(['message' => 'Has completado un plan de entrenamiento. Automaticamente se ha generado un nuevo plan.  ¡¡¡Continua asi!!!', 'redirect' => route('dashboard', ['dia' => 1])], 200);
            }
        }
        $planEntrenamiento->save();

        return response()->json(['message' => 'Día completado correctamente'], 200);
    }

    public function descargarPDF()
    {
        $user = Auth::user();

        // Obtener el plan de entrenamiento activo del usuario
        $planEntrenamiento = PlanEntrenamientos::where('user_id', $user->id)->where('iniciado', true)->first();

        if (!$planEntrenamiento){
            return redirect()->back()->with('error', 'No tienes un plan de entrenamiento activo.');
        }

        // Obtener los ejercicios organizados por día
        $ejerciciosPorDia = [];
        $tiposEntrenamiento = [];
        for ($dia = 1; $dia <= 12; $dia++){
            $ejerciciosPorDia[$dia] = $planEntrenamiento->ejercicios()
                ->where('dia', $dia)
                ->with('ejercicio')
                ->get();
            // Determinar el tipo de entrenamiento
            if ($dia <= 6) {
                $tiposEntrenamiento[$dia] = 'Fuerza';
            } elseif ($dia <= 10){
                $tiposEntrenamiento[$dia] = 'Resistencia';
            } else {
                $tiposEntrenamiento[$dia] = 'Descarga';
            }
        }

        // Generar el PDF a partir de una vista
        $pdf = Pdf::loadView('planesEntrenamiento.pdf', compact('planEntrenamiento', 'ejerciciosPorDia', 'tiposEntrenamiento', 'user'));

        // Descargar el PDF
        return $pdf->download('plan_entrenamiento.pdf');
    }
}
