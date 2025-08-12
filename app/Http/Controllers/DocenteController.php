<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Carrera;
use App\Models\Materia;

class DocenteController extends Controller
{
    public function index(Request $request)
    {
        $query = Docente::query();

        // Filtrado por nombre (busca en nombre completo)
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtrado por carrera
        if ($request->filled('carrera')) {
            $query->where('carrera_id', $request->carrera);
        }

        // Filtrado por materia (relación)
        if ($request->filled('materia')) {
            $query->whereHas('materia', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->materia . '%');
            });
        }

        // Filtrado por docente_id (select)
        if ($request->filled('docente_id')) {
            $query->where('id', $request->docente_id);
        }

        // Obtiene paginados los docentes filtrados
        $docentes = $query->paginate(10)->withQueryString();

        // Para llenar el select de docentes y carreras
        $docentesList = Docente::all();
        $carreras = Carrera::all();
        $materias = Materia::all();

        return view('docentes.index', [
            'docentes' => $docentes,
            'docentesList' => $docentesList,
            'carreras' => $carreras,
            'materias' => $materias,
        ]);
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
        $validated = $request->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'ci' => 'required|unique:docentes,ci',
            'email' => 'nullable|email',
            'materia_id' => 'required|exists:materias,id',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        Docente::create($validated);

        return redirect()->route('docentes.index')->with('success', 'Docente creado con éxito.');
    }

    public function edit(Docente $docente)
    {
        $carreras = Carrera::all();
        $materias = Materia::all();
        return view('docentes.edit', compact('docente', 'carreras', 'materias'));
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'ci' => 'required|string|max:20|unique:docentes,ci,' . $docente->id,
            'email' => 'nullable|email|max:100',
            'materia_id' => 'required|exists:materias,id',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        $docente->update($request->all());

        return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        return redirect()->route('docentes.index')->with('success', 'Docente eliminado correctamente.');
    }
}
