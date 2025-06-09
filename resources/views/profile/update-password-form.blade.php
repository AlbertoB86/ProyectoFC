@extends('adminlte::page')

@section('title', 'APP Escalada - Cambiar Contraseña')

@section('content_header')
    <h1>Cambiar contraseña</h1>
@stop

@section('content')
    @if (session('status') == 'password-updated')
        <div class="alert alert-success mt-3">
            ¡Contraseña actualizada correctamente!
            <a href="{{ route('dashboard') }}" class="btn btn-success btn-sm ms-2">Ir al inicio</a>
        </div>
    @else
        <form method="POST" action="{{ route('user-password.update') }}" class="mt-4">
            @csrf
            @method('PUT')
            @if ($errors->updatePassword->any())
                <div class="alert alert-danger text-center">
                    @foreach ($errors->updatePassword->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="col-span-6 sm:col-span-4 mb-3">
                <label for="current_password" class="text-dark" style="margin-right: 30px">Contraseña Actual</label>
                <input id="current_password" name="current_password" type="password" class="form-control mt-1" autocomplete="current-password" required />
                @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-6 sm:col-span-4 mb-3">
                <label for="password" class="text-dark" style="margin-right: 30px">Nueva Contraseña</label>
                <input id="password" name="password" type="password" class="form-control mt-1" autocomplete="new-password" required />
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-6 sm:col-span-4 mb-3">
                <label for="password_confirmation" class="text-dark" style="margin-right: 10px">Confirmar Contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control mt-1" autocomplete="new-password" required />
                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-info" style="margin: 10px">Guardar</button>
        </form>
    @endif
    <hr style="border: 1px solid rgba(11, 75, 112, 0.295); width: 100%; margin-top: 50px; margin-bottom: 25px;">
    <p class="text-center text-body-secondary">© 2025 - Alberto Balaguer Toribio</p>
    @include('components.cookies')
@stop