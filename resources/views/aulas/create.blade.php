@extends('layouts.adminlte')

@section('title', 'Crear Aula')

@section('content')
    <h3>Nueva Aula</h3>
    <form action="{{ route('aulas.store') }}" method="POST">
        @csrf
        @include('aulas.partials.form')
        <button class="btn btn-success">Guardar</button>
    </form>
@stop
