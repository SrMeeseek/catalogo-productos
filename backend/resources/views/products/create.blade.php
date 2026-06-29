@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <h2 class="mb-3">Nuevo producto</h2>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label required">Nombre</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" maxlength="150" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="unit" class="form-label required">Unidad de medida</label>
                <select id="unit" name="unit" class="form-select @error('unit') is-invalid @enderror" required>
                    <option value="">Seleccionar...</option>
                    @foreach (['Unidad', 'Display', 'Caja'] as $unit)
                        <option value="{{ $unit }}" {{ old('unit') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                    @endforeach
                </select>
                @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="brand_id" class="form-label required">Marca</label>
                <select id="brand_id" name="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                    <option value="">Seleccionar...</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }} ({{ $brand->reference }})
                        </option>
                    @endforeach
                </select>
                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label required">Precio</label>
                <input type="text" inputmode="numeric" pattern="[0-9]+" id="price" name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" placeholder="$ 1.234"
                       oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label required">Stock</label>
                <input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', 0) }}" min="0" required>
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="observations" class="form-label required">Observaciones</label>
                <textarea id="observations" name="observations" rows="4" maxlength="255"
                          class="form-control @error('observations') is-invalid @enderror" required>{{ old('observations') }}</textarea>
                @error('observations') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Imagen del producto</label>
                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"
                       accept="image/*">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Opcional. Máximo 2MB. Formatos: JPG, PNG, GIF, WEBP.</div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
