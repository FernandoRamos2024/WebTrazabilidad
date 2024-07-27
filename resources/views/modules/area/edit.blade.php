@extends('layouts.dashboard')

@section('template_title')
    {{ __('Actualizar') }} Área
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar') }} Área</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('areas.update', $area->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('modules.area.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
