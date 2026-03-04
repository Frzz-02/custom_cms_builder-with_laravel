<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SectionTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionTestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = SectionTestimonial::latest()->paginate(10);
        return view('backend.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'content' => 'nullable|string',
            'star' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload with WebP conversion
        if ($request->hasFile('image')) {
            $validated['image'] = $this->convertToWebP($request->file('image'));
        }

        SectionTestimonial::create($validated);

        return redirect()->route('backend.testimonials.index')
            ->with('success', 'Testimonial created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SectionTestimonial $testimonial)
    {
        return view('backend.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SectionTestimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'content' => 'nullable|string',
            'star' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload with WebP conversion
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }
            
            $validated['image'] = $this->convertToWebP($request->file('image'));
        }

        $testimonial->update($validated);

        return redirect()->route('backend.testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SectionTestimonial $testimonial)
    {
        // Delete image if exists
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return redirect()->route('backend.testimonials.index')
            ->with('success', 'Testimonial deleted successfully!');
    }

    /**
     * Convert uploaded image to WebP format
     */
    private function convertToWebP($file)
    {
        try {
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . uniqid() . '.webp';
            $path = 'testimonials/' . $filename;
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
            return $file->store('testimonials', 'public');
        } catch (\Exception $e) {
            // If conversion fails, store the original file
            return $file->store('testimonials', 'public');
        }
    }
}
