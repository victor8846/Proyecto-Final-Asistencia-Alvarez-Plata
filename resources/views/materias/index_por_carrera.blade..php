@extends('layouts.adminlte')

@section('title', 'Materias por Carrera')

@section('content_header')
    <h1>Materias por Carrera</h1>
@stop

@section('content')
    @if($carreras->isEmpty())
        <div class="alert alert-warning">No hay carreras registradas.</div>
    @else
        <!-- Nav tabs de carreras -->
        <ul class="nav nav-tabs" role="tablist">
            @foreach($carreras as $index => $carrera)
                <li class="nav-item">
                    <a class="nav-link {{ $index == 0 ? 'active' : '' }}" 
                       data-toggle="tab" 
                       href="#carrera{{ $carrera->id }}" 
                       role="tab">
                        {{ $carrera->nombre }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Contenido de cada pestaña -->
        <div class="tab-content mt-3">
            @foreach($carreras as $index => $carrera)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" 
                     id="carrera{{ $carrera->id }}" 
                     role="tabpanel">
                     
                    <h4>Materias de {{ $carrera->nombre }}</h4>

                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre de la Materia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($carrera->materias as $key => $materia)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $materia->nombre }}</td>
                                    <td>
                                        <a href="{{ route('materias.edit', $materia->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('materias.destroy', $materia->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Deseas eliminar esta materia?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No hay materias registradas para esta carrera.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endif
@stop
