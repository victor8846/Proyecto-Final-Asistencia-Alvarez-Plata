@extends('layouts.adminlte')

@section('title', 'Editar Docente')

@section('content')
<div class="container">
    <h1>Editar Docente</h1>
    <form action="{{ route('docentes.update', $docente->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('docentes.form')
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
