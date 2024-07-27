@extends('layouts.app')

@section('template_title')
    {{ __('Actualizar') }} Estante
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Estante</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('estantes.update', $estante->id) }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @method('PUT')

                            @include('modules.estante.form', ['areas' => $areas])


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
