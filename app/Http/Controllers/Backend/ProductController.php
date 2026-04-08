<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('backend.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::where('status', 'active')->orderBy('name')->get();
        return view('backend.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'products_code' => 'required|string|max:255|unique:products,products_code',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'product_categories_id' => 'required|exists:product_categories,id',
            'overview' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'is_featured' => 'nullable|in:yes,no',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|string|max:500',
            'image_title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['is_featured'] = $validated['is_featured'] ?? 'no';

        Product::create($validated);

        return redirect()->route('backend.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('status', 'active')->orderBy('name')->get();
        return view('backend.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'products_code' => 'required|string|max:255|unique:products,products_code,' . $product->id,
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'product_categories_id' => 'required|exists:product_categories,id',
            'overview' => 'nullable|string',
            'content' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
            'is_featured' => 'nullable|in:yes,no',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|string|max:500',
            'image_title' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['is_featured'] = $validated['is_featured'] ?? 'no';

        $product->update($validated);

        return redirect()->route('backend.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('backend.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
