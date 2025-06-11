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
    <style>
        body {
            background: linear-gradient(120deg, #308bb4 0%, #1e3c72 100%) !important;
            min-height: 100vh;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        form {
            width: 100%;
            max-width: 500px;
            background-color: rgba(0,0,0,0.65);
            color: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            padding: 2rem 2rem 1rem 2rem;
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            animation: fadeInUp 1s ease forwards;
            animation-fill-mode: forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        label {
            color: #fff;
            font-weight: 500;
        }
        input, select, textarea {
            background: #f8fafc;
            color: #222 !important;
        }
        input::placeholder, textarea::placeholder {
            color: #888 !important;
            opacity: 1;
        }
        .btn, a.btn, .btn-success, .btn-secondary {
            font-weight: bold;
            border-radius: 8px;
            transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover, a.btn:hover, .btn-success:hover, .btn-secondary:hover {
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(48,139,180,0.18);
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
