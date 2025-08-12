<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Alumno;
use App\Models\Materia;
use App\Models\Curso;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Asistencia::with(['alumno', 'materia', 'curso'])
                    ->whereDate('fecha', now());

        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        if ($request->filled('materia_id')) {
            $query->where('materia_id', $request->materia_id);
        }

        $asistencias = $query->get();
        $cursos = Curso::all();
        $materias = Materia::all();

        return view('asistencias.index', compact('asistencias', 'cursos', 'materias'));
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $materias = Materia::all();
        $cursos = Curso::all();

        return view('asistencias.create', compact('alumnos', 'materias', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'materia_id' => 'required|exists:materias,id',
            'hora_ingreso' => 'required',
            'fecha' => 'required|date',
        ]);

        Asistencia::create([
            'alumno_id' => $request->alumno_id,
            'materia_id' => $request->materia_id,
            'curso_id' => $request->curso_id,
            'hora_ingreso' => $request->hora_ingreso,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('asistencias.index')->with('success', 'Asistencia registrada correctamente.');
    }
    public function show($id)
{
    $asistencia = Asistencia::with(['alumno', 'curso', 'materia'])->findOrFail($id);
    return view('asistencias.show', compact('asistencia'));
}
}
