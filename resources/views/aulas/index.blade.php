@extends('layouts.adminlte')

@section('title', 'Lista de Aulas')

@section('content_header')
    <h1>Aulas</h1>
@stop

@section('content')
    <a href="{{ route('aulas.create') }}" class="btn btn-success mb-3">Agregar Aula</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aulas as $aula)
                <tr>
                    <td>{{ $aula->nombre }}</td>
                    <td>
                        <a href="{{ route('aulas.edit', $aula) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('aulas.destroy', $aula) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('¿Estás seguro?')" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
