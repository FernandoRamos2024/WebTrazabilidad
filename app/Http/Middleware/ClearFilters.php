<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearFilters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('clear_filters') && $request->query('clear_filters') == 'true') {
            $request->session()->forget([
                'codigo_proyecto',
                'codigo_partida',
                'accion',
                'estatus',
                'fecha_desde',
                'fecha_hasta',
                'nombre_area',
                'nombre_operador',
                'nombre_estante',
                'empresa'
            ]);
        }

        return $next($request);
    }
}
