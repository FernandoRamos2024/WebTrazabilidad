@extends('layouts.dashboard')

@section('template_title')
    Users
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Usuarios') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Crear nuevo usuario') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('users.index') }}" class="mb-4">
                        <div class="form-row">
                            <div class="col">
                                <select name="role" class="form-control">
                                    <option value="">Seleccione Rol</option>
                                    <option value="1" {{ $role == '1' ? 'selected' : '' }}>Administrador</option>
                                    <option value="2" {{ $role == '2' ? 'selected' : '' }}>Ventas</option>
                                    <option value="3" {{ $role == '3' ? 'selected' : '' }}>Operador</option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Correo Electrónico</th>
                                        <th>Rol</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Correo Electrónico</th>
                                        <th>Rol</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td >{{ $user->name }}</td>
                                            <td >{{ $user->email }}</td>
                                            <td>{{ $user->role_name }}</td> <!-- Aquí usamos role_name -->

                                        <td>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('users.show', $user->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de que deseas eliminar el usuario?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $users->withQueryString()->links() !!} --}}
            </div>
        </div>
    </div>
@endsection
