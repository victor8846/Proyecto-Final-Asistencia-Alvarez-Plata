@extends('layouts.adminlte')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">
    <h1>Editar Usuario</h1>

    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
        </div>
        <div class="mb-3">
            <label>Rol</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="user" {{ $usuario->role == 'user' ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
