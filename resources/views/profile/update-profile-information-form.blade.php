<div class="card mb-4">
    <div class="card-header bg-info text-white">
        Actualizar información de perfil
    </div>
    <div class="card-body">
        <form wire:submit.prevent="updateProfileInformation">
            <!-- Nombre -->
            <div class="mb-3">
                <label for="name" class="text-dark">Nombre</label>
                <x-input id="name" type="text" class="form-control mt-1" wire:model="state.name" required autocomplete="name" />
                <x-input-error for="name" class="mt-2" />
            </div>
            <!-- Primer Apellido -->
            <div class="mb-3">
                <label for="primer_apellido" class="text-dark">Primer Apellido</label>
                <x-input id="primer_apellido" type="text" class="form-control mt-1" wire:model="state.primer_apellido" required autocomplete="primer_apellido" />
                <x-input-error for="primer_apellido" class="mt-2" />
            </div>
            <!-- Segundo Apellido -->
            <div class="mb-3">
                <label for="segundo_apellido" class="text-dark">Segundo Apellido</label>
                <x-input id="segundo_apellido" type="text" class="form-control mt-1" wire:model="state.segundo_apellido" required autocomplete="segundo_apellido" />
                <x-input-error for="segundo_apellido" class="mt-2" />
            </div>
            <!-- Sexo -->
            <div class="mb-3">
                <label for="sexo" class="text-dark">Sexo</label>
                <select id="sexo" class="form-select mt-1" wire:model="state.sexo" required>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="O">Otro</option>
                </select>
                <x-input-error for="sexo" class="mt-2" />
            </div>
            <!-- Fecha de Nacimiento -->
            <div class="mb-3">
                <label for="fecha_nacimiento" class="text-dark">Fecha de Nacimiento</label>
                <x-input id="fecha_nacimiento" type="date" class="form-control mt-1" wire:model="state.fecha_nacimiento" required autocomplete="fecha_nacimiento" />
                <x-input-error for="fecha_nacimiento" class="mt-2" />
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="text-dark">Email</label>
                <x-input id="email" type="email" class="form-control mt-1" wire:model="state.email" required autocomplete="username" />
                <x-input-error for="email" class="mt-2" />
            </div>
            <button class="btn btn-info" style="margin: 10px">{{ __('Guardar') }}</button>
        </form>
    </div>
</div>
