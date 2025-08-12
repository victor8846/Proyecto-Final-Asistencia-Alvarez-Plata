@extends('layouts.adminlte')

@section('title', 'Nueva Asignación')

@section('content_header')
    <h1>Crear Asignación</h1>
@stop

@section('content')
    <form action="{{ route('asignacion-docentes.store') }}" method="POST">
        @csrf

        @include('asignacion-docentes.form') {{-- ✅ Usa guión, no subrayado --}}

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('asignacion-docentes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@stop
