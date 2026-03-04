<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SectionServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = SectionService::latest()->paginate(10);
        return view('backend.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:section_service,slug',
            'status' => 'required|in:active,inactive',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_featured' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
        ]);

        // Handle is_featured checkbox
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Handle image upload with WebP conversion
        if ($request->hasFile('image')) {
            $validated['image'] = $this->convertToWebP($request->file('image'), 'services');
        }

        // Handle featured image upload with WebP conversion
        if ($request->hasFile('image_featured')) {
            $validated['image_featured'] = $this->convertToWebP($request->file('image_featured'), 'services/featured');
        }

        SectionService::create($validated);

        return redirect()->route('backend.services.index')
            ->with('success', 'Service created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SectionService $service)
    {
        return view('backend.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SectionService $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:section_service,slug,' . $service->id,
            'status' => 'required|in:active,inactive',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_featured' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
        ]);

        // Handle is_featured checkbox
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Handle image upload with WebP conversion
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            
            $validated['image'] = $this->convertToWebP($request->file('image'), 'services');
        }

        // Handle featured image upload with WebP conversion
        if ($request->hasFile('image_featured')) {
            // Delete old featured image if exists
            if ($service->image_featured && Storage::disk('public')->exists($service->image_featured)) {
                Storage::disk('public')->delete($service->image_featured);
            }
            
            $validated['image_featured'] = $this->convertToWebP($request->file('image_featured'), 'services/featured');
        }

        $service->update($validated);

        return redirect()->route('backend.services.index')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SectionService $service)
    {
        // Delete images if exist
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }
        
        if ($service->image_featured && Storage::disk('public')->exists($service->image_featured)) {
            Storage::disk('public')->delete($service->image_featured);
        }

        $service->delete();

        return redirect()->route('backend.services.index')
            ->with('success', 'Service deleted successfully!');
    }

    /**
     * Generate slug from name
     */
    public function generateSlug(Request $request)
    {
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
    }

    /**
     * Convert uploaded image to WebP format
     */
    private function convertToWebP($file, $folder = 'services')
    {
        try {
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.webp';
            $path = $folder . '/' . $filename;
            $fullPath = storage_path('app/public/' . $path);

            // Create directory if not exists
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // Get image resource based on file type
            $image = null;
            $mimeType = $file->getMimeType();

            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $image = imagecreatefromjpeg($file->getRealPath());
                    break;
                case 'image/png':
                    $image = imagecreatefrompng($file->getRealPath());
                    // Preserve transparency for PNG
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    break;
                case 'image/gif':
                    $image = imagecreatefromgif($file->getRealPath());
                    break;
                case 'image/webp':
                    $image = imagecreatefromwebp($file->getRealPath());
                    break;
            }

            if ($image) {
                // Convert to WebP with 85% quality
                imagewebp($image, $fullPath, 85);
                imagedestroy($image);
                
                return $path;
            }

            // Fallback to regular storage if conversion fails
            return $file->store($folder, 'public');
        } catch (\Exception $e) {
            // If conversion fails, store the original file
            return $file->store($folder, 'public');
        }
    }
}
