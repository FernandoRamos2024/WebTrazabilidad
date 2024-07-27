@extends('layouts.dashboard')

@section('template_title')
    {{ $reportesMaquinado->name ?? __('Mostrar') . " " . __('Reportes Maquinado') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Reportes Maquinado</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('reportes-maquinados.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Código Proyecto:</strong>
                                    {{ $reportesMaquinado->codigo_proyecto }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Código Partida:</strong>
                                    {{ $reportesMaquinado->codigo_partida }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha:</strong>
                                    {{ $reportesMaquinado->fecha }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Hora:</strong>
                                    {{ $reportesMaquinado->hora }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Turno:</strong>
                                    {{ $reportesMaquinado->turno }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Acción:</strong>
                                    {{ $reportesMaquinado->accion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estatus:</strong>
                                    {{ $reportesMaquinado->estatus }}
                                </div>
                                @can('acceder-admin-ventas')
                                    <div class="form-group mb-2 mb20">
                                        <strong>Revisiones:</strong>
                                        {{ $reportesMaquinado->revision }}
                                    </div>
                                @endcan
                                <div class="form-group mb-2 mb20">
                                    <strong>Tiempo Total:</strong>
                                    {{ $reportesMaquinado->tiempo_total }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Área:</strong>
                                    {{ $reportesMaquinado->area->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Máquina:</strong>
                                    {{ $reportesMaquinado->maquina->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Operador:</strong>
                                    {{ $reportesMaquinado->operador->nombre }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
