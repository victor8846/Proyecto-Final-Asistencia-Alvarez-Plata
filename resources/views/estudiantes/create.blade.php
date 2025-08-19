@extends('layouts.adminlte')

@section('title', 'Crear Estudiante')

@section('content')
<div class="container">
    <h1>Nuevo Estudiante</h1>
    <form action="{{ route('estudiantes.store') }}" method="POST">
        @csrf
        @include('estudiantes.form')
        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

