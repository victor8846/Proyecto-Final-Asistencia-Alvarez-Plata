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
        Aula::create($request->all());
        return redirect()->route('aulas.index')->with('success', 'Aula registrada correctamente');
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
        $aula = Aula::findOrFail($id);  // <== Obtener el aula antes de actualizar
        $aula->update($request->all());
        return redirect()->route('aulas.index')->with('success', 'Aula actualizada correctamente');
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
