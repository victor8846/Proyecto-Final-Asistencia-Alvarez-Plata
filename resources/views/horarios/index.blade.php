@extends('layouts.adminlte')

@section('title', 'Horarios')

@section('content_header')
    <h1>Horarios por Carrera y Curso</h1>
@stop

@section('content')

    {{-- Botón para agregar nuevo horario --}}
    <a href="{{ route('horarios.create') }}" class="btn btn-success mb-3">Agregar Horario</a>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php
        $agrupados = $horarios->groupBy(function ($item) {
            return $item->carrera->nombre . '|' . $item->curso->nombre . ' ' . $item->curso->paralelo;
        });
    @endphp

    @foreach ($agrupados as $grupo => $horariosGrupo)
        @php
            [$carreraNombre, $cursoNombre] = explode('|', $grupo);
            $porDia = $horariosGrupo->groupBy('dia');
            $colores = ['table-primary', 'table-secondary', 'table-success', 'table-danger', 'table-warning'];
        @endphp

        <h4 class="mt-4">
            <strong>Carrera:</strong> {{ $carreraNombre }} - 
            <strong>Curso:</strong> {{ $cursoNombre }}
        </h4>

        {{-- Tabla de horarios por grupo --}}
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Día</th>
                    <th>Materia</th>
                    <th>Docente</th>
                    <th>Aula</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($porDia as $dia => $horariosDia)
                    @php
                        $color = $colores[$loop->index % count($colores)];
                    @endphp
                    @foreach($horariosDia as $i => $horario)
                        <tr class="{{ $color }}">
                            @if($i === 0)
                                <td rowspan="{{ count($horariosDia) }}"class="align-middle text-center">{{ ucfirst($dia) }}</td>
                            @endif
                            <td>{{ $horario->asignacionDocente->materia->nombre ?? '—' }}</td>
                            <td>{{ $horario->asignacionDocente->docente->nombre_completo ?? '—' }}</td>
                            <td>{{ $horario->aula->nombre ?? '—' }}</td>
                            <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                            <td>
                                <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('¿Eliminar este horario?')" class="btn btn-sm btn-danger">
                                        Borrar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay horarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

@endsection
