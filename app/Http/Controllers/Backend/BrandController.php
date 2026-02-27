<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SectionBrand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = SectionBrand::latest()->get();
        return view('backend.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('backend.brands.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|url|max:500',
            'url' => 'nullable|url|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        SectionBrand::create($validated);

        return redirect()->route('backend.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function edit(SectionBrand $brand)
    {
        return view('backend.brands.edit', compact('brand'));
    }

    public function update(Request $request, SectionBrand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|url|max:500',
            'url' => 'nullable|url|max:500',
            'status' => 'required|in:active,inactive',
        ]);
        
        $brand->update($validated);

        return redirect()->route('backend.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(SectionBrand $brand)
    {
        $brand->delete();

        return redirect()->route('backend.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
