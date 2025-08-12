<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X_API_KEY');

        if ($apiKey !== 'INCOS2025') {
            return response()->json(['error' => 'Unauthorized - API Key inválida'], 401);
        }

        return $next($request);
    }
}
