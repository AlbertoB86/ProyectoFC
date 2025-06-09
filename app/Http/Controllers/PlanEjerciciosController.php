<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanEjercicios;

class PlanEjerciciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    
    public function actualizarEstado(Request $request, $id)
    {
        $planId = $request->input('plan_id');
        $dia = $request->input('dia');
        $completado = $request->input('completado');

        $ejercicioPlan = PlanEjercicios::where('plan_id', $planId)->where('ejercicio_id', $id)->where('dia', $dia)->first();
        
        if (!$ejercicioPlan){
            return response()->json(['message' => 'Ejercicio no encontrado'], 404);
        }
        
        $ejercicioPlan->completado = $request->input('completado'); // Cambia el estado a completado o no completado
        $ejercicioPlan->save();        

        return response()->json(['message' => 'Ejercicio actualizado correctamente']);
    }
    
}
