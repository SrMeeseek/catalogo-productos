@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Marcas</h2>
    <a href="{{ route('brands.create') }}" class="btn btn-primary">Nueva marca</a>
</div>

<form method="GET" action="{{ route('brands.index') }}" class="mb-3">
    <div class="input-group">
        <label for="q" class="visually-hidden">Buscar marca</label>
        <input type="text" id="q" name="q" class="form-control" placeholder="Buscar por nombre o referencia..."
               value="{{ $search ?? '' }}">
        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        @if ($search)
            <a href="{{ route('brands.index') }}" class="btn btn-outline-danger">Limpiar</a>
        @endif
    </div>
</form>

<div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Referencia</th>
            <th>Nombre</th>
            <th>Productos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($brands as $brand)
            <tr>
                <td>{{ $brand->reference }}</td>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->products_count }}</td>
                <td>
                    <a href="{{ route('brands.edit', $brand) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('¿Eliminar esta marca?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">
                    {{ $search ? 'No se encontraron marcas para "' . $search . '".' : 'Sin marcas registradas.' }}
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>

{{ $brands->links() }}
@endsection
