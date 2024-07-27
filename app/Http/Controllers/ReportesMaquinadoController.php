<?php

namespace App\Http\Controllers;

use App\Models\ReportesMaquinado;
use App\Models\Area;
use App\Models\User;
use App\Models\Maquina;
use App\Models\Operador;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReportesMaquinadoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ReportesMaquinadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:acceder-admin-ventas')->except(['index', 'show', 'addRevision', 'filtrar', 'buscarRegistroMasReciente']);
    }

    /**
     * Filtros
     */
    public function filtrar(Request $request)
    {
        $request->session()->put('codigo_proyecto', $request->codigo_proyectoM);
        $request->session()->put('codigo_partida', $request->codigo_partidaM);
        $request->session()->put('accion', $request->accionM);
        $request->session()->put('estatus', $request->estatusM);
        $request->session()->put('fecha_desde', $request->fecha_desdeM);
        $request->session()->put('fecha_hasta', $request->fecha_hastaM);
        $request->session()->put('nombre_area', $request->nombre_areaM);
        $request->session()->put('nombre_operador', $request->nombre_operadorM);

        return redirect()->route('reportes-maquinados.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {

        $codigo_proyecto = $request->input('codigo_proyecto');
        $codigo_partida = $request->input('codigo_partida');
        $accion = $request->input('accion');
        $estatus = $request->input('estatus');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');
        $nombre_area = $request->input('nombre_area');
        $nombre_operador = $request->input('nombre_operador');

        $query = ReportesMaquinado::with('area', 'maquina', 'operador');

        if ($codigo_proyecto) {
            $query->where('codigo_proyecto', 'LIKE', '%' . $codigo_proyecto . '%');
        }

        if ($codigo_partida) {
            $query->where('codigo_partida', 'LIKE', '%' . $codigo_partida . '%');
        }

        if ($accion) {
            $query->where('accion', $accion);
        }

        if ($estatus) {
            $query->where('estatus', $estatus);
        }

        if ($fecha_desde && $fecha_hasta) {
            $query->whereBetween('fecha', [$fecha_desde, $fecha_hasta]);
        } elseif ($fecha_desde) {
            $query->where('fecha', '>=', $fecha_desde);
        } elseif ($fecha_hasta) {
            $query->where('fecha', '<=', $fecha_hasta);
        }

        if ($nombre_area) {
            $query->whereHas('area', function($query) use ($nombre_area) {
                $query->where('nombre', 'LIKE', '%' . $nombre_area . '%');
            });
        }

        if ($nombre_operador) {
            $query->whereHas('operador', function($query) use ($nombre_operador) {
                $query->where('nombre', 'LIKE', '%' . $nombre_operador . '%');
            });
        }

        $reportesMaquinados = $query->get();

        return view('modules.reportes-maquinado.index', compact('reportesMaquinados', 'codigo_proyecto', 'codigo_partida', 'accion', 'estatus', 'fecha_desde', 'fecha_hasta', 'nombre_area', 'nombre_operador'))
            ->with('i');
    }

    public function registrosPorRevisar(Request $request)
    {   
        $codigo_proyecto = $request->input('codigo_proyecto');
        $codigo_partida = $request->input('codigo_partida');
        $accion = $request->input('accion');
        $estatus = $request->input('estatus');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');
        $nombre_area = $request->input('nombre_area');
        $nombre_operador = $request->input('nombre_operador');

        $query = ReportesMaquinado::with('area', 'maquina', 'operador')->where('estatus', 'revisar');

        if ($codigo_proyecto) {
            $query->where('codigo_proyecto', 'LIKE', '%' . $codigo_proyecto . '%');
        }

        if ($codigo_partida) {
            $query->where('codigo_partida', 'LIKE', '%' . $codigo_partida . '%');
        }

        if ($accion) {
            $query->where('accion', $accion);
        }

        if ($fecha_desde && $fecha_hasta) {
            $query->whereBetween('fecha', [$fecha_desde, $fecha_hasta]);
        } elseif ($fecha_desde) {
            $query->where('fecha', '>=', $fecha_desde);
        } elseif ($fecha_hasta) {
            $query->where('fecha', '<=', $fecha_hasta);
        }

        if ($nombre_area) {
            $query->whereHas('area', function($query) use ($nombre_area) {
                $query->where('nombre', 'LIKE', '%' . $nombre_area . '%');
            });
        }

        if ($nombre_operador) {
            $query->whereHas('operador', function($query) use ($nombre_operador) {
                $query->where('nombre', 'LIKE', '%' . $nombre_operador . '%');
            });
        }
        
        $reportesPorRevisar = $query->get();

        return view('modules.reportes-maquinado.revisar', compact('reportesPorRevisar', 'codigo_proyecto', 'codigo_partida', 'accion', 'fecha_desde', 'fecha_hasta', 'nombre_area', 'nombre_operador'))
        ->with('i');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $areas = Area::all();
        $maquinas = Maquina::all();
        $operadores = Operador::all();
        
        // Definir las listas de valores para Turno, Acción y Estatus
        $turnos = ['primero', 'segundo'];
        $acciones = ['entrada', 'turno terminado', 'pieza terminada'];
        $estatuses = ['proceso', 'finalizado', 'revisar'];
    
        $reportesMaquinado = new ReportesMaquinado();
    
        return view('modules.reportes-maquinado.create', compact('reportesMaquinado', 'areas', 'maquinas', 'operadores', 'turnos', 'acciones', 'estatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportesMaquinadoRequest $request): RedirectResponse
    {
        ReportesMaquinado::create($request->validated());
    
        notify()->success('Registro maquinado creado exitosamente.', 'Creado');
        return Redirect::route('reportes-maquinados.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $reportesMaquinado = ReportesMaquinado::with('area', 'maquina', 'operador')->findOrFail($id);

        return view('modules.reportes-maquinado.show', compact('reportesMaquinado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $reportesMaquinado = ReportesMaquinado::find($id);
    
        $areas = Area::all();
        $maquinas = Maquina::all();
        $operadores = Operador::all();
        
        // Definir las listas de valores para Turno, Acción y Estatus
        $turnos = ['primero', 'segundo'];
        $acciones = ['entrada', 'turno terminado', 'pieza terminada'];
        $estatuses = ['proceso', 'finalizado', 'revisar'];
    
        return view('modules.reportes-maquinado.edit', compact('reportesMaquinado', 'areas', 'maquinas', 'operadores', 'turnos', 'acciones', 'estatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReportesMaquinadoRequest $request, ReportesMaquinado $reportesMaquinado): RedirectResponse
    {
        try {
            $reportesMaquinado->update($request->validated());
        
            notify()->success('Registro maquinado actualizado exitosamente.', 'Actualizado');
            return Redirect::route('reportes-maquinados.index');
            
        } catch (\Exception $e) {
        
            notify()->error('Error al actualizar registro maquinado.', 'Error');
            return Redirect::route('reportes-maquinados.index');
            
        }
    }

    public function addRevision(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'revision' => 'required|string',
                'estatus' => 'required|string',
            ]);
    
            $reportesMaquinado = ReportesMaquinado::find($request->id);
    
            if (!$reportesMaquinado) {
                notify()->error('Reporte maquinado no encontrado.', 'Error');
                return redirect()->route('reportes-maquinados.index');
            }
    
            $reportesMaquinado->estatus = $validatedData['estatus'];
            $reportesMaquinado->revision = $validatedData['revision'];
            $reportesMaquinado->save();
    
            notify()->success('Revisión solicitada exitosamente.', 'Solicitada');
            return redirect()->route('reportes-maquinados.index');

        } catch (\Exception $e) {
            notify()->error('Error al solicitar revisión.', 'Error');
            return redirect()->route('reportes-maquinados.index');
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            ReportesMaquinado::find($id)->delete();
    
            notify()->success('Registro maquinado eliminado exitosamente.', 'Eliminado');
            return Redirect::route('reportes-maquinados.index');
            
        } catch (\Exception $e) {
    
            notify()->error('Error al eliminar registro maquinado.', 'Error');
            return Redirect::route('reportes-maquinados.index');
            
        }
    }

    public function buscarRegistroMasReciente(Request $request)
    {
        $codigo = $request->input('codigo');
        $rol = Auth::user()->role;

        if (empty($codigo)) {
            notify()->error('Debe ingresar un código para buscar.', 'Error');
            return redirect()->back();
        }

        if($rol == User::ROLE_ADMINISTRADOR) {
            return view('admin.index', compact('codigo'));
        } elseif ($rol == User::ROLE_VENTAS) {
            return view('ventas.index', compact('codigo'));
        } elseif ($rol == User::ROLE_OPERADOR) {
            return view('operador.index', compact('codigo'));   
        }
    }
}
