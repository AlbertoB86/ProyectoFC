@extends('adminlte::page')

@section('title', 'APP Escalada - Perfil')

@section('content_header')
    <h1>Perfil de Usuario</h1>
@stop

@section('content')
    <p>Bienvenido al perfil de usuario. Aquí puedes actualizar tu información personal.</p>
    <p>¡Gracias por usar nuestra aplicación!</p>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')
                    <hr>
                @endif
                

                {{-- Elimina o comenta esta sección si no deseas mostrar el formulario de cambio de contraseña --}}
                {{-- 
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="mt-4">
                        @livewire('profile.update-password-form')
                    </div>
                    <hr>
                @endif 
                --}}

                {{-- @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                    <hr>
                    <div class="mt-4">
                        @livewire('profile.delete-user-form')
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
    <hr style="border: 1px solid rgba(11, 75, 112, 0.295); width: 100%; margin-top: 50px; margin-bottom: 25px;">
    <p class="text-center text-body-secondary">© 2025 - Alberto Balaguer Toribio</p>
    @include('components.cookies')
@stop
