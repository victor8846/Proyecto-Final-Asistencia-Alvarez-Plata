@extends('layouts.adminlte')

@section('title', 'Crear Curso')

@section('content_header')
    <h1>Crear Curso</h1>
@stop

@section('content')
    <form action="{{ route('cursos.store') }}" method="POST">
        @include('cursos.form') {{-- usa el formulario común --}}
        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
    </form>
@stop
