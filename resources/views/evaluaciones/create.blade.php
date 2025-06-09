@extends('adminlte::page')

@section('title', 'APP Climbing | Realizar Evaluación')

@section('content_header')
    <h1>TEST</h1>
@stop

@section('content')
<div class="container">
    <h1>Realizar Evaluación</h1>

    <form action="{{ route('evaluaciones.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Peso (kg):</label>
            <input type="number" name="peso" step="0.1" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Altura (cm):</label>
            <input type="number" name="altura" class="form-control" required min="100" max="250">
        </div>

        <div class="mb-3">
            <label>Dominadas al fallo:</label>
            <input type="number" name="dominadas_fallo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Flexiones al fallo:</label>
            <input type="number" name="flexiones_fallo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Máximo tiempo en regleta 40 mm (seg):</label>
            <input type="number" name="max_tiempo_regleta_40mm" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mínima regleta donde se aguante 10 seg (mm):</label>
            {{-- <input type="number" name="minima_regleta_10seg" class="form-control" required> --}}
            <select name="minima_regleta_10seg" class="form-control">
                <option value="40">40</option>
                <option value="30">30</option>
                <option value="20">20</option>
                <option value="18">18</option>
                <option value="16">16</option>
                <option value="14">14</option>            
                <option value="12">12</option>
                <option value="10">10</option>
                <option value="8">8</option>
                <option value="6">6</option>
                <option value="4">4</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Bloque máximo encadenado en menos de 5 intentos:</label>
            <select name="bloque_max" class="form-control" required>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5a">5a</option>
                <option value="5b">5b</option>
                <option value="6a">6a</option>
                <option value="6b">6b</option>
                <option value="6c">6c</option>
                <option value="7a">7a</option>
                <option value="7b">7b</option>
                <option value="7c">7c</option>
                <option value="8a">8a</option>
            </select>
        </div>        

        <button type="submit" class="btn btn-success">Guardar Evaluación</button>
    </form>
    <!-- Footer -->
    <hr style="border: 1px solid rgb(11, 75, 112); width: 100%; margin-top: 50px; margin-bottom: 25px;">
    <p class="text-center text-body-secondary">© 2025 - Alberto Balaguer Toribio</p>
    @include('components.cookies')
</div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
