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
            'image_type' => 'nullable|in:upload,url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'background_color' => 'nullable|string|max:7',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->image_type === 'upload' && $request->hasFile('image_file')) {
            $validated['image_type'] = 'upload';
            $validated['image_source'] = $this->handleImageUpload($request->file('image_file'));
        } elseif ($request->image_type === 'url' && $request->image_url) {
            $validated['image_type'] = 'url';
            $validated['image_source'] = $request->image_url;
        }

        // Convert HEX color to Tailwind class
        if ($request->background_color) {
            $validated['background_color'] = $this->hexToTailwind($request->background_color);
        }

        // Remove temporary fields that don't exist in database
        unset($validated['image_file'], $validated['image_url']);

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
            'image_type' => 'nullable|in:upload,url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url',
            'background_color' => 'nullable|string|max:7',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->image_type === 'upload' && $request->hasFile('image_file')) {
            // Delete old image if exists and is local upload
            if ($productCategory->image_type === 'upload' && $productCategory->image_source) {
                $this->deleteImage($productCategory->image_source);
            }
            
            $validated['image_type'] = 'upload';
            $validated['image_source'] = $this->handleImageUpload($request->file('image_file'));
        } elseif ($request->image_type === 'url' && $request->image_url) {
            // Delete old image if exists and is local upload
            if ($productCategory->image_type === 'upload' && $productCategory->image_source) {
                $this->deleteImage($productCategory->image_source);
            }
            
            $validated['image_type'] = 'url';
            $validated['image_source'] = $request->image_url;
        }

        // Convert HEX color to Tailwind class
        if ($request->background_color) {
            $validated['background_color'] = $this->hexToTailwind($request->background_color);
        }

        // Remove temporary fields that don't exist in database
        unset($validated['image_file'], $validated['image_url']);

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

        // Delete image if exists and is local upload
        if ($productCategory->image_type === 'upload' && $productCategory->image_source) {
            $this->deleteImage($productCategory->image_source);
        }

        $productCategory->delete();

        return redirect()->route('backend.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }

    /**
     * Handle image upload and convert to WebP
     */
    private function handleImageUpload($file)
    {
        // Generate unique filename
        $filename = uniqid() . '.webp';
        $path = 'storage/product-categories/' . $filename;
        $fullPath = public_path($path);

        // Create directory if not exists
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Get image info
        $imageInfo = getimagesize($file->getRealPath());
        $mimeType = $imageInfo['mime'];

        // Create image resource based on mime type
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $image = imagecreatefrompng($file->getRealPath());
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($file->getRealPath());
                break;
            default:
                // Fallback: just move the file
                $file->move(public_path('storage/product-categories'), $filename);
                return $path;
        }

        // Convert to WebP with quality 80
        imagewebp($image, $fullPath, 80);
        imagedestroy($image);

        return $path;
    }

    /**
     * Delete image from storage
     */
    private function deleteImage($path)
    {
        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Convert HEX color to Tailwind class
     */
    private function hexToTailwind($hex)
    {
        $hex = ltrim($hex, '#');
        
        // Color mapping
        $colors = [
            // Red shades
            'ef4444' => 'bg-red-500',
            'dc2626' => 'bg-red-600',
            'b91c1c' => 'bg-red-700',
            'f87171' => 'bg-red-400',
            'fca5a5' => 'bg-red-300',
            
            // Orange shades
            'f97316' => 'bg-orange-500',
            'ea580c' => 'bg-orange-600',
            'c2410c' => 'bg-orange-700',
            'fb923c' => 'bg-orange-400',
            'fdba74' => 'bg-orange-300',
            
            // Amber shades
            'f59e0b' => 'bg-amber-500',
            'd97706' => 'bg-amber-600',
            'b45309' => 'bg-amber-700',
            'fbbf24' => 'bg-amber-400',
            'fcd34d' => 'bg-amber-300',
            
            // Yellow shades
            'eab308' => 'bg-yellow-500',
            'ca8a04' => 'bg-yellow-600',
            'a16207' => 'bg-yellow-700',
            'facc15' => 'bg-yellow-400',
            'fde047' => 'bg-yellow-300',
            
            // Green shades
            '22c55e' => 'bg-green-500',
            '16a34a' => 'bg-green-600',
            '15803d' => 'bg-green-700',
            '4ade80' => 'bg-green-400',
            '86efac' => 'bg-green-300',
            '10b981' => 'bg-emerald-500',
            '059669' => 'bg-emerald-600',
            
            // Blue shades
            '3b82f6' => 'bg-blue-500',
            '2563eb' => 'bg-blue-600',
            '1d4ed8' => 'bg-blue-700',
            '60a5fa' => 'bg-blue-400',
            '93c5fd' => 'bg-blue-300',
            '06b6d4' => 'bg-cyan-500',
            '0891b2' => 'bg-cyan-600',
            
            // Indigo shades
            '6366f1' => 'bg-indigo-500',
            '4f46e5' => 'bg-indigo-600',
            '4338ca' => 'bg-indigo-700',
            '818cf8' => 'bg-indigo-400',
            'a5b4fc' => 'bg-indigo-300',
            
            // Purple shades
            'a855f7' => 'bg-purple-500',
            '9333ea' => 'bg-purple-600',
            '7e22ce' => 'bg-purple-700',
            'c084fc' => 'bg-purple-400',
            'd8b4fe' => 'bg-purple-300',
            
            // Pink shades
            'ec4899' => 'bg-pink-500',
            'db2777' => 'bg-pink-600',
            'be185d' => 'bg-pink-700',
            'f472b6' => 'bg-pink-400',
            'f9a8d4' => 'bg-pink-300',
            
            // Slate shades
            '64748b' => 'bg-slate-500',
            '475569' => 'bg-slate-600',
            '334155' => 'bg-slate-700',
            '94a3b8' => 'bg-slate-400',
            'cbd5e1' => 'bg-slate-300',
            
            // Gray shades
            '6b7280' => 'bg-gray-500',
            '4b5563' => 'bg-gray-600',
            '374151' => 'bg-gray-700',
            '9ca3af' => 'bg-gray-400',
            'd1d5db' => 'bg-gray-300',
        ];
        
        $hex = strtolower($hex);
        
        // Exact match
        if (isset($colors[$hex])) {
            return $colors[$hex];
        }
        
        // Find closest color
        $minDistance = PHP_INT_MAX;
        $closestClass = 'bg-gray-500';
        
        foreach ($colors as $colorHex => $class) {
            $distance = $this->colorDistance($hex, $colorHex);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $closestClass = $class;
            }
        }
        
        return $closestClass;
    }

    /**
     * Calculate color distance between two HEX colors
     */
    private function colorDistance($hex1, $hex2)
    {
        $rgb1 = $this->hexToRgb($hex1);
        $rgb2 = $this->hexToRgb($hex2);
        
        $rDiff = $rgb1['r'] - $rgb2['r'];
        $gDiff = $rgb1['g'] - $rgb2['g'];
        $bDiff = $rgb1['b'] - $rgb2['b'];
        
        return sqrt($rDiff * $rDiff + $gDiff * $gDiff + $bDiff * $bDiff);
    }

    /**
     * Convert HEX to RGB
     */
    private function hexToRgb($hex)
    {
        $hex = ltrim($hex, '#');
        
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    /**
     * Get list of product categories for AJAX/API requests
     * Used by page builder for hero banner dropdown
     */
    public function getList()
    {
        try {
            $categories = ProductCategory::select('id', 'name')
                ->where('status', 'active')
                ->orderBy('name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
