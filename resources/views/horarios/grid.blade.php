@extends('layouts.adminlte')

@section('title', 'Horario por Curso')

@section('content_header')
    <h1>Horario de Clases</h1>
@stop
<a href="{{ route('horarios.exportar.pdf', [$horarios->first()?->carrera_id, $horarios->first()?->curso_id]) }}" class="btn btn-danger btn-sm">
    <i class="fas fa-file-pdf"></i> Exportar PDF
</a>

<a href="{{ route('horarios.exportar.excel', [$horarios->first()?->carrera_id, $horarios->first()?->curso_id]) }}" class="btn btn-success btn-sm">
    <i class="fas fa-file-excel"></i> Exportar Excel
</a>

@section('content')
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Hora</th>
                    @foreach($dias as $dia)
                        <th>{{ $dia }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($bloques as $bloque)
                    @php
                        [$inicio, $fin] = explode('-', $bloque);
                    @endphp
                    <tr>
                        <td><strong>{{ $bloque }}</strong></td>
                        @foreach($dias as $dia)
                            @php
                                $clase = $horarios->first(function ($h) use ($dia, $inicio) {
                                    return $h->dia === $dia && $h->hora_inicio == $inicio;
                                });
                            @endphp
                            <td style="font-size: 13px;">
                                @if($clase)
                                    <strong>{{ $clase->aula->nombre }}</strong><br>
                                    {{ $clase->asignacionDocente->materia->nombre }}<br>
                                    {{ $clase->asignacionDocente->docente->nombre_completo }}
                                @else
                                    -
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
