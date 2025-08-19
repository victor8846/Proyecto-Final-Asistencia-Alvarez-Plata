<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NfcLectura;

class NfcController extends Controller
{
    // Dispositivo registra una lectura (o la actualiza) -> confirmado = false
    public function registrarLectura(Request $request)
    {
        // Seguridad sencilla por API-KEY
        if ($request->header('X-API-KEY') !== config('services.nfc.api_key')) {
            return response()->json(['message' => 'API KEY inválida'], 401);
        }

        $validated = $request->validate([
            'uid_nfc' => 'required|string|max:191',
            'lector'  => 'nullable|string|max:191',
        ]);

        $lectura = NfcLectura::updateOrCreate(
            ['uid_nfc' => $validated['uid_nfc']],     // usa el nombre de campo correcto
            ['lector' => $validated['lector'] ?? null, 'confirmado' => false]
        );

        return response()->json([
            'id' => $lectura->id,
            'uid_nfc' => $lectura->uid_nfc,
            'confirmado' => (bool)$lectura->confirmado,
        ]);
    }

    // Último UID no confirmado
    public function ultimo()
    {
        $lectura = NfcLectura::where('confirmado', false)->latest('id')->first();

        if (!$lectura) {
            return response()->json(['id' => null, 'uid_nfc' => null]);
        }

        return response()->json([
            'id' => $lectura->id,
            'uid_nfc' => $lectura->uid_nfc
        ]);
    }

    // Confirma la lectura (la “bloquea” para usarla en el formulario actual)
    public function confirmar(Request $request)
    {
        if ($request->header('X-API-KEY') !== config('services.nfc.api_key')) {
            return response()->json(['message' => 'API KEY inválida'], 401);
        }

        $validated = $request->validate([
            'id' => 'required|integer'
        ]);

        $lectura = NfcLectura::find($validated['id']);

        if (!$lectura) {
            return response()->json(['message' => 'Lectura no encontrada'], 404);
        }

        if ($lectura->confirmado) {
            return response()->json(['message' => 'Esta lectura ya fue confirmada'], 409);
        }

        $lectura->confirmado = true;
        $lectura->save();

        return response()->json(['message' => 'UID confirmado correctamente']);
    }
}
