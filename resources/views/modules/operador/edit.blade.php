@extends('layouts.dashboard')

@section('template_title')
    {{ __('Actualizar') }} Operadore
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Operador</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('operadores.update', $operador->id) }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @method('PUT')

                            @include('modules.operador.form', ['areas' => $areas])

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
