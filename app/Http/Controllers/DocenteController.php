<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Carrera;
use App\Models\Materia;
use Illuminate\Validation\ValidationException;

class DocenteController extends Controller
{
    public function index(Request $request)
    {
        $query = Docente::query();

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('carrera')) {
            $query->where('carrera_id', $request->carrera);
        }

        if ($request->filled('materia')) {
            $query->whereHas('materia', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->materia . '%');
            });
        }

        if ($request->filled('docente_id')) {
            $query->where('id', $request->docente_id);
        }

        $docentes = $query->paginate(10)->withQueryString();
        $docentesList = Docente::all();
        $carreras = Carrera::all();
        $materias = Materia::all();

        return view('docentes.index', compact('docentes', 'docentesList', 'carreras', 'materias'));
    }

    public function create()
    {
        $docente = new Docente();
        $carreras = Carrera::all();
        $materias = Materia::all();
        return view('docentes.create', compact('docente', 'carreras', 'materias'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required',
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'ci' => 'required|unique:docentes,ci',
                'email' => 'nullable|email|unique:docentes,email',
                'materia_id' => 'required|exists:materias,id',
                'carrera_id' => 'required|exists:carreras,id',
            ], [
                'nombre.required' => 'El nombre del docente es obligatorio',
                'apellido_paterno.required' => 'El apellido paterno es obligatorio',
                'apellido_materno.required' => 'El apellido materno es obligatorio',
                'ci.required' => 'El CI es obligatorio',
                'ci.unique' => 'Ya existe un docente registrado con este CI',
                'email.unique' => 'Ya existe un docente registrado con este correo electrónico',
                'email.email' => 'El formato del correo electrónico no es válido',
                'materia_id.required' => 'Debe seleccionar una materia',
                'carrera_id.required' => 'Debe seleccionar una carrera'
            ]);

            Docente::create($validated);
            return redirect()->route('docentes.index')
                ->with('success', 'Docente registrado correctamente.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'No se pudo registrar el docente. Por favor, revise los errores.');
        }
    }

    public function edit(Docente $docente)
    {
        $carreras = Carrera::all();
        $materias = Materia::all();
        return view('docentes.edit', compact('docente', 'carreras', 'materias'));
    }

    public function update(Request $request, Docente $docente)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'apellido_paterno' => 'required|string|max:100',
                'apellido_materno' => 'required|string|max:100',
                'ci' => 'required|string|max:20|unique:docentes,ci,' . $docente->id,
                'email' => 'nullable|email|max:100|unique:docentes,email,' . $docente->id,
                'materia_id' => 'required|exists:materias,id',
                'carrera_id' => 'required|exists:carreras,id',
            ], [
                'nombre.required' => 'El nombre del docente es obligatorio',
                'apellido_paterno.required' => 'El apellido paterno es obligatorio',
                'apellido_materno.required' => 'El apellido materno es obligatorio',
                'ci.required' => 'El CI es obligatorio',
                'ci.unique' => 'Ya existe otro docente registrado con este CI',
                'email.unique' => 'Ya existe otro docente registrado con este correo electrónico',
                'email.email' => 'El formato del correo electrónico no es válido',
                'materia_id.required' => 'Debe seleccionar una materia',
                'carrera_id.required' => 'Debe seleccionar una carrera'
            ]);

            $docente->update($validated);
            return redirect()->route('docentes.index')
                ->with('success', 'Docente actualizado correctamente.');
        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'No se pudo actualizar el docente. Por favor, revise los errores.');
        }
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado correctamente.');
    }
}
