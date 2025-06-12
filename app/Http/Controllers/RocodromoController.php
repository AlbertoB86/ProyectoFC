<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rocodromo;

class RocodromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Rocodromo::query();

        if ($request->filled('ciudad')) {
            $query->where('ciudad', 'like', '%' . $request->ciudad . '%');
        }
        if ($request->filled('provincia')) {
            $query->where('provincia', 'like', '%' . $request->provincia . '%');
        }

        $rocodromos = $query->get();

        return view('rocodromos.index', compact('rocodromos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rocodromos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'horario' => 'nullable|string|max:255',
            'web' => 'nullable|string|max:255',
        ]);

        $rocodromo = new Rocodromo();
        $rocodromo->nombre = $request->nombre;
        $rocodromo->direccion = $request->direccion;
        $rocodromo->ciudad = $request->ciudad;
        $rocodromo->provincia = $request->provincia;
        $rocodromo->telefono = $request->telefono;
        $rocodromo->horario = $request->horario;
        $rocodromo->web = $request->web;
        $rocodromo->save();
        
        return redirect()->route('rocodromos.index')->with('success', 'Rocódromo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rocodromo = Rocodromo::all();
        return view('rocodromos.show', compact('rocodromo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rocodromo = Rocodromo::findOrFail($id);
        return view('rocodromos.edit', compact('rocodromo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'horario' => 'nullable|string|max:255',
            'web' => 'nullable|string|max:255',
            'latitud' => 'nullable|string|max:255',
            'longitud' => 'nullable|string|max:255',
            
        ]);

        $rocodromo = Rocodromo::findOrFail($id);
        $rocodromo->nombre = $request->nombre;
        $rocodromo->direccion = $request->direccion;
        $rocodromo->ciudad = $request->ciudad;
        $rocodromo->provincia = $request->provincia;
        $rocodromo->telefono = $request->telefono;
        $rocodromo->horario = $request->horario;
        $rocodromo->web = $request->web;
        $rocodromo->latitud = $request->latitud;
        $rocodromo->longitud = $request->longitud;
        $rocodromo->save();

        return redirect()->route('rocodromos.index')->with('success', 'Rocódromo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rocodromo = Rocodromo::findOrFail($id);
        $rocodromo->delete();

        return redirect()->route('rocodromos.index')->with('success', 'Rocódromo eliminado exitosamente.');
    }
}
