@extends('layouts.dashboard')

@section('template_title')
    {{ $maquina->name ?? __('Mostrar') . " " . __('Máquina') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Máquina</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('maquinas.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>{{ __('Nombre') }}:</strong>
                            {{ $maquina->nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>{{ __('Estatus') }}:</strong>
                            {{ $maquina->estatus }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>{{ __('Área') }}:</strong>
                            {{ $maquina->area ? $maquina->area->nombre : 'Área no asignada' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
