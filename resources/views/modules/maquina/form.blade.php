<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $maquina?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="estatus" class="form-label">{{ __('Estatus') }}</label>
            <select name="estatus" id="estatus" class="form-control @error('estatus') is-invalid @enderror">
                @foreach($estatusOptions as $estatus)
                    <option value="{{ $estatus }}" {{ old('estatus', $maquina?->estatus) == $estatus ? 'selected' : '' }}>{{ $estatus }}</option>
                @endforeach
            </select>
            {!! $errors->first('estatus', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="id_area" class="form-label">{{ __('Área') }}</label>
            <select name="id_area" id="id_area" class="form-control @error('id_area') is-invalid @enderror">
                <option value="">{{ __('Seleccione una área') }}</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('id_area', $maquina?->id_area) == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                @endforeach
            </select>
            {!! $errors->first('id_area', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>