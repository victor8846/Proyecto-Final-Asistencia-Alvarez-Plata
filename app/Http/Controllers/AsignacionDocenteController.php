<?php

namespace App\Http\Controllers;

use App\Models\AsignacionDocente;
use App\Models\Docente;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Curso;
use Illuminate\Http\Request;

class AsignacionDocenteController extends Controller
{
    public function index()
    {
        $asignaciones = AsignacionDocente::with(['docente', 'carrera', 'materia', 'curso'])->get();
        return view('asignacion-docentes.index', compact('asignaciones'));
    }

    public function create()
    {
        $docentes = Docente::all();
        $carreras = Carrera::all();
        $materias = Materia::all();
        $cursos = Curso::all();

        return view('asignacion-docentes.create', compact('docentes', 'carreras', 'materias', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'carrera_id' => 'required|exists:carreras,id',
            'materia_id' => 'required|exists:materias,id',
            'curso_id' => 'required|exists:cursos,id',
            'dia' => 'required|string|max:20',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        AsignacionDocente::create($request->all());

        return redirect()->route('asignacion-docentes.index')->with('success', 'Asignación creada correctamente.');
    }

    public function edit(AsignacionDocente $asignacionDocente)
    {
        $docentes = Docente::all();
        $carreras = Carrera::all();
        $materias = Materia::all();
        $cursos = Curso::all();

        return view('asignacion-docentes.edit', [
            'asignacion' => $asignacionDocente,
            'docentes' => $docentes,
            'carreras' => $carreras,
            'materias' => $materias,
            'cursos' => $cursos,
        ]);
    }

    public function update(Request $request, AsignacionDocente $asignacionDocente)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'carrera_id' => 'required|exists:carreras,id',
            'materia_id' => 'required|exists:materias,id',
            'curso_id' => 'required|exists:cursos,id',
            'dia' => 'required|string|max:20',
            'hora_inicio' => 'required|date_format:H:i',
    'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $asignacionDocente->update($request->all());

        return redirect()->route('asignacion-docentes.index')->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(AsignacionDocente $asignacionDocente)
    {
        $asignacionDocente->delete();
        return redirect()->route('asignacion-docentes.index')->with('success', 'Asignación eliminada correctamente.');
    }
}
