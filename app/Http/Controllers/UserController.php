<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\UserRequest;
// use DragonCode\Contracts\Cashier\Auth\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $role = $request->input('role');
        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->get();

        return view('admin.user.index', compact('users', 'role'))
            ->with('i');
    }

    public function operador()
    {
        return view('operador.index');
    }

    public function ventas()
    {
        return view('ventas.index');
    }

    public function admin()
    {
        return view('admin.index');
    }

    public function returnViewByRole()
    {
        $rol = Auth::user()->role;

        if ($rol == User::ROLE_ADMINISTRADOR) {
            return view('admin.index');
        } elseif ($rol == User::ROLE_VENTAS) {
            return view('ventas.index');
        } elseif ($rol == User::ROLE_OPERADOR) {
            return view('operador.index');
        } else {
            return view('index');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $user = new User();
        $roles = $this->getRoles(); // Obtener los roles

        return view('admin.user.create', compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role, // Usar 'role'
            ]);
    
            notify()->success('Usuario creado exitosamente.', 'Creado');
            return Redirect::route('users.index');
            
        } catch (\Exception $e) {
            
            notify()->error('Error al crear usuario.', 'Error');
            return Redirect::route('users.index');
            
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('admin.user.show', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = $this->getRoles(); // Obtener los roles

        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'role' => $request->role,
            ]);
    
            notify()->success('Usuario actualizado exitosamente.', 'Actualizado');
            return Redirect::route('users.index');
            
        } catch (\Exception $e) {
            notify()->error('Error al actualizar usuario.', 'Error');
            return Redirect::route('users.index');
        }
    }

    public function destroy($id): RedirectResponse
    {
        try {
            User::find($id)->delete();
    
            notify()->success('Usuario eliminado exitosamente.', 'Eliminado');
            return Redirect::route('users.index');
            
        } catch (\Exception $e) {
            
            notify()->error('Error al eliminar usuario.', 'Error');
            return Redirect::route('users.index');
            
        }
    }

    /**
     * Get the roles for the user.
     */
    private function getRoles()
    {
        return [
            User::ROLE_ADMINISTRADOR => 'Administrador',
            User::ROLE_VENTAS => 'Ventas',
            User::ROLE_OPERADOR => 'Operador',
        ];
    }
}
