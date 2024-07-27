<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\MaquinaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MaquinaController extends Controller
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
        // $maquinas = Maquina::with('area')->paginate();
        $nombre = $request->input('nombre');
        $nombre_area = $request->input('nombre_area');
        $estatus = $request->input('estatus');

        $query = Maquina::with('area');

        if ($nombre) {
            $query->where('nombre', 'LIKE', '%' . $nombre . '%');
        }

        if ($nombre_area) {
            $query->whereHas('area', function($query) use ($nombre_area) {
                $query->where('nombre', 'LIKE', '%' . $nombre_area . '%');
            });
        }

        if ($estatus) {
            $query->where('estatus', $estatus);
        }

        $maquinas = $query->get();

        return view('modules.maquina.index', compact('maquinas', 'nombre', 'nombre_area', 'estatus'))
        ->with('i');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $maquina = new Maquina();
        $estatusOptions = ['activa', 'desactiva', 'reparacion']; // Ejemplo de opciones de estatus
        $areas = Area::all(); // Obtener todas las áreas

        return view('modules.maquina.create', compact('maquina', 'estatusOptions', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaquinaRequest $request): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'estatus' => 'required|string|max:255',
                'id_area' => 'required|exists:areas,id',
            ]);
    
            Maquina::create($validatedData);
    
            notify()->success('Máquina creada exitosamente.', 'Creada');
            return Redirect::route('maquinas.index');
                // ->with('success', 'Máquina creada exitosamente.');
            
        } catch (\Exception $e) {
            notify()->error('Error al crear máquina.', 'Error');
            return Redirect::route('maquinas.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $maquina = Maquina::with('area')->find($id);

        return view('modules.maquina.show', compact('maquina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $maquina = Maquina::find($id);
        $estatusOptions = ['activa', 'desactiva', 'reparacion']; // Ejemplo de opciones de estatus
        $areas = Area::all(); // Obtener todas las áreas

        return view('modules.maquina.edit', compact('maquina', 'estatusOptions', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaquinaRequest $request, Maquina $maquina): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'estatus' => 'required|string|max:255',
                'id_area' => 'required|exists:areas,id',
            ]);
    
            $maquina->update($validatedData);
    
            notify()->success('Máquina actualizada exitosamente.', 'Actualizada');
            return Redirect::route('maquinas.index');
                // ->with('success', 'Máquina actualizada exitosamente.');
                
        } catch (\Exception $e) {
            notify()->error('Error al actualizar máquina.', 'Error');
            return Redirect::route('maquinas.index');
        }
    }

    public function destroy($id): RedirectResponse
    { 
        try {
            Maquina::find($id)->delete();

            notify()->success('Máquina eliminada exitosamente.', 'Eliminada');
            return Redirect::route('maquinas.index');
                
        } catch (\Exception $e) {
            
            notify()->error('Error al eliminar máquina.', 'Error');
            return Redirect::route('maquinas.index');
        }
    }
}
