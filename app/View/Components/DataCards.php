<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DataCards extends Component
{
    public $salidasEstante;
    public $salidasMaquinado;
    public $revisarRegistros;
    public $numeroProyectos;

    /**
     * Create a new component instance.
     */
    public function __construct($salidasEstante = 0, $salidasMaquinado = 0, $revisarRegistros = 0, $numeroProyectos = 0)
    {
        $this->salidasEstante = $salidasEstante;
        $this->salidasMaquinado = $salidasMaquinado;
        $this->revisarRegistros = $revisarRegistros;
        $this->numeroProyectos = $numeroProyectos;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.data-cards');
    }
}
