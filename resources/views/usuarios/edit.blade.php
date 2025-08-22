@extends('layouts.adminlte')

@section('title', 'Editar Usuario')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h1 class="mb-4">Editar Usuario</h1>

        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $usuario->name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="apellido_paterno">Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" class="form-control" value="{{ old('apellido_paterno', $usuario->apellido_paterno) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="apellido_materno">Apellido Materno</label>
                    <input type="text" name="apellido_materno" class="form-control" value="{{ old('apellido_materno', $usuario->apellido_materno) }}" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="role_id">Rol</label>
                    <select name="role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $usuario->role_id == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="password">Nueva Contraseña (opcional)</label>
                    <input type="password" name="password" id="password" class="form-control" required>
    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
        <i class="fa fa-eye"></i>
    </button>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
        <i class="fa fa-eye"></i>
    </button>
                </div>
            </div>
            <script>
function togglePassword(id) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}
</script>
<small id="passwordHelp" class="form-text text-muted">
    Mínimo 8 caracteres, con letras, números y símbolos.
</small>


            <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
        </form>
    </div>
</div>
@endsection
