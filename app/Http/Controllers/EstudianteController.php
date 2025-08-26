<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Carrera;
use App\Models\Curso;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstudianteController extends Controller
{
    // Listar estudiantes con filtros
    public function index(Request $request)
    {
        $query = Estudiante::with(['curso', 'carrera']);

        if ($request->filled('curso')) {
            $query->where('curso_id', $request->curso);
        }

        if ($request->filled('carrera')) {
            $query->where('carrera_id', $request->carrera);
        }

        $estudiantes = $query->paginate(10);
        $cursos = Curso::orderBy('nombre')->get();
        $carreras = Carrera::orderBy('nombre')->get();

        return view('estudiantes.index', compact('estudiantes', 'cursos', 'carreras'));
    }

    // Mostrar formulario para crear estudiante
    public function create()
    {
        $estudiante = new Estudiante();
        $carreras = Carrera::orderBy('nombre', 'asc')->get();
        $cursos = Curso::orderBy('nombre', 'asc')->get();

        return view('estudiantes.create', compact('estudiante', 'carreras', 'cursos'));
    }

    // Guardar estudiante nuevo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'ci' => 'required|string|max:20|unique:estudiantes,ci',
            'uid_nfc' => 'nullable|string|max:20|unique:estudiantes,uid_nfc',
            'email' => 'nullable|email|max:100',
            'curso_id' => 'required|exists:cursos,id',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        $data = $request->all();

        $data['nombre'] = ucfirst(strtolower($data['nombre']));
        $data['apellido_paterno'] = ucfirst(strtolower($data['apellido_paterno']));
        $data['apellido_materno'] = ucfirst(strtolower($data['apellido_materno']));

        Estudiante::create($data);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante registrado correctamente.');
    }

    // Mostrar formulario para editar estudiante
    public function edit(Estudiante $estudiante)
    {
        $carreras = Carrera::orderBy('nombre', 'asc')->get();
        $cursos = Curso::orderBy('nombre', 'asc')->get();

        return view('estudiantes.edit', compact('estudiante', 'carreras', 'cursos'));
    }

    // Actualizar estudiante existente
    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'ci' => 'required|string|max:20|unique:estudiantes,ci,' . $estudiante->id,
            'uid_nfc' => 'nullable|string|max:20|unique:estudiantes,uid_nfc,' . $estudiante->id,
            'email' => 'nullable|email|max:100',
            'curso_id' => 'required|exists:cursos,id',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        $data = $request->all();

        $data['nombre'] = ucfirst(strtolower($data['nombre']));
        $data['apellido_paterno'] = ucfirst(strtolower($data['apellido_paterno']));
        $data['apellido_materno'] = ucfirst(strtolower($data['apellido_materno']));

        $estudiante->update($data);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado correctamente.');
    }

    // Eliminar estudiante
    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado correctamente.');
    }

    // Reporte resumen estudiantes por carrera
    public function resumenPorCarrera()
    {
        $datos = DB::table('estudiantes')
            ->join('carreras', 'estudiantes.carrera_id', '=', 'carreras.id')
            ->select('carreras.nombre as carrera', DB::raw('count(*) as total'))
            ->groupBy('carreras.nombre')
            ->get();

        return view('reportes.estudiantes_por_carrera', compact('datos'));
    }

    // Mostrar materias y aulas asignadas al estudiante
    public function verMateriasAsignadas($id)
    {
        $estudiante = Estudiante::findOrFail($id);

        $horarios = Horario::with([
            'asignacionDocente.materia',
            'asignacionDocente.docente',
            'aula'
        ])
            ->where('carrera_id', $estudiante->carrera_id)
            ->where('curso_id', $estudiante->curso_id)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        // Ordenar los días manualmente si es necesario
        $diasOrden = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        $horarios = $horarios->sortBy(function ($horario) use ($diasOrden) {
            return array_search($horario->dia, $diasOrden);
        });

        return view('estudiantes.materias_asignadas', compact('estudiante', 'horarios'));
    }
}
