<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\ApiKeyMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias para middlewares de rutas
        $middleware->alias([
            'role' => CheckRole::class,
            'api.key' => ApiKeyMiddleware::class,  // aquí el alias
        ]);

        // Middleware global (opcional) para CORS
        $middleware->append(HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
