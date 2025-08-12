@extends('layouts.adminlte')

@section('title', 'Asignaciones de Docentes')

@section('content_header')
    <h1>Listado de Asignaciones</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('asignacion-docentes.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Nueva Asignación
    </a>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover text-nowrap">
                <thead class="thead-dark">
                    <tr>
                        
                        <th>Docente</th>
                        <th>Carrera</th>
                        <th>Materia</th>
                        <th>Curso</th>
                        <th>Día</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($asignaciones as $asignacion)
                        <tr>
                            
                            <td>{{ $asignacion->docente->nombre_completo ?? 'Sin docente' }}</td>
                            <td>{{ $asignacion->carrera->nombre ?? 'Sin carrera' }}</td>
                            <td>{{ $asignacion->materia->nombre ?? 'Sin materia' }}</td>
                                           <td>
    {{ $asignacion->curso ? $asignacion->curso->nombre . ' ' . $asignacion->curso->paralelo : 'Sin curso' }}
</td>
                            <td>{{ $asignacion->dia }}</td>
                            <td>{{ $asignacion->hora_inicio }}</td>
                            <td>{{ $asignacion->hora_fin }}</td>
                            <td>
                                <a href="{{ route('asignacion-docentes.edit', $asignacion->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('asignacion-docentes.destroy', $asignacion->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta asignación?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay asignaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
