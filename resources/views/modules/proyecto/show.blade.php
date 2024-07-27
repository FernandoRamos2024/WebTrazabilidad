@extends('layouts.dashboard')

@section('template_title')
    {{ $proyecto->name ?? __('Mostrar') . " " . __('Proyecto') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Proyecto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('proyectos.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Codigo Proyecto:</strong>
                                    {{ $proyecto->código_proyecto }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Empresa:</strong>
                                    {{ $proyecto->empresa }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha de entrega:</strong>
                                    {{ $proyecto->fecha_entrega }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estatus:</strong>
                                    {{ $proyecto->estatus }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Imagen:</strong>
                                    <img src="{{ asset('storage/' . $proyecto->imagen) }}" width="300px">
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
