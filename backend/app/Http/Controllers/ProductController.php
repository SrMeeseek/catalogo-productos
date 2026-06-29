<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $products = Product::with('brand')
            ->when($search, fn($q) => $q->where('products.name', 'like', "%{$search}%")
                ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%")))
            ->orderBy('products.name')
            ->paginate(15)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name')->get();
        return view('products.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'unit' => 'required|in:Unidad,Display,Caja',
            'observations' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'unit', 'observations', 'brand_id', 'stock', 'price');

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeAsWebp($request->file('image'));
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Producto creado.');
    }

    public function edit(Product $product)
    {
        $brands = Brand::orderBy('name')->get();
        return view('products.edit', compact('product', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'unit' => 'required|in:Unidad,Display,Caja',
            'observations' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'stock' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'unit', 'observations', 'brand_id', 'stock', 'price');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->storeAsWebp($request->file('image'));
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }

    private function storeAsWebp(UploadedFile $file): string
    {
        $source = match (exif_imagetype($file->getRealPath())) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($file->getRealPath()),
            IMAGETYPE_PNG => imagecreatefrompng($file->getRealPath()),
            IMAGETYPE_GIF => imagecreatefromgif($file->getRealPath()),
            IMAGETYPE_WEBP => imagecreatefromwebp($file->getRealPath()),
            default => imagecreatefromstring(file_get_contents($file->getRealPath())),
        };

        $origW = imagesx($source);
        $origH = imagesy($source);

        if ($origW > 800) {
            $newW  = 800;
            $newH  = (int) round($origH * 800 / $origW);
            $image = imagecreatetruecolor($newW, $newH);
            imagecopyresampled($image, $source, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
            imagedestroy($source);
        } else {
            $image = $source;
        }

        $filename = 'products/' . Str::uuid() . '.webp';
        $path     = Storage::disk('public')->path($filename);

        Storage::disk('public')->makeDirectory('products');
        imagewebp($image, $path, 80);
        imagedestroy($image);

        return $filename;
    }
}
