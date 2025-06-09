<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicios;
use Illuminate\Support\Facades\Auth;

class EjercicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verificar si el usuario está autenticado
        $user = Auth::user();
        
        if ($user->rol !== 'admin'){
            return redirect()->route('dashboard');
        }

        $ejercicios = Ejercicios::all();
        return view('ejercicios.index', compact('ejercicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        return view('ejercicios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'nivel' => 'required|string|max:255',
            'series' => 'nullable|integer',
            'repeticiones' => 'nullable|integer',
            'duracion' => 'nullable|integer',
            'descanso' => 'nullable|integer',
        ]);

        $ejercicio = new Ejercicios();
        $ejercicio->nombre = $request->nombre;  
        $ejercicio->descripcion = $request->descripcion;
        $ejercicio->tipo = $request->tipo;
        $ejercicio->nivel = $request->nivel;
        $ejercicio->series = $request->series;
        $ejercicio->repeticiones = $request->repeticiones;
        $ejercicio->duracion = $request->duracion;
        $ejercicio->descanso = $request->descanso;
        $ejercicio->modo_calculo = 'estatico'; // Valor por defecto
        $ejercicio->save();
        
        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio añadido correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($request)
    {
        $ejercicios = Ejercicios::all();
        return view('ejercicios.show', compact('ejercicios')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ejercicio = Ejercicios::findOrFail($id);
        return view('ejercicios.edit', compact('ejercicio'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'nivel' => 'required|string|max:255',
            'series' => 'nullable|integer',
            'repeticiones' => 'nullable|integer',
            'duracion' => 'nullable|integer',
            'descanso' => 'nullable|integer',
        ]);

        $ejercicio = Ejercicios::findOrFail($id);
        $ejercicio->nombre = $request->nombre;  
        $ejercicio->descripcion = $request->descripcion;
        $ejercicio->tipo = $request->tipo;
        $ejercicio->nivel = $request->nivel;
        $ejercicio->series = $request->series;
        $ejercicio->repeticiones = $request->repeticiones;
        $ejercicio->duracion = $request->duracion;
        $ejercicio->descanso = $request->descanso;
        $ejercicio->modo_calculo = 'estatico'; // Valor por defecto
        $ejercicio->save();

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ejercicio = Ejercicios::findOrFail($id);
        $ejercicio->delete();

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio eliminado correctamente.');
    }
}
