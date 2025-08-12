@extends('layouts.adminlte')

@section('title', 'Estudiantes por Carrera')

@section('content_header')
    <h1>Estudiantes por Carrera</h1>
@stop

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Carrera</th>
                <th>Total Estudiantes</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datos as $fila)
                <tr>
                    <td>{{ $fila->nombre }}</td>
                    <td>{{ $fila->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
