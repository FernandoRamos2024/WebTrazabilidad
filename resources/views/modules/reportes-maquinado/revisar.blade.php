@extends('layouts.dashboard')

@section('template_title')
    Revisar
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Reportes por revisar en Maquinado') }}
                            </span>

                            @can('acceder-admin-ventas')
                                <div class="float-right">
                                    <a href="{{ route('reportes-maquinados.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    {{ __('Crear nuevo reporte maquinado') }}
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
                                    <form id="searchForm" method="GET" action="{{ route('reportesMaquinados.revisarRegistros') }}">
                                        <div class="form-row mb-2">
                                            <div class="col-md-4">
                                                <input type="text" name="codigo_proyecto" class="form-control" placeholder="Código Proyecto" value="{{ $codigo_proyecto }}">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="codigo_partida" class="form-control" placeholder="Código Partida" value="{{ $codigo_partida }}">
                                            </div>
                                            <div class="col-md-4">
                                                <select name="accion" class="form-control">
                                                    <option value="">Seleccione Acción</option>
                                                    <option value="entrada" {{ $accion == 'entrada' ? 'selected' : '' }}>Entrada</option>
                                                    <option value="turno terminado" {{ $accion == 'turno terminado' ? 'selected' : '' }}>Turno terminado</option>
                                                    <option value="pieza terminada" {{ $accion == 'pieza terminada' ? 'selected' : '' }}>Pieza terminada</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col">
                                                <input type="text" name="nombre_area" class="form-control" placeholder="Nombre de Area" value="{{ $nombre_area }}">
                                            </div>
                                            <div class="col">
                                                <input type="text" name="nombre_operador" class="form-control" placeholder="Nombre de Operador" value="{{ $nombre_operador }}">
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col">
                                                <!-- Etiqueta para fecha_desde -->
                                                <label for="fecha_desde_maquinados" class="form-label">Fecha Desde</label>
                                                <input type="date" name="fecha_desde" id="fecha_desde_maquinados" class="form-control" value="{{ $fecha_desde }}">
                                            </div>
                                            <div class="col">
                                                <!-- Etiqueta para fecha_hasta -->
                                                <label for="fecha_hasta_maquinados" class="form-label">Fecha Hasta</label>
                                                <input type="date" name="fecha_hasta" id="fecha_hasta_maquinados" class="form-control" value="{{ $fecha_hasta }}">
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-search"></i>
                                                    Buscar
                                                </button>
                                            </div>
                                        </div>
                                    </form>                                    
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered table-hover table-sm table-maquinado-smaller" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Código Proyecto</th>
                                        <th>Código Partida</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Turno</th>
                                        <th>Acción</th>
                                        <th>Estatus</th>
                                        @can('acceder-admin-ventas')
                                            <th>Revisiones</th>
                                        @endcan
                                        <th>Tiempo Total</th>
                                        <th>Área</th>
                                        <th>Máquina</th>
                                        <th>Operador</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Código Proyecto</th>
                                        <th>Código Partida</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Turno</th>
                                        <th>Acción</th>
                                        <th>Estatus</th>
                                        @can('acceder-admin-ventas')
                                            <th>Revisiones</th>
                                        @endcan
                                        <th>Tiempo Total</th>
                                        <th>Área</th>
                                        <th>Máquina</th>
                                        <th>Operador</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($reportesPorRevisar as $reportePorRevisar)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
                                            <td>{{ $reportePorRevisar->codigo_proyecto }}</td>
                                            <td>{{ $reportePorRevisar->codigo_partida }}</td>
                                            <td>{{ $reportePorRevisar->fecha }}</td>
                                            <td>{{ $reportePorRevisar->hora }}</td>
                                            <td>{{ $reportePorRevisar->turno }}</td>
                                            <td>
                                                <span class="
                                                    @if($reportePorRevisar->accion == 'entrada')
                                                        border-yellow
                                                    @elseif($reportePorRevisar->accion == 'turno terminado')
                                                        border-green
                                                    @elseif($reportePorRevisar->accion == 'pieza terminada')
                                                        border-green
                                                    @endif
                                                ">
                                                {{ $reportePorRevisar->accion }}
                                            </td>
                                            <td>
                                                <span class="
                                                    @if($reportePorRevisar->estatus == 'proceso')
                                                        border-yellow
                                                    @elseif($reportePorRevisar->estatus == 'finalizado')
                                                        border-green
                                                    @elseif($reportePorRevisar->estatus == 'revisar')
                                                        border-red
                                                    @endif
                                                ">
                                                {{ $reportePorRevisar->estatus }}
                                            </td>
                                            @can('acceder-admin-ventas')
                                                <td >{{ $reportePorRevisar->revision }}</td>
                                            @endcan
                                            <td>{{ $reportePorRevisar->tiempo_total }}</td>
                                            <td>{{ $reportePorRevisar->area->nombre ?? 'N/A' }}</td>
                                            <td>{{ $reportePorRevisar->maquina->nombre ?? 'N/A' }}</td>
                                            <td>{{ $reportePorRevisar->operador->nombre ?? 'N/A' }}</td>

                                            <td>
                                                @can('acceder-admin-ventas')
                                                <form action="{{ route('reportes-maquinados.destroy', $reportePorRevisar->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('reportes-maquinados.show', $reportePorRevisar->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('reportes-maquinados.edit', $reportePorRevisar->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar el reporte maquinado?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                                @else 
                                                <a class="btn btn-sm btn-primary " href="{{ route('reportes-maquinados.show', $reportePorRevisar->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $reportesPorRevisar->withQueryString()->links() !!} --}}
            </div>
        </div>
    </div>

@endsection