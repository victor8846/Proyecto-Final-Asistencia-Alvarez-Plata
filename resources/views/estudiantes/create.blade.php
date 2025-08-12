@extends('layouts.adminlte')

@section('title', 'Crear Estudiante')

@section('content_header')
    <h1>Nuevo Estudiante</h1>
@stop

@section('content')
    <form action="{{ route('estudiantes.store') }}" method="POST">
        @include('estudiantes.form')
        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
    </form>
@stop
