@extends('layouts.dashboard')

@section('template_title')
    Seguimiento
@endsection

@section('content')
<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
					<div class="float-left">
						<span class="card-title font-weight-bold text-uppercase">Seguimiento del Proyecto: {{ $codigo_proyecto }}</span>
					</div>
					<div class="float-right">
						<a class="btn btn-primary btn-sm" href="{{ route('proyectos.index') }}"> {{ __('Volver') }}</a>
					</div>
				</div>

				<div class="card shadow mb-4">
					<div class="card-body">
						<div class="table-responsive">
							<table id="myTable" class="table table-striped table-bordered table-hover table-sm table-maquinado-smaller" style="width:100%">
								<thead class="thead-dark">
									<tr>
										<!-- Encabezados comunes -->
										<th>Fecha y Hora</th>
										<th>Código de partida</th>
										<th>Acción</th>
										<th>Estatus</th>
										<th>Tipo</th>
										<th>Tiempo total</th>
										
										<!-- Encabezados específicos -->
										<th>Área/Estante</th>
										<th>Máquina</th>
										<th>Operador</th>
									</tr>
								</thead>
								<tbody>
									@foreach($reportes as $reporte)
										<tr>
											{{-- Datos comunes --}}
											<td>{{ $reporte->fecha_hora }}</td>
											<td>{{ $reporte->codigo_partida }}</td>
											<td>{{ $reporte->accion }}</td>
											<td>{{ $reporte->estatus }}</td>
											<td>{{ $reporte instanceof \App\Models\ReportesMaquinado ? 'Maquinado' : 'Estante' }}</td>
											<td>{{ $reporte->tiempo_total }}</td>
											
											<!-- Detalles relevantes del reporte -->
											@if($reporte instanceof \App\Models\ReportesMaquinado)
												{{-- Datos de maquinado --}}
												<td>{{ $reporte->area->nombre ?? 'N/A' }}</td>
												<td>{{ $reporte->maquina->nombre ?? 'N/A' }}</td>
												<td>{{ $reporte->operador->nombre ?? 'N/A' }}</td>
											@else
												{{-- Datos de estante --}}
												<td>{{ $reporte->estante->nombre ?? 'N/A' }}</td>
												<td>N/A</td>
												<td>N/A</td>
											@endif
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection