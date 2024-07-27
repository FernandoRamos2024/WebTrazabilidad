@extends('layouts.dashboard')

@section('template_title')
    Proyectos
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Proyectos') }}
                            </span>

                            @can('acceder-admin-ventas')
                                <div class="float-right">
                                    <a href="{{ route('proyectos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    {{ __('Crear nuevo proyecto') }}
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

                    <!-- Acordeón de filtros -->
                    <div id="accordionFilters" class="mb-4">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0 d-flex justify-content-between align-items-center">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="text-decoration: none; font-weight: bold; padding: 0; font-size: 1rem;">
                                        <i class="fas fa-filter"></i>
                                        Filtros de búsqueda
                                    </button>
                                    <button type="button" id="clearFilters" class="btn btn-danger">
                                        <i class="fas fa-times"></i>
                                        Eliminar filtros
                                    </button>
                                </h5>
                            </div>
                    
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionFilters">
                                <div class="card-body">
                                    <form id="searchForm" method="GET" action="{{ route('proyectos.index') }}" class="mb-4">
                                        <div class="form-row mb-2">
                                            <div class="col-md-4">
                                                <input type="text" name="codigo_proyecto" class="form-control" placeholder="Código Proyecto" value="{{ $codigo_proyecto }}">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="empresa" class="form-control" placeholder="Empresa" value="{{ $empresa }}">
                                            </div>
                                            <div class="col-md-4">
                                                <select name="estatus" class="form-control">
                                                    <option value="">Seleccione Estatus</option>
                                                    <option value="activo" {{ $estatus == 'activo' ? 'selected' : '' }}>Activo</option>
                                                    <option value="cancelado" {{ $estatus == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col-md-4">
                                                <input type="date" name="fecha_desde" class="form-control" value="{{ $fecha_desde }}">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" name="fecha_hasta" class="form-control" value="{{ $fecha_hasta }}">
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary">Buscar</button>
                                            </div>
                                        </div>
                                    </form>                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Código Proyecto</th>
                                        <th>Empresa</th>
                                        <th>Fecha de entrega</th>
                                        <th>Estatus</th>
                                        <th>Imagen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Código Proyecto</th>
                                        <th>Empresa</th>
                                        <th>Fecha de entrega</th>
                                        <th>Estatus</th>
                                        <th>Imagen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($proyectos as $proyecto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $proyecto->codigo_proyecto }}</td>
										<td >{{ $proyecto->empresa }}</td>
                                        <td >{{ $proyecto->fecha_entrega }}</td>
										<td >
                                            <span class="
                                                @if($proyecto->estatus == 'cancelado')
                                                    border-red
                                                @elseif($proyecto->estatus == 'activo')
                                                    border-yellow
                                                @elseif($proyecto->estatus == 'entregado')
                                                    border-green
                                                @endif
                                            ">
                                            {{ $proyecto->estatus }}
                                        </td>
										<td ><img src="{{ asset('storage/' . $proyecto->imagen) }}" width="100px"></td>

                                            <td>
                                                @can('acceder-admin-ventas')
                                                <form action="{{ route('proyectos.destroy', $proyecto->id) }}" method="POST">
                                                    {{-- <a class="btn btn-sm btn-primary " href="{{ route('proyectos.show', $proyecto->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a> --}}
                                                    <a class="btn btn-sm btn-primary" href="{{ route('proyectos.seguimiento', $proyecto->codigo_proyecto) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Seguimiento') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('proyectos.edit', $proyecto->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar el proyecto?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                                @else
                                                <a class="btn btn-sm btn-primary " href="{{ route('proyectos.show', $proyecto->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $proyectos->withQueryString()->links() !!} --}}
            </div>
        </div>
    </div>
@endsection
