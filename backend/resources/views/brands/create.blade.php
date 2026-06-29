@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-3">Nueva marca</h2>

        <form action="{{ route('brands.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label required">Nombre</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" maxlength="100" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="reference" class="form-label required">Referencia</label>
                <input type="text" id="reference" name="reference" class="form-control @error('reference') is-invalid @enderror"
                       value="{{ old('reference') }}" maxlength="50" pattern="\S+" title="No se permiten espacios" required>
                @error('reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
