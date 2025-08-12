@extends('layouts.adminlte')
@section('title', 'Crear Horario')

@section('content')
    <h3>Nuevo Horario</h3>
    <form action="{{ route('horarios.store') }}" method="POST">
        @csrf
        @include('horarios.partials.form')
        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@stop
