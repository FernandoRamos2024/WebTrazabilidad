@extends('layouts.dashboard')

@section('template_title')
    {{ $user->name ?? __('Mostrar') . " " . __('User') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} User</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}"> {{ __('volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Nombre:</strong>
                                    {{ $user->name }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Correo Electrónico:</strong>
                                    {{ $user->email }}
                                </div>
                                <div class="form-group">
                                    <strong>Rol:</strong>
                                    {{ $user->role_name }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
