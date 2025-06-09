<div>
    <h1>Cambiar contraseña</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="updatePassword" class="mt-4">
        <div>
            <label>Contraseña Actual</label>
            <input type="password" wire:model.defer="state.current_password" />
        </div>
        <div>
            <label>Nueva Contraseña</label>
            <input type="password" wire:model.defer="state.password" />
        </div>
        <div>
            <label>Confirmar Contraseña</label>
            <input type="password" wire:model.defer="state.password_confirmation" />
        </div>
        <button type="submit">Guardar</button>
    </form>
</div>

