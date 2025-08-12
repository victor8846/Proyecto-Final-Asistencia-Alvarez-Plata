@extends('layouts.adminlte')

@section('title', 'Detalle de Asistencia')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detalle de Asistencia</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Alumno:</strong> {{ $asistencia->alumno->nombre }} {{ $asistencia->alumno->apellido }}</p>
            <p><strong>Curso:</strong> {{ $asistencia->curso->nombre }}</p>
            <p><strong>Materia:</strong> {{ $asistencia->materia->nombre }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</p>
            <p><strong>Hora de Ingreso:</strong> {{ \Carbon\Carbon::parse($asistencia->hora_ingreso)->format('H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('asistencias.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
</div>
@endsection
