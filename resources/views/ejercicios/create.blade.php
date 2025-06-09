@extends('adminlte::page')

@section('title', 'APP Climbing | Añadir Ejercicios')

@section('content_header')
    <h1>Nuevo Ejercicio</h1>
@stop

@section('content')
    <div class="container">
        <form action="{{ route('ejercicios.store') }}" method="POST">
            @csrf            
            <div class="mb-3">
                <label>Ejercicio:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">      
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label>Tipo:</label>
                <select name="tipo" class="form-control" required>
                    <option value="Calentamiento">Calentamiento</option>
                    <option value="Estiramiento">Estiramiento</option>
                    <option value="Fuerza">Fuerza</option>
                    <option value="Resistencia">Resistencia</option>
                    <option value="Core">Core</option>
                    <option value="Técnica">Técnica</option>
                </select>
            </div>         

            <div class="mb-3">
                <label>Nivel:</label>
                <select name="nivel" class="form-control" required>
                    <option value="Todos">Todos</option>
                    <option value="Iniciación">Iniciación</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Series:</label>
                <input type="number" name="series" class="form-control">
            </div>

            <div class="mb-3">
                <label>Repeticiones:</label>
                <input type="number" name="repeticiones" class="form-control">
            </div>

            <div class="mb-3">
                <label>Duración (min):</label>
                <input type="number" name="duracion" class="form-control">
            </div>
            
            <div class="mb-3">
                <label>Descanso (min):</label>
                <input type="number" name="descanso" class="form-control">
            </div>         

            <button type="submit" class="btn btn-success">Guardar Ejercicio</button>
            <a href="{{ route('ejercicios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <!-- Footer -->
    <hr style="border: 1px solid rgba(11, 75, 112, 0.295); width: 100%; margin-top: 50px; margin-bottom: 25px;">
    <p class="text-center text-body-secondary">© 2025 - Alberto Balaguer Toribio</p>
    </div>
    @include('components.cookies')
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
