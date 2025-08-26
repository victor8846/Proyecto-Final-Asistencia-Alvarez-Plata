<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está autenticado
        if ($user = Auth::user()) {
            // Verificar si debe cambiar la contraseña por primera vez
            if ($user->must_change_password) {
                return redirect()->route('password.change')
                    ->with('message', 'Por favor, cambia tu contraseña para continuar.');
            }
            
            // Verificar si han pasado 3 meses desde el último cambio
            if ($user->password_changed_at) {
                $threeMonthsAgo = Carbon::now()->subMonths(3);
                if (Carbon::parse($user->password_changed_at)->lt($threeMonthsAgo)) {
                    return redirect()->route('password.change')
                        ->with('message', 'Han pasado 3 meses desde tu último cambio de contraseña. Por favor, cámbiala para continuar.');
                }
            }
        }

        return $next($request);
    }
}
