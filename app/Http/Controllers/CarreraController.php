<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;

class CarreraController extends Controller
{
    /**
     * Mostrar la lista de carreras.
     */
    public function index()
    {
        $carreras = Carrera::all();
        return view('carreras.index', compact('carreras'));
    }

    /**
     * Mostrar el formulario para crear una nueva carrera.
     */
    public function create()
    {
        return view('carreras.create');
    }

    /**
     * Guardar una nueva carrera.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Carrera::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('carreras.index')->with('success', 'Carrera creada correctamente.');
    }

    /**
     * Mostrar el formulario para editar una carrera existente.
     */
    public function edit($id)
    {
        $carrera = Carrera::findOrFail($id);
        return view('carreras.edit', compact('carrera'));
    }

    /**
     * Actualizar una carrera existente.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $carrera = Carrera::findOrFail($id);
        $carrera->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('carreras.index')->with('success', 'Carrera actualizada correctamente.');
    }

    /**
     * Eliminar una carrera.
     */
    public function destroy($id)
    {
        $carrera = Carrera::findOrFail($id);
        $carrera->delete();

        return redirect()->route('carreras.index')->with('success', 'Carrera eliminada correctamente.');
    }
}
