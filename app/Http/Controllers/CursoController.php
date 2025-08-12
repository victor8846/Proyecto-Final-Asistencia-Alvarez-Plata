<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Carrera;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $query = Curso::with('carrera');

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('paralelo')) {
            $query->where('paralelo', 'like', '%' . $request->paralelo . '%');
        }

        if ($request->filled('carrera_id')) {
            $query->where('carrera_id', $request->carrera_id);
        }

        $cursos = $query->orderBy('nombre', 'asc')->get();
        $carreras = Carrera::orderBy('nombre')->get();

        return view('cursos.index', compact('cursos', 'carreras'));
    }

    public function create()
    {
        $curso = new Curso();
        $carreras = Carrera::orderBy('nombre', 'asc')->get();
        return view('cursos.create', compact('curso', 'carreras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'paralelo' => 'nullable|string|max:100',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        Curso::create($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente.');
    }

    public function edit(Curso $curso)
    {
        $carreras = Carrera::orderBy('nombre', 'asc')->get();
        return view('cursos.edit', compact('curso', 'carreras'));
    }

    public function update(Request $request, Curso $curso)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'paralelo' => 'nullable|string|max:100',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        $curso->update($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado correctamente.');
    }
    public function porCarrera($carrera_id)
{
    $cursos = Curso::where('carrera_id', $carrera_id)->get();
    return response()->json($cursos);
    return response()->json(Curso::where('carrera_id', $id)->get());
}

}
