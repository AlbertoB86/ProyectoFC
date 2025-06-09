<div class="card mb-4">
    <div class="card-header bg-danger text-black">
        Borrar cuenta
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('user.manual-delete')}}" onsubmit="return confirm('¿Estás seguro de que quieres borrar tu cuenta? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')

            <div class="mb-3">
                <label for="password" class="text-dark">Introduce tu contraseña para confirmar:</label>
                <input id="password" name="password" type="password" class="form-control mt-1" required autocomplete="off" />
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-danger">Borrar cuenta</button>
        </form>
    </div>
</div>
