<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NfcLectura;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class NfcLecturaController extends Controller
{
    // 🔐 Validar API Key
    private function validarApiKey(Request $request)
    {
        $apiKey = $request->header('X-API-KEY');
        if ($apiKey !== 'INCOS2025') {
            return response()->json(['error' => 'Unauthorized - API Key inválida'], 401);
        }
        return null;
    }

    // 📌 Registrar lectura temporal
    public function registrarLectura(Request $request)
    {
        try {
            // ✅ Verificar API KEY desde el header
            if ($resp = $this->validarApiKey($request)) {
                return $resp;
            }

            // ✅ Validar datos del request
            $validator = Validator::make($request->all(), [
                'uid_nfc' => 'required|string',
                'lector' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Log para debug
            Log::info('NFC Lectura - Datos recibidos:', [
                'uid_nfc' => $request->uid_nfc,
                'lector' => $request->lector
            ]);

            // ✅ Verificar si ya existe una lectura pendiente con el mismo UID
            $existente = NfcLectura::where('uid_nfc', $request->uid_nfc)
                                ->where('confirmado', false)
                                ->first();

            if ($existente) {
                return response()->json([
                    'status' => 'warning',
                    'msg' => 'Ya existe una lectura pendiente',
                    'id' => $existente->id,
                    'uid_nfc' => $existente->uid_nfc
                ], 200);
            }

            // ✅ Guardar la nueva lectura
            $lectura = NfcLectura::create([
                'uid_nfc' => $request->uid_nfc,
                'lector' => $request->lector,
                'confirmado' => false
            ]);

            Log::info('NFC Lectura - Registro creado:', [
                'id' => $lectura->id,
                'uid_nfc' => $lectura->uid_nfc
            ]);

            return response()->json([
                'status' => 'OK',
                'id' => $lectura->id,
                'uid_nfc' => $lectura->uid_nfc
            ], 200);
        } catch (\Exception $e) {
            Log::error('NFC Lectura - Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar la lectura NFC'
            ], 500);
        }
}


    // 📌 Confirmar lectura
    public function confirmar(Request $request)
    {
        try {
            if ($resp = $this->validarApiKey($request)) {
                return $resp;
            }

            // Buscar por ID o UID
            $lectura = null;
            if ($request->filled('id')) {
                $lectura = NfcLectura::find($request->id);
            } elseif ($request->filled('uid_nfc')) {
                $lectura = NfcLectura::where('uid_nfc', $request->uid_nfc)
                                    ->where('confirmado', false)
                                    ->first();
            }

            if (!$lectura) {
                return response()->json(['status' => 'error', 'msg' => 'No encontrado'], 404);
            }

            if ($lectura->confirmado) {
                return response()->json(['status' => 'warning', 'msg' => 'Ya estaba confirmado']);
            }

            $lectura->confirmado = true;
            $lectura->save();

            return response()->json(['status' => 'OK', 'uid' => $lectura->uid_nfc]);
        } catch (\Exception $e) {
            Log::error('NFC Confirmación - Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al confirmar la lectura NFC'
            ], 500);
        }
    }

    // 📌 Obtener última lectura
    public function ultimoUid(Request $request)
    {
        try {
            if ($resp = $this->validarApiKey($request)) {
                return $resp;
            }

            $lectura = NfcLectura::where('confirmado', false)
                                ->latest()
                                ->first();

            if (!$lectura) {
                return response()->json(['status' => 'empty']);
            }

            return response()->json([
                'id' => $lectura->id,
                'uid_nfc' => $lectura->uid_nfc
            ]);
        } catch (\Exception $e) {
            Log::error('NFC UltimoUID - Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener la última lectura NFC'
            ], 500);
        }
    }
}
