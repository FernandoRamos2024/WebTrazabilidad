@extends('layouts.dashboard')

@section('template_title')
    {{ $operador->name ?? __('Mostrar') . " " . __('Operador') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Operador</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('operadores.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $operador->nombre }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Área:</strong>
                                    {{ $area->nombre }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
