@extends('layouts.adminlte')

@section('title', 'Cursos')

@section('content')
<div class="container">
    <h1>Listado de Cursos</h1>
    <a href="{{ route('cursos.create') }}" class="btn btn-primary mb-3">Nuevo Curso</a>

    <form method="GET" action="{{ route('cursos.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Buscar por curso" value="{{ request('nombre') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="paralelo" class="form-control" placeholder="Buscar por paralelo" value="{{ request('paralelo') }}">
        </div>
        <div class="col-md-3">
            <select name="carrera_id" class="form-control">
                <option value="">-- Seleccionar carrera --</option>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}" {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex">
            <button type="submit" class="btn btn-success me-2">Buscar</button>
            <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6'
                });
            });
        </script>
    @endif

   <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th>Curso</th>
                <th>Paralelo</th>
                <th>Carrera</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cursos as $curso)
                <tr>
                    <td>{{ $curso->nombre }}</td>
                    <td>{{ $curso->paralelo }}</td>
                    <td>{{ $curso->carrera->nombre ?? 'Sin asignar' }}</td>
                    <td>
                        <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('cursos.destroy', $curso) }}" method="POST" style="display:inline-block" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No se encontraron cursos.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            let form = this.closest('form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esto eliminará el curso.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
