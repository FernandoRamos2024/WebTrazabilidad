<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @notifyCss

    <title>Panel</title>
    <link rel="icon" href="{{ asset('images/icon-pgweb.jpeg') }}" type="image/png" sizes="32x32">

    <!-- Custom fonts for this template-->
    <link href="{{asset('libs/fontawesome/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="{{asset('libs/sbadmin/css/sb-admin-2.min.css')}}" rel="stylesheet">

    {{-- CSS DataTables --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap4.css">

    {{-- Css styles --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @auth
        @if(auth()->user()->role === 1)
        <ul class="navbar-nav sidebar sidebar-dark accordion panel-color-background-a" id="accordionSidebar">

        @elseif(auth()->user()->role === 2)
        <ul class="navbar-nav sidebar sidebar-dark accordion panel-color-background-v" id="accordionSidebar">

        @elseif(auth()->user()->role === 3)
        <ul class="navbar-nav sidebar sidebar-dark accordion panel-color-background-o" id="accordionSidebar">

        @endif
        @endauth

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('pagina-principal') }}">
                <div style="background-color: #ffff; width: 100%; heigth: 100%; border-radius: 5px;">
                    <div class="sidebar-brand-icon d-flex align-items-center justify-content-center">
                    <!-- rotate-n-15 -->
                        <!-- <i class="fas fa-fw fa-user"></i> -->
                        <img src="{{ asset('images/logo-reyper.png') }}" alt="logo" width="60px" heigth="60px">
                    </div>
                    <div class="sidebar-brand-text mx-3" style="color: red">Reyper</div>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                
                <a class="nav-link" href="{{route('panel.vista')}}">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Registros
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportsM"
                    aria-expanded="true" aria-controls="collapseReportsM">
                    <i class="fas fa-chart-pie"></i>
                    <span>Reportes maquinado</span>
                </a>
                <div id="collapseReportsM" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Administrar</h6>
                        <a class="collapse-item" href="{{ route('reportes-maquinados.index') }}">Todo</a>
                        @can('acceder-admin-ventas')
                            <a class="collapse-item" href="{{ route('reportesMaquinados.revisarRegistros') }}">Revisar</a>
                        @endcan
                    </div>
                </div>
            </li> 

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportsE"
                    aria-expanded="true" aria-controls="collapseReportsE">
                    <i class="fas fa-chart-pie"></i>
                    <span>Reportes estante</span>
                </a>
                <div id="collapseReportsE" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Administrar</h6>
                        <a class="collapse-item" href="{{ route('reportes-estantes.index') }}">Todo</a>
                        @can('acceder-admin-ventas')
                            <a class="collapse-item" href="{{ route('reportesEstantes.revisarRegistros') }}">Revisar</a>
                        @endcan
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Modulos
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            @can('acceder-admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Usuarios</span></a>
                </li>
            @endcan
            
            @can('acceder-admin-ventas')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('operadores.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Operadores</span></a>
                </li>
            @endcan
                
            <li class="nav-item">
                <a class="nav-link" href="{{ route('proyectos.index') }}">
                    <i class="fas fa-book-open"></i>
                    <span>Proyectos</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('maquinas.index') }}">
                    <i class="fas fa-wrench"></i>
                    <span>Máquinas</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('estantes.index') }}">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                    <span>Estantes</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('areas.index') }}">
                    <i class="fas fa-hotel"></i>
                    <span>Áreas</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars" style="color: red"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link" href="{{ route('frequent-questions') }}">
                                <i class="fa fa-question-circle text-primary"></i>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Preguntas frecuentes</span>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle text-dark"></i>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <div class="dropdown-divider"></div>
        
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
        
                                    <x-dropdown-link class="dropdown-item" :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ __('Cerrar sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('content')
                <!-- /.container-fluid -->
                </div>

            <!-- End of Main Content -->
            </div>

        <!-- End of Content Wrapper -->
        </div>

    <!-- End of Page Wrapper -->
    </div>

    {{-- Notify --}}
    <x-notify::notify />
    @notifyJs

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('libs/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('libs/sbadmin/js/sb-admin-2.min.js')}}"></script>

    <script data-main="js/app" src="js/lib/require.js"></script>
    <script data-main="scripts/main" src="scripts/require.js"></script>
    
    {{-- JS DataTables --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap4.js"></script>
    <script src="{{ asset('js/components/data-table.js') }}"></script>
    <script src="{{ asset('js/components/clear-filters.js') }}"></script>

</body>

</html>