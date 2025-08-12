@extends('layouts.adminlte')

@section('title', 'Editar Estudiante')

@section('content_header')
    <h1>Editar Estudiante</h1>
@stop

@section('content')
    <form action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
        @method('PUT')
        @include('estudiantes.form')
        <button type="submit" class="btn btn-success mt-2">Actualizar</button>
    </form>
@stop
