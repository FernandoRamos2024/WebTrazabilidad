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

                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead">
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
                                <tbody>
                                    @foreach ($reportesPorRevisar as $reporteRevisar)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $reporteRevisar->codigo_proyecto }}</td>
										<td >{{ $reporteRevisar->codigo_partida }}</td>
										<td >{{ $reporteRevisar->fecha }}</td>
										<td >{{ $reporteRevisar->hora }}</td>
										<td >{{ $reporteRevisar->turno }}</td>
										<td >
                                            <span class="
                                                @if($reporteRevisar->accion == 'entrada')
                                                    border-yellow
                                                @elseif($reporteRevisar->accion == 'turno terminado')
                                                    border-green
                                                @elseif($reporteRevisar->accion == 'pieza terminada')
                                                    border-green
                                                @endif
                                            ">
                                            {{ $reporteRevisar->accion }}</td>
										<td >
                                            <span class="
                                                @if($reporteRevisar->estatus == 'proceso')
                                                    border-yellow
                                                @elseif($reporteRevisar->estatus == 'finalizado')
                                                    border-green
                                                @elseif($reporteRevisar->estatus == 'revisar')
                                                    border-red
                                                @endif
                                            ">
                                            {{ $reporteRevisar->estatus }}</td>
										<td >{{ $reporteRevisar->tiempo_total }}</td>
										<td >{{ $reporteRevisar->area->nombre ?? 'N/A' }}</td>
										<td >{{ $reporteRevisar->maquina->nombre ?? 'N/A' }}</td>
										<td >{{ $reporteRevisar->operador->nombre ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $reportesPorRevisar->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection