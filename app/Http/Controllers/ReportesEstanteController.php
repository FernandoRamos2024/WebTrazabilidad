<?php

namespace App\Http\Controllers;

use App\Models\ReportesEstante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ReportesEstanteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Estante;

class ReportesEstanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:acceder-admin-ventas')->except(['index', 'show', 'addRevision', 'filtrar']);
    }

    public function filtrar(Request $request)
    {
        $request->session()->put('codigo_proyecto', $request->codigo_proyecto);
        $request->session()->put('codigo_partida', $request->codigo_partida);
        $request->session()->put('accion', $request->accion);
        $request->session()->put('estatus', $request->estatus);
        $request->session()->put('fecha_desde', $request->fecha_desde);
        $request->session()->put('fecha_hasta', $request->fecha_hasta);
        $request->session()->put('nombre_estante', $request->nombre_estante);

        return redirect()->route('reportes-estantes.index');
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
        $nombre_estante = $request->input('nombre_estante');

        $query = ReportesEstante::with('estante');

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

        if ($nombre_estante) {
            $query->whereHas('estante', function($query) use ($nombre_estante) {
                $query->where('nombre', 'LIKE', '%' . $nombre_estante . '%');
            });
        }

        $reportesEstantes = $query->get();

        return view('modules.reportes-estante.index', compact('reportesEstantes', 'codigo_proyecto', 'codigo_partida', 'accion', 'estatus', 'fecha_desde', 'fecha_hasta', 'nombre_estante'))
            ->with('i');
    }

    public function registrosPorRevisar(Request $request): View
    {
        $codigo_proyecto = $request->input('codigo_proyecto');
        $codigo_partida = $request->input('codigo_partida');
        $accion = $request->input('accion');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');
        $nombre_estante = $request->input('nombre_estante');

        $query = ReportesEstante::with('estante')->where('estatus', 'revisar');

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

        if ($nombre_estante) {
            $query->whereHas('estante', function($query) use ($nombre_estante) {
                $query->where('nombre', 'LIKE', '%' . $nombre_estante . '%');
            });
        }

        $reportesEstantes = $query->get();

        return view('modules.reportes-estante.revisar', compact('reportesEstantes', 'codigo_proyecto', 'codigo_partida', 'accion', 'fecha_desde', 'fecha_hasta', 'nombre_estante'))
            ->with('i');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estantes = Estante::all();
        $acciones = ['entrada', 'salida'];
        $estatuses = ['conforme', 'no conforme', 'revisar'];

        $reportesEstante = new ReportesEstante();

        return view('modules.reportes-estante.create', compact('reportesEstante', 'estantes', 'acciones', 'estatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportesEstanteRequest $request): RedirectResponse
    {
        ReportesEstante::create($request->validated());

        notify()->success('Registro estante creado exitosamente.', 'Creado');
        return Redirect::route('reportes-estantes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $reportesEstante = ReportesEstante::with('estante')->findOrFail($id);
    
        return view('modules.reportes-estante.show', compact('reportesEstante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $reportesEstante = ReportesEstante::find($id);

        $estantes = Estante::all();
        $acciones = ['entrada', 'salida'];
        $estatuses = ['conforme', 'no conforme', 'revisar'];

        return view('modules.reportes-estante.edit', compact('reportesEstante', 'estantes', 'acciones', 'estatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReportesEstanteRequest $request, ReportesEstante $reportesEstante): RedirectResponse
    {
        try {
            $reportesEstante->update($request->validated());
    
            notify()->success('Registro estante actualizado exitosamente.', 'Actualizado');
            return Redirect::route('reportes-estantes.index');
            
        } catch (\Exception $e) {
    
            notify()->error('Error al actualizar registro estante.', 'Error');
            return Redirect::route('reportes-estantes.index');
            
        }
    }

    public function addRevision(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'revision' => 'required|string',
                'estatus' => 'required|string',
            ]);
    
            // Buscar el reporte maquinado por su ID
            $reportesEstante = ReportesEstante::find($request->id);
    
            if (!$reportesEstante) {
                notify()->error('Reporte estante no encontrado.', 'Error');
                return redirect()->route('reportes-estantes.index');
            }
    
            // Actualizar los campos del reporte maquinado
            $reportesEstante->estatus = $validatedData['estatus'];
            $reportesEstante->revision = $validatedData['revision'];
            $reportesEstante->save();
    
            notify()->success('Revisión solicitada exitosamente.', 'Solicitada');
            return redirect()->route('reportes-estantes.index');
            
        } catch (\Exception $e) {
    
            notify()->error('Error al solicitar revisión.', 'Error');
            return redirect()->route('reportes-estantes.index');
            
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            ReportesEstante::find($id)->delete();
    
            notify()->success('Registro estante eliminado exitosamente.', 'Eliminado');
            return Redirect::route('reportes-estantes.index');
            
        } catch (\Exception $e) {
            
            notify()->error('Error al eliminar registro estante.', 'Error');
            return Redirect::route('reportes-estantes.index');
        }
    }
}
