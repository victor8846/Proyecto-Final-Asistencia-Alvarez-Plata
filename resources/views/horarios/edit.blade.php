@extends('layouts.adminlte')
@section('title', 'Editar Horario')

@section('content')
    <h3>Editar Horario</h3>
    <form action="{{ route('horarios.update', $horario) }}" method="POST">
        @csrf @method('PUT')
        @include('horarios.partials.form')
        <button class="btn btn-primary">Actualizar</button>
    </form>
@stop
