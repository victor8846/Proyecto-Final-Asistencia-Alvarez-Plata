@extends('layouts.adminlte')

@section('title', 'Nuevo Docente')

@section('content')
<div class="container">
    <h1>Registrar Docente</h1>
    <form action="{{ route('docentes.store') }}" method="POST">
        @csrf
        @include('docentes.form')
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
