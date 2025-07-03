@extends('adminlte::page')

@section('title', 'APP Climbing | Realizar Evaluación')

@section('content_header')
    <h1>Evaluacion</h1>
@stop

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4" id="cajaAnimada" style="max-width: 500px; width: 100%;">
        <h2 class="mb-4 text-center">Realizar Evaluación</h2>
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

            <button type="submit" class="btn w-100 mt-3" style="background-color:rgb(218, 188, 134); color:rgb(49, 87, 68)">Guardar Evaluación</button>
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
        input, select {
            background: #f8fafc;
            color: #615f5f !important;
        }
        input::placeholder {
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
    </style>
@stop

@section('js')
    <script>
        // Puedes añadir aquí animaciones JS si quieres transiciones al enviar el formulario
    </script>
@stop