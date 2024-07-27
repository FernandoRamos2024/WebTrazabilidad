@extends('layouts.dashboard')

@section('template_title')
    Reportes Maquinados
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Reportes Maquinados') }}
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
                                    <form id="searchForm" method="GET" action="{{ route('reportes-maquinados.index') }}">
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
                                            <div class="col-md-4">
                                                <select name="estatus" class="form-control">
                                                    <option value="">Seleccione Estatus</option>
                                                    <option value="proceso" {{ $estatus == 'proceso' ? 'selected' : '' }}>Proceso</option>
                                                    <option value="finalizado" {{ $estatus == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                                    <option value="revisar" {{ $estatus == 'revisar' ? 'selected' : '' }}>Revisar</option>
                                                </select>
                                            </div>
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

                    <div class="card shadow mb-4">
                        <div class="card-body">
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
                                            <th>Tiempo Total</th>
                                            <th>Área</th>
                                            <th>Máquina</th>
                                            <th>Operador</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($reportesMaquinados as $reportesMaquinado)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $reportesMaquinado->codigo_proyecto }}</td>
                                                <td>{{ $reportesMaquinado->codigo_partida }}</td>
                                                <td>{{ $reportesMaquinado->fecha }}</td>
                                                <td>{{ $reportesMaquinado->hora }}</td>
                                                <td>{{ $reportesMaquinado->turno }}</td>
                                                <td>
                                                    <span class="
                                                        @if($reportesMaquinado->accion == 'entrada')
                                                            border-yellow
                                                        @elseif($reportesMaquinado->accion == 'turno terminado')
                                                            border-green
                                                        @elseif($reportesMaquinado->accion == 'pieza terminada')
                                                            border-green
                                                        @endif
                                                    ">
                                                    {{ $reportesMaquinado->accion }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="
                                                        @if($reportesMaquinado->estatus == 'proceso')
                                                            border-yellow
                                                        @elseif($reportesMaquinado->estatus == 'finalizado')
                                                            border-green
                                                        @elseif($reportesMaquinado->estatus == 'revisar')
                                                            border-red
                                                        @endif
                                                    ">
                                                    {{ $reportesMaquinado->estatus }}
                                                    </span>
                                                </td>
                                                <td>{{ $reportesMaquinado->tiempo_total }}</td>
                                                <td>{{ $reportesMaquinado->area->nombre ?? 'N/A' }}</td>
                                                <td>{{ $reportesMaquinado->maquina->nombre ?? 'N/A' }}</td>
                                                <td>{{ $reportesMaquinado->operador->nombre ?? 'N/A' }}</td>
                                                <td>
                                                    @can('acceder-admin-ventas')
                                                    <form action="{{ route('reportes-maquinados.destroy', $reportesMaquinado->id) }}" method="POST">
                                                        <a class="btn btn-sm btn-primary " href="{{ route('reportes-maquinados.show', $reportesMaquinado->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                        <a class="btn btn-sm btn-success" href="{{ route('reportes-maquinados.edit', $reportesMaquinado->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar el reporte maquinado?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                    </form>
                                                    @else 
                                                    <a class="btn btn-sm btn-primary " href="{{ route('reportes-maquinados.show', $reportesMaquinado->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalMessage{{ $reportesMaquinado->id }}"><i class="fa fa-fw fa-edit"></i> {{ __('Solicitar revisión') }}</a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                </div>
                {{-- {!! $reportesMaquinados->withQueryString()->links() !!} --}}
            </div>
        </div>
    </div>
  
    <!-- Modal -->
    @foreach ($reportesMaquinados as $reportesMaquinado)
    <div class="modal fade" id="modalMessage{{ $reportesMaquinado->id }}" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Revisiones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('solicitar.revision.m') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $reportesMaquinado->id }}">
                        <div class="form-group">
                            <input type="hidden" name="estatus" value="revisar" id="estatus">
                            <label for="message-text" class="col-form-label">
                                Ingresa la corrección a realizar, empezando por el campo a corregir seguido del valor a cambiar.
                                <br>
                                Por ejemplo, puedes usar alguna de estas opciones:
                                <li>Maquina NXL</li>
                                <li>Corregir maquina a NXL</li>
                            </label>
                            <textarea class="form-control" name="revision" id="revision" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
@endsection