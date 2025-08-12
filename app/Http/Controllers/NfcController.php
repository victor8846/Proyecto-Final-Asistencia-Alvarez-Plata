<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Estudiante;

class NfcController extends Controller
{
    public function registerUid(Request $request)
    {
        // Validar API KEY
        $apiKey = $request->header('X-API-KEY');
        if ($apiKey !== 'INCOS2025') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validar datos recibidos
        $validated = $request->validate([
            'uid' => 'required|string',
            'tipo_usuario' => 'required|in:docente,estudiante',
            'lector_id' => 'nullable|string',
        ]);

        $uid = $validated['uid'];
        $tipo = $validated['tipo_usuario'];
        $lectorId = $validated['lector_id'] ?? null;

        // Aquí asumimos que las tablas docentes y estudiantes tienen columna "uid_nfc"
        if ($tipo === 'docente') {
            $docente = Docente::updateOrCreate(
                ['uid_nfc' => $uid],
                ['ultimo_lector' => $lectorId, 'fecha_registro' => now()]
            );
            return response()->json(['mensaje' => 'Docente registrado', 'data' => $docente], 200);
        }

        if ($tipo === 'estudiante') {
            $estudiante = Estudiante::updateOrCreate(
                ['uid_nfc' => $uid],
                ['ultimo_lector' => $lectorId, 'fecha_registro' => now()]
            );
            return response()->json(['mensaje' => 'Estudiante registrado', 'data' => $estudiante], 200);
        }

        return response()->json(['error' => 'Tipo de usuario inválido'], 400);
    }
}
