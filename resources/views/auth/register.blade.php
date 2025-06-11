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
            max-width: 700px;
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
        .btn-register {
            background-color: #308bb4;
            color: white;
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
        .btn-register:hover {
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
        input, select {
            background: #f8fafc;
            color: #222 !important;
        }
    </style>

    <div class="caja" id="cajaAnimada">
        <x-authentication-card style="width: 100%; max-width: 1200px; margin: 0 auto;">
            <x-slot name="logo">
                {{-- <x-authentication-card-logo /> --}}
            </x-slot>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}" id="formRegister">
                @csrf

                <div class="grid grid-cols-2 gap-6" style="width: 600px;">
                    <div>
                        <x-label for="name" value="{{ __('Nombre') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>
                    <div>
                        <x-label for="primer_apellido" value="{{ __('Primer Apellido') }}" />
                        <x-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido" :value="old('primer_apellido')" required autocomplete="primer_apellido" />
                    </div>
                    <div>
                        <x-label for="segundo_apellido" value="{{ __('Segundo Apellido') }}"  style="color: white"/>
                        <x-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido" :value="old('segundo_apellido')" required autocomplete="segundo_apellido" />
                    </div>
                    <div>
                        <x-label for="sexo" value="{{ __('Sexo') }}" />
                        <select id="sexo" name="sexo" class="block mt-1 w-full" required>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O">Otro</option>
                        </select>
                    </div>
                    <div>
                        <x-label for="fecha_nacimiento" value="{{ __('Fecha de Nacimiento') }}" />
                        <x-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento" :value="old('fecha_nacimiento')" required autocomplete="fecha_nacimiento" />
                    </div>
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autocomplete="username" />
                    </div>
                    <div>
                        <x-label for="password" value="{{ __('Contraseña') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>
                    <div>
                        <x-label for="password_confirmation" value="{{ __('Confirmar contraseña') }}" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ms-2">
                                    {!! __('Estoy de acuerdo con los :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('¿Ya estás registrado?') }}
                    </a>

                    <button type="submit" class="btn-register ms-4 transicion">
                        {{ __('Registrarse') }}
                    </button>
                </div>
            </form>
        </x-authentication-card>
    </div>

    <script>
        // Transición al enviar el formulario de registro
        document.getElementById('formRegister').addEventListener('submit', function(e) {
            e.preventDefault();
            const caja = document.getElementById('cajaAnimada');
            caja.classList.add('fade-out');
            setTimeout(() => {
                e.target.submit();
            }, 500); // Debe coincidir con el tiempo del transition
        });
    </script>
</x-guest-layout>