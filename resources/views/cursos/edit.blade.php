@extends('layouts.adminlte')

@section('title', 'Editar Curso')

@section('content_header')
    <h1>Editar Curso</h1>
@stop

@section('content')
    <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
        @method('PUT')
        @include('cursos.form') {{-- usa el formulario común --}}
        <button type="submit" class="btn btn-success mt-2">Actualizar</button>
    </form>
@stop
