<div class="row p-3">
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="codigo_proyecto" class="form-label">{{ __('Código Proyecto') }}</label>
            <input type="text" name="codigo_proyecto" class="form-control @error('codigo_proyecto') is-invalid @enderror" value="{{ old('codigo_proyecto', $reportesEstante?->codigo_proyecto) }}" id="codigo_proyecto" placeholder="Código Proyecto">
            {!! $errors->first('codigo_proyecto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="codigo_partida" class="form-label">{{ __('Código Partida') }}</label>
            <input type="text" name="codigo_partida" class="form-control @error('codigo_partida') is-invalid @enderror" value="{{ old('codigo_partida', $reportesEstante?->codigo_partida) }}" id="codigo_partida" placeholder="Código Partida">
            {!! $errors->first('codigo_partida', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="fecha" class="form-label">{{ __('Fecha') }}</label>
            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" value="{{ old('fecha', $reportesEstante?->fecha) }}" id="fecha">
            {!! $errors->first('fecha', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="hora" class="form-label">{{ __('Hora') }}</label>
            <input type="time" name="hora" class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora', $reportesEstante?->hora) }}" id="hora">
            {!! $errors->first('hora', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="accion" class="form-label">{{ __('Acción') }}</label>
            <select name="accion" id="accion" class="form-control @error('accion') is-invalid @enderror">
                <option value="">{{ __('Seleccione acción') }}</option>
                @foreach($acciones as $accion)
                    <option value="{{ $accion }}" {{ old('accion', $reportesEstante?->accion) == $accion ? 'selected' : '' }}>{{ $accion }}</option>
                @endforeach
            </select>
            {!! $errors->first('accion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="id_estante" class="form-label">{{ __('Estante') }}</label>
            <select name="id_estante" id="id_estante" class="form-control @error('id_estante') is-invalid @enderror">
                <option value="">{{ __('Seleccione estante') }}</option>
                @foreach($estantes as $estante)
                    <option value="{{ $estante->id }}" {{ (old('id_estante') == $estante->id || (isset($reportesEstante) && $reportesEstante->id_estante == $estante->id)) ? 'selected' : '' }}>
                        {{ $estante->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('id_estante', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="estatus" class="form-label">{{ __('Estatus') }}</label>
            <select name="estatus" id="estatus" class="form-control @error('estatus') is-invalid @enderror">
                <option value="">{{ __('Seleccione estatus') }}</option>
                @foreach($estatuses as $estatus)
                    <option value="{{ $estatus }}" {{ old('estatus', $reportesEstante?->estatus) == $estatus ? 'selected' : '' }}>{{ $estatus }}</option>
                @endforeach
            </select>
            {!! $errors->first('estatus', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="revision" class="form-label">{{ __('Revision') }}</label>
            <input type="text" name="revision" class="form-control @error('revision') is-invalid @enderror" value="{{ old('revision', $reportesEstante?->revision) }}" id="revision" placeholder="No llenar este campo">
            {!! $errors->first('revision', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="tiempo_total" class="form-label">{{ __('Tiempo Total') }}</label>
            <input type="text" name="tiempo_total" class="form-control @error('tiempo_total') is-invalid @enderror" value="{{ old('tiempo_total', $reportesEstante?->tiempo_total) }}" id="tiempo_total" placeholder="No llenar este campo">
            {!! $errors->first('tiempo_total', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>