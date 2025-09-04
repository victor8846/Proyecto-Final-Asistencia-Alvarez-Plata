<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aula;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aulas = Aula::all();
        return view('aulas.index', compact('aulas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aulas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar que el nombre del aula sea único
            $request->validate([
                'nombre' => 'required|unique:aulas,nombre'
            ], [
                'nombre.required' => 'El nombre del aula es obligatorio',
                'nombre.unique' => 'El aula ya existe en el sistema. Por favor, ingrese un nombre diferente.'
            ]);

            Aula::create($request->all());
            return redirect()->route('aulas.index')
                ->with('success', 'Aula registrada correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)
                        ->withInput()
                        ->with('error', 'No se pudo registrar el aula. Por favor, revise los errores.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $aula = Aula::findOrFail($id);  // <== Obtener el aula por id
        return view('aulas.edit', compact('aula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $aula = Aula::findOrFail($id);
            
            // Validar que el nombre del aula sea único excepto para el registro actual
            $request->validate([
                'nombre' => 'required|unique:aulas,nombre,' . $id
            ], [
                'nombre.required' => 'El nombre del aula es obligatorio',
                'nombre.unique' => 'Ya existe otra aula con este nombre. Por favor, elija un nombre diferente.'
            ]);

            $aula->update($request->all());
            return redirect()->route('aulas.index')
                ->with('success', 'Aula actualizada correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)
                        ->withInput()
                        ->with('error', 'No se pudo actualizar el aula. Por favor, revise los errores.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $aula = Aula::findOrFail($id);  // <== Obtener el aula antes de eliminar
        $aula->delete();
        return redirect()->route('aulas.index')->with('success', 'Aula eliminada correctamente');
    }
}
