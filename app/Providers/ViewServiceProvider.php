<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\ReportesEstante;
use App\Models\ReportesMaquinado;
use App\Models\Proyecto;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('components.data-cards', function ($view) {
            $salidasEstante = ReportesEstante::where('accion', 'salida')->count() ?? 0;
            $salidasMaquinado = ReportesMaquinado::where(function($query) {
                $query->where('accion', 'turno terminado')
                      ->orWhere('accion', 'pieza terminada');
            })->count() ?? 0;
            $revisarEstante = ReportesEstante::where('estatus', 'revisar')->count() ?? 0;
            $revisarMaquinado = ReportesMaquinado::where('estatus', 'revisar')->count() ?? 0;
            $revisarRegistros = ($revisarEstante + $revisarMaquinado) ?? 0;
            $numeroProyectos = Proyecto::count() ?? 0;

            $view->with(compact('salidasEstante', 'salidasMaquinado', 'revisarRegistros', 'numeroProyectos'));
        });
    }
}
