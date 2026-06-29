<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $brands = Brand::withCount('products')
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('reference', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('brands.index', compact('brands', 'search'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'reference' => 'required|string|max:50|unique:brands,reference|regex:/^\S+$/',
        ], [
            'reference.regex' => 'La referencia no puede contener espacios.',
        ]);

        Brand::create($request->only('name', 'reference'));

        return redirect()->route('brands.index')->with('success', 'Marca creada.');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'reference' => 'required|string|max:50|unique:brands,reference,' . $brand->id . '|regex:/^\S+$/',
        ], [
            'reference.regex' => 'La referencia no puede contener espacios.',
        ]);

        $brand->update($request->only('name', 'reference'));

        return redirect()->route('brands.index')->with('success', 'Marca actualizada.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return redirect()->route('brands.index')->with('error', 'No se puede eliminar la marca porque tiene productos asociados.');
        }

        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Marca eliminada.');
    }
}
