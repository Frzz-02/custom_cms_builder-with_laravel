<?php

namespace App\Http\Controllers\Backend;

use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')->latest()->get();
        return view('backend.product-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.product-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        ProductCategory::create($validated);

        return redirect()->route('backend.product-categories.index')
            ->with('success', 'Product category created successfully.');
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('backend.product-categories.edit', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug,' . $productCategory->id,
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $productCategory->update($validated);

        return redirect()->route('backend.product-categories.index')
            ->with('success', 'Product category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->count() > 0) {
            return redirect()->route('backend.product-categories.index')
                ->with('error', 'Cannot delete category with existing products.');
        }

        $productCategory->delete();

        return redirect()->route('backend.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }
}
