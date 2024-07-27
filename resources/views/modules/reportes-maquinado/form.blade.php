<div class="row p-3">
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="codigo_proyecto" class="form-label">{{ __('Código Proyecto') }}</label>
            <input type="text" name="codigo_proyecto" class="form-control @error('codigo_proyecto') is-invalid @enderror" value="{{ old('codigo_proyecto', $reportesMaquinado?->codigo_proyecto) }}" id="codigo_proyecto" placeholder="Codigo Proyecto">
            {!! $errors->first('codigo_proyecto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="codigo_partida" class="form-label">{{ __('Código Partida') }}</label>
            <input type="text" name="codigo_partida" class="form-control @error('codigo_partida') is-invalid @enderror" value="{{ old('codigo_partida', $reportesMaquinado?->codigo_partida) }}" id="codigo_partida" placeholder="Codigo Partida">
            {!! $errors->first('codigo_partida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="fecha" class="form-label">{{ __('Fecha') }}</label>
            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $reportesMaquinado?->fecha) }}" id="fecha">
            {!! $errors->first('fecha', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="hora" class="form-label">{{ __('Hora') }}</label>
            <input type="time" name="hora" class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora', $reportesMaquinado?->hora) }}" id="hora">
            {!! $errors->first('hora', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="turno" class="form-label">{{ __('Turno') }}</label>
            <select name="turno" id="turno" class="form-control @error('turno') is-invalid @enderror">
                <option value="">{{ __('Seleccione turno') }}</option>
                @foreach($turnos as $turno)
                    <option value="{{ $turno }}" {{ old('turno', $reportesMaquinado?->turno) == $turno ? 'selected' : '' }}>{{ $turno }}</option>
                @endforeach
            </select>
            {!! $errors->first('turno', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="accion" class="form-label">{{ __('Acción') }}</label>
            <select name="accion" id="accion" class="form-control @error('accion') is-invalid @enderror">
                <option value="">{{ __('Seleccione acción') }}</option>
                @foreach($acciones as $accion)
                    <option value="{{ $accion }}" {{ old('accion', $reportesMaquinado?->accion) == $accion ? 'selected' : '' }}>{{ $accion }}</option>
                @endforeach
            </select>
            {!! $errors->first('accion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="id_maquina" class="form-label">{{ __('Máquina') }}</label>
            <select name="id_maquina" id="id_maquina" class="form-control @error('id_maquina') is-invalid @enderror">
                <option value="">{{ __('Seleccione máquina') }}</option>
                @foreach($maquinas as $maquina)
                    <option value="{{ $maquina->id }}" {{ old('id_maquina', $reportesMaquinado?->id_maquina) == $maquina->id ? 'selected' : '' }}>{{ $maquina->nombre }}</option>
                @endforeach
            </select>
            {!! $errors->first('id_maquina', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="id_operador" class="form-label">{{ __('Operador') }}</label>
            <select name="id_operador" id="id_operador" class="form-control @error('id_operador') is-invalid @enderror">
                <option value="">{{ __('Seleccione operador') }}</option>
                @foreach($operadores as $operador)
                    <option value="{{ $operador->id }}" {{ old('id_operador', $reportesMaquinado?->id_operador) == $operador->id ? 'selected' : '' }}>{{ $operador->nombre }}</option>
                @endforeach
            </select>
            {!! $errors->first('id_operador', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="id_area" class="form-label">{{ __('Área') }}</label>
            <select name="id_area" id="id_area" class="form-control @error('id_area') is-invalid @enderror">
                <option value="">{{ __('Seleccione área') }}</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('id_area', $reportesMaquinado?->id_area) == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                @endforeach
            </select>
            {!! $errors->first('id_area', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="tiempo_total" class="form-label">{{ __('Tiempo Total') }}</label>
            <input type="text" name="tiempo_total" class="form-control @error('tiempo_total') is-invalid @enderror" value="{{ old('tiempo_total', $reportesMaquinado?->tiempo_total) }}" id="tiempo_total" placeholder="No llenar este campo">
            {!! $errors->first('tiempo_total', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="estatus" class="form-label">{{ __('Estatus') }}</label>
            <select name="estatus" id="estatus" class="form-control @error('estatus') is-invalid @enderror">
                <option value="">{{ __('Seleccione estatus') }}</option>
                @foreach($estatuses as $estatus)
                    <option value="{{ $estatus }}" {{ old('estatus', $reportesMaquinado?->estatus) == $estatus ? 'selected' : '' }}>{{ $estatus }}</option>
                @endforeach
            </select>
            {!! $errors->first('estatus', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="revision" class="form-label">{{ __('Revision') }}</label>
            <input type="text" name="revision" class="form-control @error('revision') is-invalid @enderror" value="{{ old('revision', $reportesMaquinado?->revision) }}" id="revision" placeholder="No llenar este campo">
            {!! $errors->first('revision', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>