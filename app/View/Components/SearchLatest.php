<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\ReportesMaquinado;
use App\Models\ReportesEstante;

class SearchLatest extends Component
{
    /**
     * Create a new component instance.
     */
    public $codigo;
    public $reporteReciente;
    public $tipoReporte;

    public function __construct($codigo = null)
    {
        //
        $this->codigo = $codigo;
        $this->reporteReciente = null;
        $this->tipoReporte = null;

        if ($codigo) {
            $this->buscarRegistroMasReciente($codigo);
        }
    }

    public function buscarRegistroMasReciente($codigo)
    {
        // Buscar en la tabla reportes_maquinado
        $reporteMaquinado = ReportesMaquinado::where('codigo_proyecto', $codigo)
            ->orWhere('codigo_partida', $codigo)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->first();

        // Buscar en la tabla reportes_estante
        $reporteEstante = ReportesEstante::where('codigo_proyecto', $codigo)
            ->orWhere('codigo_partida', $codigo)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->first();

        // Comparar las fechas y horas y obtener el registro más reciente
        if ($reporteMaquinado && $reporteEstante) {

            $fechaHoraMaquinado = strtotime($reporteMaquinado->fecha . ' ' . $reporteMaquinado->hora);
            $fechaHoraEstante = strtotime($reporteEstante->fecha . ' ' . $reporteEstante->hora);
            
            if ($fechaHoraMaquinado > $fechaHoraEstante) {
                $this->reporteReciente = $reporteMaquinado;
                $this->tipoReporte = 'maquinado'; // Indicar que es un reporte maquinado
            } else {
                $this->reporteReciente = $reporteEstante;
                $this->tipoReporte = 'estante'; // Indicar que es un reporte estante
            }
        } elseif ($reporteMaquinado) {
            $this->reporteReciente = $reporteMaquinado;
            $this->tipoReporte = 'maquinado'; // Indicar que es un reporte maquinado
        } elseif ($reporteEstante) {
            $this->reporteReciente = $reporteEstante;
            $this->tipoReporte = 'estante'; // Indicar que es un reporte estante
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search-latest');
    }
}
