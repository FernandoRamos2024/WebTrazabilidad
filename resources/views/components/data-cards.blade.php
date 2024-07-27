<!-- Content Row -->
<div class="row">

    <!-- Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Proyectos </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$numeroProyectos}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-open fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Estantes (Salidas)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$salidasEstante}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-arrow-alt-circle-right fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('acceder-admin-ventas')
        <!-- Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Revisar
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$revisarRegistros}}</div>
                        </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <!-- Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Maquinado (salidas)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$salidasMaquinado}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-arrow-alt-circle-right fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>