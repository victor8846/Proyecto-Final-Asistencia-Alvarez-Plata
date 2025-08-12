<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
{
    $apiKey = $request->header('X-API-KEY');
    \Log::info('API KEY recibida: ' . $apiKey);

    if ($apiKey !== env('API_KEY')) {
    return response()->json(['error' => 'Unauthorized - API Key inválida'], 401);
}

    return $next($request);
}

}
