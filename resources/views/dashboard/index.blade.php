@extends('layouts.adminlte')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel de Control</h1>
@stop

@section('content')
<div class="row">
    <!-- Cards resumen -->
    <div class="col-lg-2 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalEstudiantes }}</h3>
                <p>Estudiantes Registrados</p>
            </div>
            <div class="icon"><i class="fas fa-user-graduate"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalDocentes }}</h3>
                <p>Docentes Activos</p>
            </div>
            <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalCursos }}</h3>
                <p>Cursos Disponibles</p>
            </div>
            <div class="icon"><i class="fas fa-book"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalMateriasAsignadas }}</h3>
                <p>Materias Asignadas</p>
            </div>
            <div class="icon"><i class="fas fa-tasks"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $asistenciasHoy }}</h3>
                <p>Asistencias Registradas Hoy</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">Asistencias Última Semana</h3></div>
            <div class="card-body">
                <canvas id="asistenciasSemanaChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header"><h3 class="card-title">Alumnos por Carrera</h3></div>
            <div class="card-body">
                <canvas id="alumnosCarreraChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header"><h3 class="card-title">Materias por Carrera</h3></div>
            <div class="card-body">
                <canvas id="materiasCarreraChart"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Asistencias última semana
    const ctxSemana = document.getElementById('asistenciasSemanaChart').getContext('2d');
    new Chart(ctxSemana, {
        type: 'bar',
        data: {
            labels: @json($fechas),
            datasets: [{
                label: 'Asistencias',
                data: @json($asistenciasSemana),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });

    // Alumnos por carrera
    const ctxCarrera = document.getElementById('alumnosCarreraChart').getContext('2d');
    new Chart(ctxCarrera, {
        type: 'pie',
        data: {
            labels: @json($alumnosPorCarrera->pluck('nombre')),
            datasets: [{
                label: 'Alumnos',
                data: @json($alumnosPorCarrera->pluck('total')),
                backgroundColor: [
                    '#007bff','#28a745','#ffc107','#dc3545','#17a2b8','#6c757d'
                ],
            }]
        }
    });

    // Materias por carrera
    const ctxMaterias = document.getElementById('materiasCarreraChart').getContext('2d');
    new Chart(ctxMaterias, {
        type: 'bar',
        data: {
            labels: @json($materiasPorCarrera->pluck('carrera')),
            datasets: [{
                label: 'Cantidad de Materias',
                data: @json($materiasPorCarrera->pluck('total')),
                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@stop
