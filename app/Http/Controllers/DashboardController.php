<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total estudiantes
        $totalEstudiantes = DB::table('estudiantes')->count();

        // Total docentes
        $totalDocentes = DB::table('docentes')->count();

        // Total cursos únicos en tabla estudiantes
        $totalCursos = DB::table('estudiantes')->distinct('curso_id')->count('curso_id');

        // Total materias asignadas a carreras
        $totalMateriasAsignadas = DB::table('materias')->whereNotNull('carrera_id')->count();

        // Asistencias registradas hoy
        $hoy = Carbon::today()->toDateString();
        $asistenciasHoy = DB::table('asistencias')
            ->whereDate('fecha', $hoy)
            ->count();

        // Datos para gráfico de asistencia semanal (últimos 7 días)
        $fechas = [];
        $asistenciasSemana = [];

        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::today()->subDays($i);
            $fechas[] = $fecha->format('d-m');
            $count = DB::table('asistencias')
                ->whereDate('fecha', $fecha->toDateString())
                ->count();
            $asistenciasSemana[] = $count;
        }

        // Alumnos por carrera (ahora con JOIN entre estudiantes y carreras)
        $alumnosPorCarrera = DB::table('estudiantes')
            ->join('carreras', 'estudiantes.carrera_id', '=', 'carreras.id')
            ->select('carreras.nombre as nombre', DB::raw('count(*) as total'))
            ->groupBy('carreras.nombre')
            ->get();

        // Materias por carrera
        $materiasPorCarrera = DB::table('materias')
            ->join('carreras', 'materias.carrera_id', '=', 'carreras.id')
            ->select('carreras.nombre as carrera', DB::raw('count(materias.id) as total'))
            ->groupBy('carreras.nombre')
            ->get();

        return view('dashboard.index', compact(
            'totalEstudiantes',
            'totalDocentes',
            'totalCursos',
            'totalMateriasAsignadas',
            'asistenciasHoy',
            'fechas',
            'asistenciasSemana',
            'alumnosPorCarrera',
            'materiasPorCarrera'
        ));
    }
}
