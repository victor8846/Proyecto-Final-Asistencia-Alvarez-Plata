<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Carrera;
use PDF; // dompdf
use Maatwebsite\Excel\Facades\Excel; // Excel export
use App\Exports\MateriasExport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener filtro carrera_id (opcional)
        $carreraId = $request->get('carrera_id');

        // Consulta base con relación carrera
        $query = Materia::with('carrera');

        if ($carreraId) {
            $query->where('carrera_id', $carreraId);
        }

        // Obtener materias paginadas
        $materias = $query->orderBy('nombre')->paginate(10);

        // Obtener carreras para filtro
        $carreras = Carrera::orderBy('nombre')->get();

        return view('materias.index', compact('materias', 'carreras'));
    }

    public function create()
    {
        $carreras = Carrera::orderBy('nombre')->get();
        return view('materias.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('materias')->where(function ($query) use ($request) {
                    return $query->where('nombre', $request->nombre)
                                 ->where('carrera_id', $request->carrera_id);
                }),
            ],
            'carrera_id' => 'required|exists:carreras,id',
        ], [
            'nombre.unique' => 'Esta materia ya existe en la carrera seleccionada.',
        ]);

        Materia::create($request->only('nombre', 'carrera_id'));

        return redirect()->route('materias.index')->with('success', 'Materia registrada correctamente.');
    }

    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        $carreras = Carrera::orderBy('nombre')->get();
        return view('materias.edit', compact('materia', 'carreras'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('materias')->where(function ($query) use ($request) {
                    return $query->where('nombre', $request->nombre)
                                 ->where('carrera_id', $request->carrera_id);
                })->ignore($materia->id),
            ],
            'carrera_id' => 'required|exists:carreras,id',
        ], [
            'nombre.unique' => 'Esta materia ya existe en la carrera seleccionada.',
        ]);

        $materia->update($request->only('nombre', 'carrera_id'));

        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();
        return redirect()->route('materias.index')->with('success', 'Materia eliminada correctamente.');
    }

    public function porCarrera($carrera_id)
    {
        $materias = Materia::where('carrera_id', $carrera_id)->get();
        return response()->json($materias);
    }

    // Exportar PDF
    public function exportarPDF(Request $request)
    {
        $query = Materia::with('carrera');

        if ($request->filled('carrera_id')) {
            $query->where('carrera_id', $request->carrera_id);
        }

        $materias = $query->get();

        $pdf = PDF::loadView('materias.pdf', compact('materias'));
        return $pdf->download('materias.pdf');
    }

    // Exportar Excel
    public function exportarExcel(Request $request)
    {
        return Excel::download(new MateriasExport($request->carrera_id), 'materias.xlsx');
    }
}
