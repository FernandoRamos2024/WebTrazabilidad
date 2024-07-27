@extends('layouts.dashboard')

@section('template_title')
    {{ $reportesEstante->name ?? __('Mostrar') . " " . __('Reportes Estante') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Reportes Estante</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('reportes-estantes.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Código Proyecto:</strong>
                                    {{ $reportesEstante->codigo_proyecto }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Código Partida:</strong>
                                    {{ $reportesEstante->codigo_partida }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha:</strong>
                                    {{ $reportesEstante->fecha }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Hora:</strong>
                                    {{ $reportesEstante->hora }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Acción:</strong>
                                    {{ $reportesEstante->accion }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tiempo en minutos:</strong>
                                    {{ $reportesEstante->tiempo_total }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estatus:</strong>
                                    {{ $reportesEstante->estatus }}
                                </div>
                                @can('acceder-admin-ventas')
                                    <div class="form-group mb-2 mb20">
                                        <strong>Revisiones:</strong>
                                        {{ $reportesEstante->revision }}
                                    </div>
                                @endcan
                                <div class="form-group mb-2 mb20">
                                    <strong>Estante:</strong>
                                    {{ $reportesEstante->estante->nombre }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
