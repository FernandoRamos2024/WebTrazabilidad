<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AreaController extends Controller
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
        $areas = Area::paginate();

        return view('modules.area.index', compact('areas'))
            ->with('i', ($request->input('page', 1) - 1) * $areas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $area = new Area();

        return view('modules.area.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request): RedirectResponse
    {
        try {
            Area::create($request->validated());

            notify()->success('Área creada exitosamente.', 'Creada');
            return Redirect::route('areas.index');
            //     ->with('success', 'Área creado exitosamente.');

        } catch (\Exception $e) {
            notify()->error('Error al crear área.', 'Error');
            return Redirect::route('areas.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $area = Area::find($id);

        return view('modules.area.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $area = Area::find($id);

        return view('modules.area.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, Area $area): RedirectResponse
    {
        try {
            $area->update($request->validated());
    
            notify()->success('Área actualizada exitosamente.', 'Actualizada');
            return Redirect::route('areas.index');
                // ->with('success', 'Área actualizado exitosamente.');
                
        } catch (\Exception $e) {
            notify()->error('Error al actualizar área.', 'Error');
            return Redirect::route('areas.index');
                // ->with('success', 'Área actualizado exitosamente.');
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            Area::find($id)->delete();

            notify()->success('Área eliminada correctamente.', 'Eliminada');
            return Redirect::route('areas.index');
                // ->with('success', 'Área eliminado exitosamente.');
                
        } catch (\Exception $e) {
            notify()->error('Error al eliminar área.', 'Error');
            return Redirect::route('areas.index');
                // ->with('success', 'Área eliminado exitosamente.');
            
        }
    }
}
