@extends('layouts.adminlte')

@section('title', 'Estudiantes')

@section('content')
<div class="container">
    <h1>Lista de Estudiantes</h1>

    {{-- Filtros --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('estudiantes.create') }}" class="btn btn-primary">Nuevo Estudiante</a>

        <form method="GET" action="{{ route('estudiantes.index') }}" class="d-flex" style="gap: 10px;">
            <select name="curso" class="form-control">
                <option value="">-- Selecciona un curso --</option>
                @foreach ($cursos as $curso)
                    <option value="{{ $curso->id }}" {{ request('curso') == $curso->id ? 'selected' : '' }}>
                        {{ $curso->nombre }} {{ $curso->paralelo }}
                    </option>
                @endforeach
            </select>

            <select name="carrera" class="form-control">
                <option value="">-- Selecciona una carrera --</option>
                @foreach ($carreras as $carrera)
                    <option value="{{ $carrera->id }}" {{ request('carrera') == $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->nombre }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-success">Buscar</button>
            <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Limpiar</a>
        </form>
    </div>

    {{-- Notificaciones --}}
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6'
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        });
    </script>
@endif


    {{-- Agrupación por carrera y curso --}}
    @php
        $agrupados = $estudiantes->groupBy(function($estudiante) {
            return $estudiante->carrera->nombre ?? 'Sin carrera';
        })->map(function($grupo) {
            return $grupo->groupBy(function($estudiante) {
                return $estudiante->curso ? $estudiante->curso->nombre . ' ' . $estudiante->curso->paralelo : 'Sin curso';
            });
        });
    @endphp

    @foreach ($agrupados as $nombreCarrera => $cursos)
        @foreach ($cursos as $nombreCurso => $grupoEstudiantes)
            <h4><strong>Carrera:</strong> {{ $nombreCarrera }} - <strong>Curso:</strong> {{ $nombreCurso }}</h4>

            <table class="table table-bordered table-hover">
            <thead class="table-dark">
                    <tr>
                        <th>Nº</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>CI</th>
                        <th>UID NFC</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grupoEstudiantes as $estudiante)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $estudiante->nombre }}</td>
                            <td>{{ $estudiante->apellido_paterno }}</td>
                            <td>{{ $estudiante->apellido_materno }}</td>
                            <td>{{ $estudiante->ci }}</td>
                            <td>{{ $estudiante->uid_nfc ?? 'N/A' }}</td>
                            <td>{{ $estudiante->email ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('estudiantes.materias', $estudiante->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver materias y horarios
                                </a>
                                <a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('estudiantes.destroy', $estudiante) }}" method="POST" style="display:inline" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No se encontraron estudiantes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endforeach
    @endforeach

    {{-- Paginación --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $estudiantes->appends(request()->query())->links() }}
    </div>
</div>

{{-- Confirmación de eliminación --}}
<script>
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará al estudiante.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
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
