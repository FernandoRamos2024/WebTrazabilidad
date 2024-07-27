<?php

namespace App\Http\Controllers;

use App\Models\Estante;
use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\EstanteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EstanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:acceder-admin-ventas')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // Cargar la relación area con los estantes
        // $estantes = Estante::with('area')->paginate();
        $nombre = $request->input('nombre');
        $nombre_area = $request->input('nombre_area');

        $query = Estante::with('area');

        if ($nombre) {
            $query->where('nombre', 'LIKE', '%' . $nombre . '%');
        }

        if ($nombre_area) {
            $query->whereHas('area', function($query) use ($nombre_area) {
                $query->where('nombre', 'LIKE', '%' . $nombre_area . '%');
            });
        }

        $estantes = $query->get();

        return view('modules.estante.index', compact('estantes', 'nombre', 'nombre_area'))
            ->with('i');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estante = new Estante();
        $areas = Area::all(); // Obtener todas las áreas

        return view('modules.estante.create', compact('estante', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstanteRequest $request): RedirectResponse
    {
        try {
            Estante::create($request->validated());
    
            notify()->success('Estante creado exitosamente.', 'Creado');
            return Redirect::route('estantes.index');
            
        } catch (\Exception $e) {
            notify()->error('Error al crear estante.', 'Error');
            return Redirect::route('estantes.index');
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $estante = Estante::find($id);
        // Obtener el nombre del área correspondiente al ID
        $area = Area::find($estante->id_area);
        return view('modules.estante.show', compact('estante', 'area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $estante = Estante::find($id);
        $areas = Area::all(); // Obtener todas las áreas

        return view('modules.estante.edit', compact('estante', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstanteRequest $request, Estante $estante): RedirectResponse
    {
        try {
            $estante->update($request->validated());
    
            notify()->success('Estante actualizado exitosamente.', 'Actualizado');
            return Redirect::route('estantes.index');
            
        } catch (\Exception $e) {
            notify()->error('Error al actualizar estante.', 'Error');
            return Redirect::route('estantes.index');
            
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            Estante::find($id)->delete();
    
            notify()->success('Estante eliminado exitosamente.', 'Eliminado');
            return Redirect::route('estantes.index');
            
        } catch (\Exception $e) {
            notify()->error('Error al eliminar estante.', 'Error');
            return Redirect::route('estantes.index');
            
        }
    }
}
