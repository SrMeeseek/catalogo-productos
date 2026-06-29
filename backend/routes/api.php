<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', function (Request $request) {
    $search = $request->input('q');

    return Product::with('brand')
        ->when($search, fn($q) => $q->where('products.name', 'like', "%{$search}%")
            ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%")))
        ->orderBy('products.name')
        ->paginate(12);
});
