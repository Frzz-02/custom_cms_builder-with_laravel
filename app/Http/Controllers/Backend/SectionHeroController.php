<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SectionHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class SectionHeroController extends Controller
{


    /**
     * Store hero banner via AJAX
     */
    public function storeAjax(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string|max:255',
                'title_2' => 'nullable|string|max:255',
                'title_3' => 'nullable|string|max:255',
                'subtitle_1' => 'nullable|string|max:255',
                'subtitle_2' => 'nullable|string|max:255',
                'subtitle_3' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'description_2' => 'nullable|string',
                'description_3' => 'nullable|string',
                // Images: can be file upload or URL string
                'image' => 'nullable',
                'image_2' => 'nullable',
                'image_3' => 'nullable',
                'image_background' => 'nullable',
                'image_background_2' => 'nullable',
                'image_background_3' => 'nullable',
                'action_label' => 'nullable|string|max:255',
                'action_label_2' => 'nullable|string|max:255',
                'action_label_3' => 'nullable|string|max:255',
                // Action URLs: can be external (https://...) or internal (/produk)
                'action_url' => 'nullable|string|max:255',
                'action_url_2' => 'nullable|string|max:255',
                'action_url_3' => 'nullable|string|max:255',
            ]);

            // Handle image uploads or URLs
            $imageFields = ['image', 'image_2', 'image_3', 'image_background', 'image_background_2', 'image_background_3'];
            
            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    // If file uploaded, store it
                    $validated[$field] = $request->file($field)->store('hero_images', 'public');
                } elseif ($request->filled($field)) {
                    // If URL provided, keep it as is
                    $validated[$field] = $request->input($field);
                }
            }

            $hero = SectionHero::create($validated);

            return response()->json([
                'success' => true,
                'data' => $hero,
                'message' => 'Hero banner created successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating hero banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show hero banner via AJAX
     */
    public function showAjax($id)
    {
        try {
            $hero = SectionHero::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $hero
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching hero banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete hero banner via AJAX
     */
    public function deleteAjax($id)
    {
        try {
            $hero = SectionHero::findOrFail($id);
            $hero->delete();

            return response()->json([
                'success' => true,
                'message' => 'Hero banner deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting hero banner: ' . $e->getMessage()
            ], 500);
        }
    }
}
