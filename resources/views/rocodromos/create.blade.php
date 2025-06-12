@extends('adminlte::page')

@section('title', 'APP Climbing | Crear Rocodromos')

@section('content_header')
    <h1>Crear Rocodromos</h1>
@stop

@section('content')
    <div class="container">

        <form action="{{ route('rocodromos.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">      
                <label>Dirección:</label>
                <input type="text" name="direccion" class="form-control">
            </div>

            <div class="mb-3">
                <label>Ciudad:</label>
                <input type="text" name="ciudad" class="form-control">
            </div>

            <div class="mb-3">
                <label>Provincia:</label>
                <input type="text" name="provincia" class="form-control">
            </div>

            <div class="mb-3">
                <label>Teléfono:</label>
                <input type="text" name="telefono" class="form-control">
            </div>

            <div class="mb-3">
                <label>Horario:</label>
                <input type="text" name="horario" class="form-control">
            </div>

            <div class="mb-3">
                <label>Web:</label>
                <input type="url" name="web" class="form-control">
            </div>

            <div class="mb-3">
                <label>Latitud:</label>
                <input type="text" name="latitud" class="form-control">
            </div>

            <div class="mb-3">
                <label>Longitud:</label>
                <input type="text" name="longitud" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Crear Rocódromo</button>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop
@section('js')
    <script>
        // Aquí puedes agregar scripts específicos si es necesario
    </script>
@stop