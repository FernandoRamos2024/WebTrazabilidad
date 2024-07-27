@extends('layouts.dashboard')

@section('template_title')
    Áreas
@endsection

@section('content')
{{-- <link rel="stylesheet" type="text/css" href="{{asset('vendor/mckenziearts/laravel-notify/dist/notify.css')}}"/>
@notifyCss --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Áreas') }}
                            </span>

                            @can('acceder-admin-ventas')
                                <div class="float-right">
                                    <a href="{{ route('areas.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                        {{ __('Crear nueva área') }}
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped table-bordered table-hover" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>No</th>
									    <th >Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
									    <th >Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($areas as $area)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
										<td >{{ $area->nombre }}</td>

                                            <td>
                                                @can('acceder-admin-ventas')
                                                <form action="{{ route('areas.destroy', $area->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('areas.show', $area->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('areas.edit', $area->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="event.preventDefault(); confirm('¿Estás seguro de que deseas eliminar el área?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
                                                </form>
                                                @else
                                                    <a class="btn btn-sm btn-primary" href="{{ route('areas.show', $area->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $areas->withQueryString()->links() !!}
            </div>
        </div>
    </div>
@endsection