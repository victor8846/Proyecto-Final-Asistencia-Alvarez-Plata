@extends('layouts.adminlte')

@section('title', 'Editar Aula')

@section('content')
    <h3>Editar Aula</h3>
    <form action="{{ route('aulas.update', $aula) }}" method="POST">
        @csrf @method('PUT')
        @include('aulas.partials.form')
        <button class="btn btn-primary">Actualizar</button>
    </form>
@stop
