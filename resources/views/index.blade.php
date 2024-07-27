<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reyper</title>
        <link rel="icon" href="{{ asset('images/icon-pgweb.jpeg') }}" type="image/png" sizes="32x32">

        <!-- Custom fonts for this template-->
        <link href="{{asset('libs/fontawesome/css/all.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="{{asset('libs/sbadmin/css/sb-admin-2.min.css')}}" rel="stylesheet">

        {{-- DataTables --}}
        <link href="{{asset('libs/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    </head>
    <body>

        <nav class="navbar navbar-light bg-light justify-content-between">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo-reyper.png') }}" width="200" height="100" alt="">
            </a>
            <form class="justify-content-between">
                @if (Route::has('login'))
                        @auth
                            @if(auth()->user()->role === 1)
                                <a href="{{ route('admin.index') }}" class="btn btn-panel-index">Mi panel</a>
                            @elseif(auth()->user()->role === 2)
                                <a href="{{ route('ventas.index') }}" class="btn btn-panel-index">Mi panel</a>
                            @elseif(auth()->user()->role === 3)
                                <a href="{{ route('operador.index') }}" class="btn btn-panel-index">Mi panel</a>
                            @else
                                <a href="{{ route('pagina-principal') }}" class="btn btn-panel-index">Mi panel</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-login-index">
                                Iniciar sesión
                            </a>
                            
                            {{-- @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="btn btn-primary"
                                >
                                    Registrar
                                </a>
                            @endif                --}}
                        @endauth
                    </nav>
                @endif
            </form>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success m-4">
                                <p>{{ $message }}</p>
                            </div>
                        @endif              

                        <div class="container-fluid">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Proyectos</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-striped table-bordered table-hover" style="width:100%">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>No</th>
                                                    
                                                    <th >Código Proyecto</th>
                                                    <th >Empresa</th>
                                                    <th >Fecha de entrega</th>
                                                    <th >Estatus</th>
                                                    <th >Imagen</th>

                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    
                                                <th >Código Proyecto</th>
                                                <th >Empresa</th>
                                                <th >Fecha de entrega</th>
                                                <th >Estatus</th>
                                                <th >Imagen</th>

                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($mostrarProyectos as $proyecto)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        
                                                        <td >{{ $proyecto->codigo_proyecto }}</td>
                                                        <td >{{ $proyecto->empresa }}</td>
                                                        <td >{{ $proyecto->fecha_entrega }}</td>
                                                        <td >
                                                            <span class="
                                                                @if($proyecto->estatus == 'cancelado')
                                                                    border-red
                                                                @elseif($proyecto->estatus == 'activo')
                                                                    border-yellow
                                                                @elseif($proyecto->estatus == 'entregado')
                                                                    border-green
                                                                @endif
                                                            ">
                                                            {{ $proyecto->estatus }}
                                                        </td>
                                                        <td ><img src="{{ asset('storage/' . $proyecto->imagen) }}" width="200px"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- eliminar esto --}}
                    {!! $mostrarProyectos->withQueryString()->links() !!}
                </div>
            </div>
        </div>

        <script data-main="js/app" src="js/lib/require.js"></script>
        <script data-main="scripts/main" src="scripts/require.js"></script>

        {{-- DataTables --}}
        <script src="{{asset('libs/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('libs/datatables/jquery.dataTables.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script src="{{asset('libs/sbadmin/js/demo/datatables-demo.js')}}"></script>

    </body>
</html>