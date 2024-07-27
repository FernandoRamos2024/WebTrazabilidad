<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckAdminOrVentas
{
    /**
     * Handle an incoming request.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && (Auth::user()->role == User::ROLE_ADMINISTRADOR || Auth::user()->role == User::ROLE_VENTAS)) {
            return $next($request);
        }
        
        abort(403, 'Acción no autorizada.');
    }
}
