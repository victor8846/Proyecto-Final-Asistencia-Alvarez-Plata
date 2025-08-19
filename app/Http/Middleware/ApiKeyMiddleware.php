<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Obtener la API Key del header
        $apiKey = $request->header('X-API-KEY');
        Log::info('API KEY recibida: ' . $apiKey);

        // Comparar con la API Key definida en .env
        $expectedKey = env('API_KEY', ''); // Valor por defecto vacío

        if (!$apiKey || $apiKey !== $expectedKey) {
            return response()->json([
                'error' => 'Unauthorized - API Key inválida'
            ], 401);
        }

        return $next($request);
    }
}
