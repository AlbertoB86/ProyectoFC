@extends('adminlte::page')

@section('title', 'APP Climbing | Editar Ejercicio')

@section('content_header')
    <h1>Editar Ejercicio</h1>
@stop

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4" style="max-width: 500px; width: 100%;">
        <form action="{{ route('ejercicios.update', $ejercicio) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Ejercicio:</label>
                <input type="text" name="nombre" class="form-control" value="{{ $ejercicio->nombre }}" required>
            </div>

            <div class="mb-3">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control" required>{{ $ejercicio->descripcion }}</textarea>
            </div>

            <div class="mb-3">
                <label>Tipo:</label>
                <select name="tipo" class="form-control" required>
                    <option value="Calentamiento" {{ $ejercicio->tipo == 'Calentamiento' ? 'selected' : '' }}>Calentamiento</option>
                    <option value="Estiramiento" {{ $ejercicio->tipo == 'Estiramiento' ? 'selected' : '' }}>Estiramiento</option>
                    <option value="Fuerza" {{ $ejercicio->tipo == 'Fuerza' ? 'selected' : '' }}>Fuerza</option>
                    <option value="Resistencia" {{ $ejercicio->tipo == 'Resistencia' ? 'selected' : '' }}>Resistencia</option>
                    <option value="Core" {{ $ejercicio->tipo == 'Core' ? 'selected' : '' }}>Core</option>
                    <option value="Técnica" {{ $ejercicio->tipo == 'Técnica' ? 'selected' : '' }}>Técnica</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Nivel:</label>
                <select name="nivel" class="form-control" required>
                    <option value="Todos" {{ $ejercicio->nivel == 'Todos' ? 'selected' : '' }}>Todos</option>
                    <option value="Iniciación" {{ $ejercicio->nivel == 'Iniciación' ? 'selected' : '' }}>Iniciación</option>
                    <option value="Intermedio" {{ $ejercicio->nivel == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                    <option value="Avanzado" {{ $ejercicio->nivel == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Series:</label>
                <input type="number" name="series" class="form-control" value="{{ $ejercicio->series }}">
            </div>

            <div class="mb-3">
                <label>Repeticiones:</label>
                <input type="number" name="repeticiones" class="form-control" value="{{ $ejercicio->repeticiones }}">
            </div>

            <div class="mb-3">
                <label>Duración (min):</label>
                <input type="number" name="duracion" class="form-control" value="{{ $ejercicio->duracion }}">
            </div>

            <div class="mb-3">
                <label>Descanso (min):</label>
                <input type="number" name="descanso" class="form-control" value="{{ $ejercicio->descanso }}">
            </div>

            <div class="mb-3 d-flex gap-2">
                <button type="submit" class="btn btn-success w-100">Actualizar Ejercicio</button>
                <a href="{{ route('ejercicios.index') }}" class="btn btn-secondary w-100">Cancelar</a>
            </div>
        </form>
        <hr style="border: 1px solid rgb(218, 188, 134); width: 100%; margin-top: 40px; margin-bottom: 15px;">
        <p class="text-center text-body-secondary">© 2025 - Alberto Balaguer Toribio</p>
        @include('components.cookies')
    </div>
</div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #308bb4 0%, #1e3c72 100%) !important;
            min-height: 100vh;
        }
        .card {
            background-color: rgb(49, 87, 68) !important;
            color: rgb(218, 188, 134);
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
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
            color: rgb(218, 188, 134);
            font-weight: 500;
        }
        input, select, textarea {
            background: #f8fafc;
            color: #615f5f !important;
        }
        input::placeholder, textarea::placeholder {
            color: #888 !important;
            opacity: 1;
        }
        .btn-success {
            font-weight: bold;
            border-radius: 8px;
            transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(67, 240, 78, 0.15);
        }
        .btn-success:hover {
            background: #4888a5;
            color: #fff;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(48,139,180,0.18);
        }
        .btn-secondary {
            background: #e0eafc;
            color: #1e3c72;
            border: none;
        }
        .btn-secondary:hover {
            background: #b6d0ee;
            color: #1e3c72;
        }
    </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
