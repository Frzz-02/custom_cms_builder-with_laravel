<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SectionBrand;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = SectionBrand::latest()->get();
        $settings = Setting::first();
        return view('backend.brands.index', compact('brands', 'settings'));
    }

    public function create()
    {
        $settings = Setting::first();
        return view('backend.brands.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string|max:2048',
            'url' => 'nullable|url|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['logo'] = $this->normalizeLogoPath($validated['logo'] ?? null);

        SectionBrand::create($validated);

        return redirect()->route('backend.brands.index')
            ->with('success', 'Brand created successfully.');
    }

    public function edit(SectionBrand $brand)
    {
        $settings = Setting::first();
        return view('backend.brands.edit', compact('brand', 'settings'));
    }

    public function update(Request $request, SectionBrand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|string|max:2048',
            'url' => 'nullable|url|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['logo'] = $this->normalizeLogoPath($validated['logo'] ?? null);
        
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

    private function normalizeLogoPath(?string $logo): ?string
    {
        $value = trim((string) $logo);

        if ($value === '') {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $value)) {
            $path = parse_url($value, PHP_URL_PATH) ?: '';

            if (Str::startsWith($path, '/storage/')) {
                return $path;
            }

            return $value;
        }

        if (Str::startsWith($value, 'storage/')) {
            return '/' . $value;
        }

        return $value;
    }
}
