<?php

namespace App\Http\Controllers\Backend;

use App\Models\Media;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Setting;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(24);
        $settings = Setting::first();
        return view('backend.media.index', compact('media', 'settings'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // Max 5MB
                'alternative_text' => 'nullable|string|max:255',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                // Ensure storage directory exists
                $uploadsPath = storage_path('app/public/uploads');
                if (!file_exists($uploadsPath)) {
                    mkdir($uploadsPath, 0755, true);
                }
                
                // Generate encrypted filename
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $encryptedName = Str::random(40);
                
                // Convert to WebP if not SVG
                if (strtolower($extension) !== 'svg') {
                    $webpFilename = $encryptedName . '.webp';
                    $webpPath = $uploadsPath . '/' . $webpFilename;
                    
                    // Convert to WebP
                    $conversionResult = $this->convertToWebP($file->getRealPath(), $webpPath);
                    
                    if (!$conversionResult) {
                        throw new \Exception('Failed to convert image to WebP');
                    }
                    
                    $finalFilename = $webpFilename;
                    $finalExtension = 'webp';
                } else {
                    // For SVG, just store as is
                    $finalFilename = $encryptedName . '.' . $extension;
                    $file->storeAs('uploads', $finalFilename, 'public');
                    $finalExtension = $extension;
                }
                
                // Get file size after conversion
                $finalPath = storage_path('app/public/uploads/' . $finalFilename);
                $finalSize = file_exists($finalPath) ? filesize($finalPath) : $file->getSize();
                
                // Create media record
                $media = Media::create([
                    'filename' => $originalName . '.' . $extension,
                    'file_encrypt' => $finalFilename,
                    'alternative_text' => $validated['alternative_text'] ?? $originalName,
                    'file_type' => strtolower($finalExtension) === 'svg' ? 'image/svg+xml' : 'image/webp',
                    'file_size' => $finalSize,
                ]);

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Image uploaded successfully!',
                        'media' => $media,
                        'url' => asset('storage/uploads/' . $finalFilename),
                    ]);
                }

                return redirect()->route('backend.media.index')
                               ->with('success', 'Image uploaded and converted to WebP successfully!');
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded',
                ], 400);
            }

            return back()->with('error', 'Failed to upload image.');
            
        } catch (\Exception $e) {
            Log::error('Media upload error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload failed: ' . $e->getMessage(),
                ], 500);
            }
            
            return back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Convert image to WebP format
     */
    private function convertToWebP($sourcePath, $destinationPath, $quality = 85)
    {
        $imageInfo = getimagesize($sourcePath);
        $mimeType = $imageInfo['mime'];

        // Create image resource based on mime type
        switch ($mimeType) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                // Preserve transparency
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                return false;
        }

        if (!$image) {
            return false;
        }

        // Create directory if not exists
        $directory = dirname($destinationPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Convert to WebP
        $result = imagewebp($image, $destinationPath, $quality);
        imagedestroy($image);

        return $result;
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        
        // Delete file from storage
        if (Storage::disk('public')->exists('uploads/' . $media->file_encrypt)) {
            Storage::disk('public')->delete('uploads/' . $media->file_encrypt);
        }
        
        // Delete database record
        $media->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully!',
            ]);
        }

        return redirect()->route('backend.media.index')
                       ->with('success', 'Image deleted successfully!');
    }

    public function getList(Request $request)
    {
        $query = Media::latest();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('filename', 'like', "%{$search}%")
                  ->orWhere('alternative_text', 'like', "%{$search}%");
            });
        }

        $media = $query->paginate(24);

        return response()->json([
            'success' => true,
            'data' => $media->items(),
            'pagination' => [
                'total' => $media->total(),
                'per_page' => $media->perPage(),
                'current_page' => $media->currentPage(),
                'last_page' => $media->lastPage(),
            ]
        ]);
    }
}
