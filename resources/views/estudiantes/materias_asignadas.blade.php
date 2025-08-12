@extends('layouts.adminlte')

@section('title', 'Materias Asignadas')

@section('content_header')
    <h1>Materias de {{ $estudiante->nombre_completo }}</h1>
@stop

@section('content')
    @php
        $porDia = $horarios->groupBy('dia');
        $colores = ['table-primary', 'table-success', 'table-info', 'table-warning', 'table-danger'];
        $colorIndex = 0;
    @endphp

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Día</th>
                <th>Materia</th>
                <th>Docente</th>
                <th>Aula</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($porDia as $dia => $horariosDia)
                @php
                    $color = $colores[$colorIndex % count($colores)];
                    $colorIndex++;
                @endphp
                @foreach ($horariosDia as $i => $horario)
                    <tr class="{{ $color }}">
                        @if ($i === 0)
                            <td rowspan="{{ count($horariosDia) }}" class="align-middle text-center">
                                {{ ucfirst($dia) }}
                            </td>
                        @endif
                        <td>{{ $horario->asignacionDocente->materia->nombre ?? '—' }}</td>
                        <td>{{ $horario->asignacionDocente->docente->nombre_completo ?? '—' }}</td>
                        <td>{{ $horario->aula->nombre ?? '—' }}</td>
                        <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay materias asignadas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Regresar</a>
@endsection
