@extends('layouts.dashboard')

@section('template_title')
    Estantes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Estantes') }}
                            </span>

                            @can('acceder-admin-ventas')
                                <div class="float-right">
                                    <a href="{{ route('estantes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    {{ __('Crear nuevo estante') }}
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <!-- Formulario de búsqueda -->
                    <form method="GET" action="{{ route('estantes.index') }}" class="mb-4">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ $nombre }}">
                            </div>
                            <div class="col">
                                <input type="text" name="nombre_area" class="form-control" placeholder="Nombre de Area" value="{{ $nombre_area }}">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Área</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nombre</th>
                                        <th>Área</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($estantes as $estante)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $estante->nombre }}</td>
										<td>{{ $estante->area->nombre }}</td> <!-- Mostrar el nombre del área -->

                                            <td>
                                                @can('acceder-admin-ventas')
                                                <form action="{{ route('estantes.destroy', $estante->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('estantes.show', $estante->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('estantes.edit', $estante->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de que deseas eliminar el estante?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                                @else 
                                                <a class="btn btn-sm btn-primary " href="{{ route('estantes.show', $estante->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $estantes->withQueryString()->links() !!} --}}
            </div>
        </div>
    </div>
@endsection
