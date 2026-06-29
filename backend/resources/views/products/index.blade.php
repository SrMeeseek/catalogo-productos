@use('Illuminate\Support\Facades\Storage')
@extends('layouts.app')

@section('content')
<style>
    .img-placeholder {
        width: 56px; height: 56px;
        background: #e9ecef;
        border-radius: 4px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        color: #adb5bd; font-size: 0.6rem; gap: 2px;
    }
    .img-placeholder svg { width: 22px; height: 22px; fill: #adb5bd; }
    .product-thumb { width: 56px; height: 56px; object-fit: cover; border-radius: 4px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Productos</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Nuevo producto</a>
</div>

<form method="GET" action="{{ route('products.index') }}" class="mb-3">
    <div class="input-group">
        <label for="q" class="visually-hidden">Buscar producto</label>
        <input type="text" id="q" name="q" class="form-control" placeholder="Buscar por nombre o marca..."
               value="{{ $search ?? '' }}">
        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        @if ($search)
            <a href="{{ route('products.index') }}" class="btn btn-outline-danger">Limpiar</a>
        @endif
    </div>
</form>

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Unidad</th>
            <th>Marca</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Actualizado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
            <tr>
                <td>
                    @if ($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-thumb">
                    @else
                        <div class="img-placeholder">
                            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2ZM5 5h14v9.586l-3-3-4.293 4.293-2-2L5 18.172V5Zm0 14v-.414l4.707-4.707 2 2L16 12l3 3V19H5Z"/>
                            </svg>
                            Sin imagen
                        </div>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->brand->name }}</td>
                <td>${{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('¿Eliminar este producto?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">
                    {{ $search ? 'No se encontraron productos para "' . $search . '".' : 'Sin productos registrados.' }}
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>

{{ $products->links() }}
@endsection
