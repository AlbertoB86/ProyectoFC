<x-guest-layout>
    <style>
        body {
            background: linear-gradient(120deg, #308bb4 0%, #1e3c72 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .caja {
            background-color: linear-gradient(120deg, #308bb4 0%, #1e3c72 100%);
            padding: 2.5rem 2rem;
            border-radius: 18px;
            text-align: center;
            color: white;
            max-width: 400px;
            margin: 2rem auto;            
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            animation: fadeInUp 1s ease forwards;
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .caja.fade-out {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            transition: opacity 0.5s, transform 0.5s;
        }
        .btn-login {
            background-color: #308bb4;
            color: rgb(0, 0, 0);
            padding: 12px 28px;
            font-weight: bold;
            border-radius: 4px;
            font-size: 1.1rem;
            border: none;
            outline: none;
            display: inline-block;
            transition: background 0.3s, color 0.3s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(48,139,180,0.10);
        }
        .btn-login:hover {
            background: #4888a5;
            color: #fff;
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 4px 16px rgba(48,139,180,0.18);
        }
        .text-gray-600, .text-sm {
            color: #fff !important;
        }
        label, .text-gray-600 {
            color: #fff !important;
        }
        input {
            background: #f8fafc;            
            color: #222 !important;
        }
    </style>

    <div class="caja" id="cajaAnimada">
        <x-authentication-card>
            <x-slot name="logo">
                {{-- <x-authentication-card-logo /> --}}
            </x-slot>

            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}" id="formLogin">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Contraseña') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600" style="color: white">{{ __('Recuerdame') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" style="color: white">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif

                    <button type="submit" class="btn-login ms-4 transicion">
                        {{ __('Iniciar') }}
                    </button>
                </div>
            </form>
        </x-authentication-card>
    </div>

    <script>
        // Transición al enviar el formulario de login
        document.getElementById('formLogin').addEventListener('submit', function(e) {
            e.preventDefault();
            const caja = document.getElementById('cajaAnimada');
            caja.classList.add('fade-out');
            setTimeout(() => {
                e.target.submit();
            }, 500); // Debe coincidir con el tiempo del transition
        });
    </script>
</x-guest-layout>