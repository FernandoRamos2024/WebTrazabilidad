<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ReportesEstante;
use App\Models\ReportesMaquinado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProyectoRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:acceder-admin-ventas')->except(['index', 'show', 'mostrarTablaProyectos', 'filtrar']);
    }

    public function filtrar(Request $request)
    {
        $request->session()->put('codigo_proyecto', $request->codigo_proyecto);
        $request->session()->put('empresa', $request->empresa);
        $request->session()->put('estatus', $request->estatus);
        $request->session()->put('fecha_desde', $request->fecha_desde);
        $request->session()->put('fecha_hasta', $request->fecha_hasta);

        return redirect()->route('proyectos.index');
    }

    /**
     * Display a listing of the resource.
     */

     public function home(): View
    {
        $proyectos = Proyecto::all();
        return view('welcome', compact('proyectos'));
    }


    public function index(Request $request): View
    {
        $codigo_proyecto = $request->input('codigo_proyecto');
        $empresa = $request->input('empresa');
        $estatus = $request->input('estatus');
        $fecha_desde = $request->input('fecha_desde');
        $fecha_hasta = $request->input('fecha_hasta');

        $query = Proyecto::query();

        if ($codigo_proyecto) {
            $query->where('codigo_proyecto', 'LIKE', '%' . $codigo_proyecto . '%');
        }

        if ($empresa) {
            $query->where('empresa', 'LIKE', '%' . $empresa . '%');
        }

        if ($estatus) {
            $query->where('estatus', $estatus);
        }

        if ($fecha_desde && $fecha_hasta) {
            $query->whereBetween('fecha_entrega', [$fecha_desde, $fecha_hasta]);
        } elseif ($fecha_desde) {
            $query->where('fecha_entrega', '>=', $fecha_desde);
        } elseif ($fecha_hasta) {
            $query->where('fecha_entrega', '<=', $fecha_hasta);
        }

        $proyectos = $query->get();

        return view('modules.proyecto.index', compact('proyectos', 'codigo_proyecto', 'empresa', 'estatus', 'fecha_desde', 'fecha_hasta'))
            ->with('i');
    }

    public function mostrarTablaProyectos(Request $request): View
    {
        $mostrarProyectos = Proyecto::where('estatus', 'activo')->paginate();

        return view('index', compact('mostrarProyectos'))
            ->with('i', ($request->input('page', 1) - 1) * $mostrarProyectos->perPage());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $proyecto = new Proyecto();
        $estatusOptions = ['activo', 'cancelado', 'entregado']; // Ejemplo de opciones de estatus

        return view('modules.proyecto.create', compact('proyecto', 'estatusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProyectoRequest $request): RedirectResponse
    {
        $input = $request->all();

        // Manejo de la imagen, si existe
        if ($imagen = $request->file('imagen')) {
            // Almacenar la imagen en la carpeta storage/app/public/images/projects
            $profileImage = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $path = $imagen->storeAs('images/projects', $profileImage, 'public');
            $input['imagen'] = $path; // Guardar la ruta de la imagen en la base de datos
        }

        Proyecto::create($input);

        notify()->success('Proyecto creado exitosamente.', 'Creado');
        return Redirect::route('proyectos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $proyecto = Proyecto::find($id);

        return view('modules.proyecto.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $proyecto = Proyecto::findOrFail($id);
        $estatusOptions = ['activo', 'cancelado', 'entregado']; // Ejemplo de opciones de estatus


        return view('modules.proyecto.edit', compact('proyecto', 'estatusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProyectoRequest $request, Proyecto $proyecto): RedirectResponse
    {
    
        $input = $request->all();

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $profileImage = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $path = $imagen->storeAs('images/projects', $profileImage, 'public');

            // Eliminar imagen anterior si existe
            if ($proyecto->imagen) {
                Storage::disk('public')->delete($proyecto->imagen);
            }

            $input['imagen'] = $path;
        } else {
            unset($input['imagen']);
        }

        $proyecto->update($input);

        notify()->success('Proyecto actualizado exitosamente.', 'Actualizado');
        return Redirect::route('proyectos.index');
    }

    public function destroy($id): RedirectResponse
    {
        try {
            $proyecto = Proyecto::findOrFail($id);
            $proyecto->delete();
    
            notify()->success('Proyecto eliminado exitosamente.', 'Eliminado');
            return Redirect::route('proyectos.index');
            
        } catch (\Exception $e) {
            
            notify()->error('Error al eliminar proyecto.', 'Error');
            return Redirect::route('proyectos.index');
        }
    }

    public function seguimiento($codigo_proyecto)
    {
        // Definir modelos para maquinado y estante
        $modelos = [
            'maquinado' => ReportesMaquinado::class,
            'estante' => ReportesEstante::class
        ];

        // Obtener los reportes de cada modelo
        $reportes = collect();
        foreach ($modelos as $tipo => $modelo) {
            $reportes = $reportes->merge($modelo::where('codigo_proyecto', $codigo_proyecto)->get());
        }

        // Combinar y ordenar los resultados por fecha y hora
        $reportes = $reportes->map(function ($reporte) {
            $reporte->fecha_hora = $reporte->fecha . ' ' . $reporte->hora;
            return $reporte;
        })->sortBy('fecha_hora');

        return view('modules.proyecto.seguimiento', compact('reportes', 'codigo_proyecto'));
    }
}
