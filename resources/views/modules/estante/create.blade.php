@extends('layouts.dashboard')

@section('template_title')
    {{ __('Crear') }} Estante
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear') }} Estante</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('estantes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('modules.estante.form', ['areas' => $areas])

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
