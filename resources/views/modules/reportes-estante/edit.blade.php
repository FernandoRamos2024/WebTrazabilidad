@extends('layouts.dashboard')

@section('template_title')
    {{ __('Actualizar') }} Reportes Estante
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Reportes Estante</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('reportes-estantes.update', $reportesEstante->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('modules.reportes-estante.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
