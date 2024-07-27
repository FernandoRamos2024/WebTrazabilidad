<div class="row p-3">
    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="codigo_proyecto" class="form-label">{{ __('Código Proyecto') }}</label>
            <input type="text" name="codigo_proyecto" class="form-control @error('codigo_proyecto') is-invalid @enderror" value="{{ old('codigo_proyecto', $proyecto->codigo_proyecto ?? '') }}" id="codigo_proyecto" placeholder="Código Proyecto">
            {!! $errors->first('codigo_proyecto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="empresa" class="form-label">{{ __('Empresa') }}</label>
            <input type="text" name="empresa" class="form-control @error('empresa') is-invalid @enderror" value="{{ old('empresa', $proyecto->empresa ?? '') }}" id="empresa" placeholder="Empresa">
            {!! $errors->first('empresa', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="fecha_entrega" class="form-label">{{ __('Fecha de entrega') }}</label>
            <input type="date" name="fecha_entrega" min="{{ date('Y-m-d') }}" class="form-control @error('fecha_entrega') is-invalid @enderror" value="{{ old('fecha_entrega', $proyecto->fecha_entrega ?? '') }}" id="fecha_entrega">
            {!! $errors->first('fecha_entrega', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="estatus" class="form-label">{{ __('Estatus') }}</label>
            <select name="estatus" id="estatus" class="form-control @error('estatus') is-invalid @enderror">
                @foreach($estatusOptions as $estatus)
                    <option value="{{ $estatus }}" {{ old('estatus', $proyecto->estatus ?? '') == $estatus ? 'selected' : '' }}>{{ $estatus }}</option>
                @endforeach
            </select>
            {!! $errors->first('estatus', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group mb-3">
            <label for="imagen" class="form-label">{{ __('Imagen') }}</label>
            @if ($proyecto && $proyecto->imagen)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $proyecto->imagen) }}" width="100px" alt="Imagen del Proyecto">
                </div>
            @endif
            <input type="file" name="imagen" class="form-control @error('imagen') is-invalid @enderror" id="imagen" placeholder="Imagen">
            {!! $errors->first('imagen', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">{{ __('Enviar') }}</button>
    </div>
</div>