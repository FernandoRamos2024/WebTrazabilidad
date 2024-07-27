@extends('layouts.dashboard')

@section('template_title')
    Reportes Estantes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Reportes Estantes') }}
                            </span>

                            @can('acceder-admin-ventas')
                                <div class="float-right">
                                    <a href="{{ route('reportes-estantes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                    {{ __('Crear nuevo reportes estantes') }}
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
                                    <form id="searchForm" method="GET" action="{{ route('reportes-estantes.index') }}">
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
                                                    <option value="salida" {{ $accion == 'salida' ? 'selected' : '' }}>Salida</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <select name="estatus" class="form-control">
                                                    <option value="">Estatus</option>
                                                    <option value="conforme" {{ $estatus == 'conforme' ? 'selected' : '' }}>Conforme</option>
                                                    <option value="no conforme" {{ $estatus == 'no conforme' ? 'selected' : '' }}>No conforme</option>
                                                    <option value="revisar" {{ $estatus == 'revisar' ? 'selected' : '' }}>Revisar</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="nombre_estante" class="form-control" placeholder="Nombre de estante" value="{{ $nombre_estante }}">
                                            </div>
                                        </div>
                                        <div class="form-row mb-2">
                                            <div class="col">
                                                <!-- Etiqueta para fecha_desde -->
                                                <label for="fecha_desde" class="form-label">Fecha Desde</label>
                                                <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="{{ $fecha_desde }}">
                                            </div>
                                            <div class="col">
                                                <!-- Etiqueta para fecha_hasta -->
                                                <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                                                <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="{{ $fecha_hasta }}">
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
                            <table id="myTable" class="table table-striped table-bordered table-hover table-sm">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
                                        
                                        <th >Código Proyecto</th>
                                        <th >Código Partida</th>
                                        <th >Fecha</th>
                                        <th >Hora</th>
                                        <th >Acción</th>
                                        <th >Minutos</th>
                                        <th >Estatus</th>
                                        <th >Estante</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        
                                        <th >Código Proyecto</th>
                                        <th >Código Partida</th>
                                        <th >Fecha</th>
                                        <th >Hora</th>
                                        <th >Acción</th>
                                        <th >Minutos</th>
                                        <th >Estatus</th>
                                        <th >Estante</th>

                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($reportesEstantes as $reportesEstante)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
                                            <td >{{ $reportesEstante->codigo_proyecto }}</td>
                                            <td >{{ $reportesEstante->codigo_partida }}</td>
                                            <td >{{ $reportesEstante->fecha }}</td>
                                            <td >{{ $reportesEstante->hora }}</td>
                                            <td >
                                                <span class="
                                                    @if($reportesEstante->accion == 'entrada')
                                                        border-yellow
                                                    @elseif($reportesEstante->accion == 'salida')
                                                        border-green
                                                    @endif
                                                ">
                                                {{ $reportesEstante->accion }}
                                            </td>
                                            <td >{{ $reportesEstante->tiempo_total }}</td>
                                            <td >
                                                <span class="
                                                    @if($reportesEstante->estatus == 'no conforme')
                                                        border-red
                                                    @elseif($reportesEstante->estatus == 'conforme')
                                                        border-green
                                                    @elseif($reportesEstante->estatus == 'revisar')
                                                        border-red
                                                    @endif
                                                ">
                                                {{ $reportesEstante->estatus }}
                                            </td>
                                            <td>{{ $reportesEstante->estante->nombre }}</td>
                                            <td>
                                                @can('acceder-admin-ventas')
                                                <form action="{{ route('reportes-estantes.destroy', $reportesEstante->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('reportes-estantes.show', $reportesEstante->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('reportes-estantes.edit', $reportesEstante->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar el reporte de estante?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                                @else 
                                                <a class="btn btn-sm btn-primary " href="{{ route('reportes-estantes.show', $reportesEstante->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalMessage{{ $reportesEstante->id }}"><i class="fa fa-fw fa-edit"></i> {{ __('Solicitar revisión') }}</a>
                                                
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- {!! $reportesEstantes->withQueryString()->links() !!} --}}
            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach ($reportesEstantes as $reportesEstante)
    <div class="modal fade" id="modalMessage{{ $reportesEstante->id }}" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Revisiones</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('solicitar.revision.e') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $reportesEstante->id }}">
                        <div class="form-group">
                            <input type="hidden" name="estatus" value="revisar" id="estatus">
                            <label for="message-text" class="col-form-label">
                                Ingresa la corrección a realizar, empezando por el campo a corregir seguido del valor a cambiar.
                                <br>
                                Por ejemplo, puedes usar alguna de estas opciones:
                                <li>Estante fresado</li>
                                <li>Corregir estante a fresado</li>
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
