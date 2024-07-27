<div class="container-fluid">

    <form action="{{ route('buscar.reciente') }}" method="GET" class="form-inline my-2 my-lg-0 d-flex align-items-center justify-content-center">
        <input class="form-control mr-sm-2 w-50" type="search" name="codigo" placeholder="Buscar en donde se encuentra una pieza" aria-label="Buscar">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>

    <div class="mt-4">
        @if(isset($reporteReciente))

            @if($tipoReporte == 'maquinado')
                <h3 class="d-flex align-items-center justify-content-center">Se encuentra maquinando en: {{ $reporteReciente->maquina->nombre }}</h3>
                <table class="table table-dark table-bordered table-hover align-items-center justify-content-center">
                    <tr class="form-group mb-2 mb20">
                        <th>Código Partida:</th>
                        <td>{{ $reporteReciente->codigo_partida }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Fecha:</th>
                        <td>{{ $reporteReciente->fecha }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Hora:</th>
                        <td>{{ $reporteReciente->hora }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Turno:</th>
                        <td>{{ $reporteReciente->turno }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Acción:</th>
                        <td>{{ $reporteReciente->accion }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Estatus:</th>
                        <td>{{ $reporteReciente->estatus }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Área:</th>
                        <td>{{ $reporteReciente->area->nombre }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Máquina:</th>
                        <td>{{ $reporteReciente->maquina->nombre }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Operador:</th>
                        <td>{{ $reporteReciente->operador->nombre }}</td>
                    </tr>
                </table>
            @elseif($tipoReporte == 'estante')
                <h2 class="d-flex align-items-center justify-content-center">Se encuentra en: {{ $reporteReciente->estante->nombre }}</h2>
                <table class="table table-dark table-bordered table-hover align-items-center justify-content-center">
                    <tr class="form-group mb-2 mb20">
                        <th>Código Partida:</th>
                        <td>{{ $reporteReciente->codigo_partida }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Fecha:</th>
                        <td>{{ $reporteReciente->fecha }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Hora:</th>
                        <td>{{ $reporteReciente->hora }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Acción:</th>
                        <td>{{ $reporteReciente->accion }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Estatus:</th>
                        <td>{{ $reporteReciente->estatus }}</td>
                    </tr>
                    <tr class="form-group mb-2 mb20">
                        <th>Estante:</th>
                        <td>{{ $reporteReciente->estante->nombre }}</td>
                    </tr>
                </table>
            @endif
        @endif
    </div>
</div>