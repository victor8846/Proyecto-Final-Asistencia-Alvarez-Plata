<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Carrera;
use App\Models\Curso;
use App\Models\Aula;
use App\Models\AsignacionDocente;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HorarioExport;

class HorarioController extends Controller
{
    public function index()
    {
        $horarios = Horario::with(['carrera', 'curso', 'asignacionDocente.materia', 'asignacionDocente.docente', 'aula'])->get();

    $carreras = Carrera::all();
    $cursos = Curso::all();
    $aulas = Aula::all();

    return view('horarios.index', compact('horarios', 'carreras', 'cursos', 'aulas'));
    }

    public function create()
    {
        $carreras = Carrera::all();
        $cursos = Curso::all();
        $aulas = Aula::all();
        $asignaciones = AsignacionDocente::with('materia', 'docente')->get();

        return view('horarios.create', compact('carreras', 'cursos', 'aulas', 'asignaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'carrera_id' => 'required',
            'curso_id' => 'required',
            'asignacion_docente_id' => 'required',
            'aula_id' => 'required',
            'dia' => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente');
    }

    public function edit($id)
    {
        $horario = Horario::findOrFail($id);
        $carreras = Carrera::all();
        $cursos = Curso::all();
        $aulas = Aula::all();
        $asignaciones = AsignacionDocente::with('materia', 'docente')->get();

        return view('horarios.edit', compact('horario', 'carreras', 'cursos', 'aulas', 'asignaciones'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'carrera_id' => 'required',
            'curso_id' => 'required',
            'asignacion_docente_id' => 'required',
            'aula_id' => 'required',
            'dia' => 'required',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horario = Horario::findOrFail($id);
        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente');
    }

    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente');
    }

    public function verHorarioPorCurso($carrera_id, $curso_id)
    {
        $horarios = Horario::with('aula', 'asignacionDocente.materia', 'asignacionDocente.docente')
            ->where('carrera_id', $carrera_id)
            ->where('curso_id', $curso_id)
            ->get();

        $bloques = [
            '07:30-08:20', '08:20-09:10', '09:10-10:00',
            '10:30-11:20', '11:20-12:10', '12:10-13:00',
            '14:30-15:20', '15:20-16:10', '16:10-17:00',
            '17:30-18:20', '18:20-19:10', '19:10-20:00'
        ];

        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        return view('horarios.grid', compact('horarios', 'dias', 'bloques', 'carrera_id', 'curso_id'));
    }

    public function formSeleccion()
    {
        $carreras = Carrera::all();
        $cursos = Curso::all();

        return view('horarios.seleccionar', compact('carreras', 'cursos'));
    }

    public function exportarPDF($carrera_id, $curso_id)
    {
        $horarios = Horario::with('aula', 'asignacionDocente.materia', 'asignacionDocente.docente')
            ->where('carrera_id', $carrera_id)
            ->where('curso_id', $curso_id)
            ->get();

        $bloques = [
            '07:30-08:20', '08:20-09:10', '09:10-10:00',
            '10:30-11:20', '11:20-12:10', '12:10-13:00',
            '14:30-15:20', '15:20-16:10', '16:10-17:00',
            '17:30-18:20', '18:20-19:10', '19:10-20:00'
        ];

        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        $pdf = Pdf::loadView('horarios.pdf', compact('horarios', 'dias', 'bloques'));
        return $pdf->download('horario_carrera_'.$carrera_id.'_curso_'.$curso_id.'.pdf');
    }

    public function exportarExcel($carrera_id, $curso_id)
    {
        return Excel::download(new HorarioExport($carrera_id, $curso_id), 'horario_carrera_'.$carrera_id.'_curso_'.$curso_id.'.xlsx');
    }
}
