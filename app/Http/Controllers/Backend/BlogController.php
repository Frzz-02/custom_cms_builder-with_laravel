<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Setting;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->orderBy('created_at', 'desc')->paginate(10);
        $settings = Setting::first();
        return view('backend.blogs.index', compact('blogs','settings'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->get();
        $settings = Setting::first();
        return view('backend.blogs.create', compact('categories', 'settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blogs,slug',
            'name' => 'nullable|string|max:255',
            'blog_categories_id' => 'nullable|exists:blog_categories,id',
            'author' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|in:0,1',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'image_featured' => 'nullable|string|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set is_featured to 0 if not checked
        $validated['is_featured'] = $request->has('is_featured') ? '1' : '0';

        // Auto-set publish_date when status is published
        if ($validated['status'] === 'published') {
            $validated['publish_date'] = now();
        }

        $validated['image'] = $this->normalizeImageInput($validated['image'] ?? null);
        $validated['image_featured'] = $this->normalizeImageInput($validated['image_featured'] ?? null);

        Blog::create($validated);

        return redirect()->route('backend.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::active()->get();
        $settings = Setting::first();
        return view('backend.blogs.edit', compact('blog', 'categories', 'settings'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blogs,slug,' . $blog->id,
            'name' => 'nullable|string|max:255',
            'blog_categories_id' => 'nullable|exists:blog_categories,id',
            'author' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
            'is_featured' => 'nullable|in:0,1',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'image_featured' => 'nullable|string|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Set is_featured to 0 if not checked
        $validated['is_featured'] = $request->has('is_featured') ? '1' : '0';

        // Auto-set publish_date when changing from draft to published
        if ($validated['status'] === 'published' && $blog->status === 'draft' && !$blog->publish_date) {
            $validated['publish_date'] = now();
        }

        $oldImage = $blog->image;
        $oldFeaturedImage = $blog->image_featured;

        $validated['image'] = $this->normalizeImageInput($validated['image'] ?? null);
        $validated['image_featured'] = $this->normalizeImageInput($validated['image_featured'] ?? null);

        if ($oldImage !== $validated['image'] && $this->isLocalImagePath($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        if ($oldFeaturedImage !== $validated['image_featured'] && $this->isLocalImagePath($oldFeaturedImage)) {
            Storage::disk('public')->delete($oldFeaturedImage);
        }

        $blog->update($validated);

        return redirect()->route('backend.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        // Delete images
        if ($this->isLocalImagePath($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }
        if ($this->isLocalImagePath($blog->image_featured)) {
            Storage::disk('public')->delete($blog->image_featured);
        }

        $blog->delete();

        return redirect()->route('backend.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    private function normalizeImageInput(?string $image): ?string
    {
        $value = trim((string) $image);

        if ($value === '') {
            return null;
        }

        if (preg_match('/^data:image/i', $value)) {
            return $value;
        }

        if (preg_match('/^https?:\/\//i', $value)) {
            $path = parse_url($value, PHP_URL_PATH) ?: '';

            if (Str::startsWith($path, '/storage/')) {
                return ltrim(preg_replace('#^/storage/#', '', $path), '/');
            }

            return $value;
        }

        if (Str::startsWith($value, '/storage/')) {
            return ltrim(preg_replace('#^/storage/#', '', $value), '/');
        }

        if (Str::startsWith($value, 'storage/')) {
            return ltrim(preg_replace('#^storage/#', '', $value), '/');
        }

        return ltrim($value, '/');
    }

    private function isLocalImagePath(?string $value): bool
    {
        if (!$value) {
            return false;
        }

        return !preg_match('/^(https?:\/\/|data:image)/i', $value);
    }

    /**
     * Convert uploaded image to WebP format
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string Path to the saved WebP image
     */
    private function convertToWebP($file, $directory)
    {
        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.webp';
        $path = $directory . '/' . $filename;
        $fullPath = storage_path('app/public/' . $path);
        
        // Ensure directory exists
        $directoryPath = storage_path('app/public/' . $directory);
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        // Get the uploaded file's temporary path
        $sourcePath = $file->getRealPath();
        $mimeType = $file->getMimeType();

        // Create image resource based on mime type
        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                // Preserve transparency
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                // If format not supported, use regular storage
                return $file->store($directory, 'public');
        }

        if (!$image) {
            // If image creation failed, fallback to regular storage
            return $file->store($directory, 'public');
        }

        // Convert to WebP with quality 85 (good balance between quality and size)
        imagewebp($image, $fullPath, 85);
        
        // Free up memory
        imagedestroy($image);

        return $path;
    }
}
