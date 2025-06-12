@extends('adminlte::page')

@section('title', 'APP Climbing | Editar Rocodromos')

@section('content_header')
    <h1>Editar Rocodromos</h1>
@stop

@section('content')
    <div class="container">

        <form action="{{ route('rocodromos.update', $rocodromo) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" value="{{ $rocodromo->nombre }}" required>
            </div>

            <div class="mb-3">      
                <label>Dirección:</label>
                <input type="text" name="direccion" class="form-control" value="{{ $rocodromo->direccion }}">
            </div>

            <div class="mb-3">
                <label>Ciudad:</label>
                <input type="text" name="ciudad" class="form-control" value="{{ $rocodromo->ciudad }}">
            </div>

            <div class="mb-3">
                <label>Provincia:</label>
                <input type="text" name="provincia" class="form-control" value="{{ $rocodromo->provincia }}">
            </div>

            <div class="mb-3">
                <label>Teléfono:</label>
                <input type="text" name="telefono" class="form-control" value="{{ $rocodromo->telefono }}">
            </div>

            <div class="mb-3">
                <label>Horario:</label>
                <input type="text" name="horario" class="form-control" value="{{ $rocodromo->horario }}">
            </div>

            <div class="mb-3">
                <label>Web:</label>
                <input type="url" name="web" class="form-control" value="{{ $rocodromo->web }}">
            </div>

            <div class="mb-3">
                <label>Latitud:</label>
                <input type="text" name="latitud" class="form-control" value="{{ $rocodromo->latitud }}">
            </div>

            <div class="mb-3">
                <label>Longitud:</label>
                <input type="text" name="longitud" class="form-control" value="{{ $rocodromo->longitud }}">
            </div>
            
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Actualizar Rocódromo</button>
                <a href="{{ route('rocodromos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
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
    <script> console.log('Hi!'); </script>
@stop
