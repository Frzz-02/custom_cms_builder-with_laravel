<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PageShortcode;
use App\Models\SectionTestimonial;
use App\Models\SectionService;
use App\Models\SectionNewsletter;
use App\Models\Contact;
use App\Models\SectionHero;
use App\Models\SectionAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageShortcodeController extends Controller
{
    public function getTestimonialsList()
    {
        $testimonials = SectionTestimonial::select('id', 'name', 'position', 'content', 'star', 'status')
            ->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(status)'), ['active', 'aktif'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'testimonials' => $testimonials
        ]);
    }
    
    public function getServicesList()
    {
        $services = SectionService::select('id', 'name', 'slug', 'status')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'services' => $services
        ]);
    }
    
    public function getSectionNewslettersList()
    {
        $newsletters = SectionNewsletter::select('id', 'title', 'status')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'newsletters' => $newsletters
        ]);
    }
    
    public function getContactsList()
    {
        $contacts = Contact::select('id', 'title', 'contact_1', 'status')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($contacts);
    }
    
    public function store(Request $request)
    {
        try {
            if ($request->has('section_testimoni_id') && is_string($request->section_testimoni_id)) {
                $normalizedTestimoniIds = [];
                $decodedTestimoniIds = json_decode($request->section_testimoni_id, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedTestimoniIds)) {
                    $normalizedTestimoniIds = $decodedTestimoniIds;
                } else {
                    $normalizedTestimoniIds = array_map('trim', explode(',', $request->section_testimoni_id));
                }

                $request->merge([
                    'section_testimoni_id' => array_values(array_filter($normalizedTestimoniIds, static function ($id) {
                        return is_numeric($id) && (int) $id > 0;
                    })),
                ]);
            }

            $validated = $request->validate([
                // Common fields for title, simple-text, text-editor
                'title' => 'nullable|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'heading' => 'nullable|string|max:255',
                'content' => 'nullable|string',
                // Hero banner fields
                'hero_style' => 'nullable|string|max:255',
                'hero_data' => 'nullable|array',
                'product_category_id' => 'nullable|array',
                'product_category_id.*' => 'integer',
                // About fields
                'about_style' => 'nullable|string|max:255',
                'about_data' => 'nullable|array',
                // Complex block fields
                'testimonials_title' => 'nullable|string|max:255',
                'testimonials_subtitle' => 'nullable|string|max:255',
                'testimonials_style' => 'nullable|string|max:255',
                'section_testimoni_id' => 'nullable|array',
                'section_testimoni_id.*' => 'integer',
                'product_title' => 'nullable|string|max:255',
                'product_subtitle' => 'nullable|string|max:255',
                'product_category_limit' => 'nullable|integer|min:1|max:100',
                'product_category_style' => 'nullable|integer',
                'service_style' => 'nullable|string|max:255',
                'section_service_id' => 'nullable|array',
                'section_service_id.*' => 'integer',
                'section_brand_id' => 'nullable|array',
                'section_brand_id.*' => 'integer',
                'section_completecount_id' => 'nullable|array',
                'section_completecount_id.*' => 'integer',
                'section_newsletter_id' => 'nullable|integer',
                'latestnews_title' => 'nullable|string|max:255',
                'blog_limit' => 'nullable|integer',
                'latestnews_style' => 'nullable|string|max:255',
                'comingsoon_image' => 'nullable|string|max:255',
                'comingsoon_title' => 'nullable|string|max:255',
                'comingsoon_subtitle' => 'nullable|string|max:255',
                'comingsoon_placeholder' => 'nullable|string|max:255',
                'contact_title_1' => 'nullable|string|max:255',
                'contact_subtitle' => 'nullable|string|max:255',
                'contact_id' => 'nullable|array',
                'contact_id.*' => 'integer',
                'pages_id' => 'required|integer|exists:pages,id',
                'sort_id' => 'nullable|integer',
                'type' => 'required|string|max:255',
            ]);
        
        // Handle hero banner - create section_hero record
        if ($request->type === 'hero-banner' && isset($validated['hero_data'])) {
            $heroStyle = $validated['hero_style'] ?? '1';
            $sectionHero = $this->createOrUpdateSectionHero($validated['hero_data'], null, $heroStyle);
            $validated['section_hero_id'] = $sectionHero->id;
        }
        
        // Handle about - create section_about record
        if ($request->type === 'about' && isset($validated['about_data'])) {
            $aboutStyle = $validated['about_style'] ?? '1';
            $sectionAbout = $this->createOrUpdateSectionAbout($validated['about_data'], null, $aboutStyle);
            $validated['section_about_id'] = $sectionAbout->id;
        }
        
        // Convert array to JSON if needed
        if (isset($validated['product_category_id']) && is_array($validated['product_category_id'])) {
            $validated['product_category_id'] = json_encode($validated['product_category_id']);
        }
        
        if (isset($validated['section_service_id']) && is_array($validated['section_service_id'])) {
            $validated['section_service_id'] = json_encode($validated['section_service_id']);
        }
        
        if (isset($validated['section_testimoni_id']) && is_array($validated['section_testimoni_id'])) {
            $validated['section_testimoni_id'] = json_encode($validated['section_testimoni_id']);
        }
        
        if (isset($validated['section_brand_id']) && is_array($validated['section_brand_id'])) {
            $validated['section_brand_id'] = json_encode($validated['section_brand_id']);
        }
        
        if (isset($validated['section_completecount_id']) && is_array($validated['section_completecount_id'])) {
            $validated['section_completecount_id'] = json_encode($validated['section_completecount_id']);
        }
        
        if (isset($validated['contact_id']) && is_array($validated['contact_id'])) {
            $validated['contact_id'] = json_encode($validated['contact_id']);
        }
        
            // Remove hero_data dan about_data dari validated karena tidak ada di table page_shortcodes
            unset($validated['hero_data']);
            unset($validated['about_data']);
            
            $shortcode = PageShortcode::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Page shortcode created successfully',
                'shortcode_id' => $shortcode->id, // ⭐ Return shortcode_id langsung sesuai yang diharapkan JS
                'data' => $shortcode
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $shortcode = PageShortcode::findOrFail($id);

            if ($request->has('section_testimoni_id') && is_string($request->section_testimoni_id)) {
                $normalizedTestimoniIds = [];
                $decodedTestimoniIds = json_decode($request->section_testimoni_id, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedTestimoniIds)) {
                    $normalizedTestimoniIds = $decodedTestimoniIds;
                } else {
                    $normalizedTestimoniIds = array_map('trim', explode(',', $request->section_testimoni_id));
                }

                $request->merge([
                    'section_testimoni_id' => array_values(array_filter($normalizedTestimoniIds, static function ($id) {
                        return is_numeric($id) && (int) $id > 0;
                    })),
                ]);
            }
            
            $validated = $request->validate([
            // Common fields for title, simple-text, text-editor
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            // Hero banner fields
            'hero_style' => 'nullable|string|max:255',
            'hero_data' => 'nullable|array',
            'product_category_id' => 'nullable|array',
            'product_category_id.*' => 'integer',
            // About fields
            'about_style' => 'nullable|string|max:255',
            'about_data' => 'nullable|array',
            // Complex block fields
            'testimonials_title' => 'nullable|string|max:255',
            'testimonials_subtitle' => 'nullable|string|max:255',
            'testimonials_style' => 'nullable|string|max:255',
            'section_testimoni_id' => 'nullable|array',
            'section_testimoni_id.*' => 'integer',
            'product_title' => 'nullable|string|max:255',
            'product_subtitle' => 'nullable|string|max:255',
            'product_category_limit' => 'nullable|integer|min:1|max:100',
            'product_category_style' => 'nullable|integer',
            'service_style' => 'nullable|string|max:255',
            'section_service_id' => 'nullable|array',
            'section_service_id.*' => 'integer',
            'section_brand_id' => 'nullable|array',
            'section_brand_id.*' => 'integer',
            'section_completecount_id' => 'nullable|array',
            'section_completecount_id.*' => 'integer',
            'section_newsletter_id' => 'nullable|integer',
            'latestnews_title' => 'nullable|string|max:255',
            'blog_limit' => 'nullable|integer',
            'latestnews_style' => 'nullable|string|max:255',
            'comingsoon_image' => 'nullable|string|max:255',
            'comingsoon_title' => 'nullable|string|max:255',
            'comingsoon_subtitle' => 'nullable|string|max:255',
            'comingsoon_placeholder' => 'nullable|string|max:255',
            'contact_title_1' => 'nullable|string|max:255',
            'contact_subtitle' => 'nullable|string|max:255',
            'contact_id' => 'nullable|array',
            'contact_id.*' => 'integer',
            'sort_id' => 'nullable|integer',
            
        ]);
        
        // Handle hero banner - update existing or create new section_hero record
        if ($request->type === 'hero-banner' && isset($validated['hero_data'])) {
            $sectionHeroId = $shortcode->section_hero_id;
            $heroStyle = $validated['hero_style'] ?? '1';
            $sectionHero = $this->createOrUpdateSectionHero($validated['hero_data'], $sectionHeroId, $heroStyle);
            $validated['section_hero_id'] = $sectionHero->id;
        }
        
        // Handle about - update section_about record
        if ($request->type === 'about' && isset($validated['about_data'])) {
            $sectionAboutId = $shortcode->section_about_id;
            $aboutStyle = $validated['about_style'] ?? '1';
            $sectionAbout = $this->createOrUpdateSectionAbout($validated['about_data'], $sectionAboutId, $aboutStyle);
            $validated['section_about_id'] = $sectionAbout->id;
        }
        
        // Convert array to JSON if needed
        if (isset($validated['product_category_id']) && is_array($validated['product_category_id'])) {
            $validated['product_category_id'] = json_encode($validated['product_category_id']);
        }
        
        if (isset($validated['section_service_id']) && is_array($validated['section_service_id'])) {
            $validated['section_service_id'] = json_encode($validated['section_service_id']);
        }
        
        if (isset($validated['section_testimoni_id']) && is_array($validated['section_testimoni_id'])) {
            $validated['section_testimoni_id'] = json_encode($validated['section_testimoni_id']);
        }
        
        if (isset($validated['section_brand_id']) && is_array($validated['section_brand_id'])) {
            $validated['section_brand_id'] = json_encode($validated['section_brand_id']);
        }
        
        if (isset($validated['section_completecount_id']) && is_array($validated['section_completecount_id'])) {
            $validated['section_completecount_id'] = json_encode($validated['section_completecount_id']);
        }
        
        if (isset($validated['contact_id']) && is_array($validated['contact_id'])) {
            $validated['contact_id'] = json_encode($validated['contact_id']);
        }
        
            // Remove hero_data dan about_data dari validated karena tidak ada di table page_shortcodes
            unset($validated['hero_data']);
            unset($validated['about_data']);
            
            $shortcode->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Page shortcode updated successfully',
                'shortcode_id' => $shortcode->id, // ⭐ Return shortcode_id langsung sesuai yang diharapkan JS
            'data' => $shortcode->fresh()
        ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        $shortcode = PageShortcode::findOrFail($id);
        
        // Jika ada section_hero_id, hapus juga record di section_hero
        if ($shortcode->section_hero_id) {
            $sectionHero = SectionHero::find($shortcode->section_hero_id);
            if ($sectionHero) {
                // Delete semua images dari storage
                $imageFields = ['image', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6', 'image_7', 'image_8', 'image_9', 'image_10', 'image_11', 'image_12', 'image_13'];
                foreach ($imageFields as $field) {
                    if ($sectionHero->$field) {
                        Storage::disk('public')->delete($sectionHero->$field);
                    }
                }
                
                $sectionHero->delete();
            }
        }
        
        // Jika ada section_about_id, hapus juga record di section_about
        if ($shortcode->section_about_id) {
            $sectionAbout = SectionAbout::find($shortcode->section_about_id);
            if ($sectionAbout) {
                // Delete semua images dari storage
                $imageFields = ['image_1_source', 'image_2_source', 'image_3_source'];
                foreach ($imageFields as $field) {
                    if ($sectionAbout->$field) {
                        Storage::disk('public')->delete($sectionAbout->$field);
                    }
                }
                
                $sectionAbout->delete();
            }
        }
        
        $shortcode->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Page shortcode deleted successfully'
        ]);
    }
    
    /**
     * Get a single shortcode by ID
     */
    public function show($id)
    {
        $shortcode = PageShortcode::with(['hero', 'about'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $shortcode
        ]);
    }
    
    /**
     * Create or update section_hero record from hero_data
     * 
     * @param array $heroData - Data dari tabs (structure depends on style)
     * @param int|null $sectionHeroId - ID untuk update existing record
     * @param string $heroStyle - Style 1, 2, or 3
     * @return SectionHero
     */
    private function createOrUpdateSectionHero($heroData, $sectionHeroId = null, $heroStyle = '1')
    {
        // Prepare data untuk section_hero table
        $data = [];
        
        // Handle based on style
        if ($heroStyle === '1') {
            // Style 1: 6 tabs dengan product categories, each tab has: category_id, title, description, action_label, action_url, image
            // Map data dari 6 tabs ke fields di section_hero
        // Tab 1: title, description, action_label, action_url, image
        if (isset($heroData['tab1'])) {
            $data['title'] = $heroData['tab1']['title'] ?? null;
            $data['description'] = $heroData['tab1']['description'] ?? null;
            $data['action_label'] = $heroData['tab1']['action_label'] ?? null;
            $data['action_url'] = $heroData['tab1']['action_url'] ?? null;
            if (!empty($heroData['tab1']['image'])) {
                $data['image'] = $this->saveBase64Image($heroData['tab1']['image'], 'hero');
            }
        }
        
        // Tab 2: title_2, description_2, action_label_2, action_url_2, image_2
        if (isset($heroData['tab2'])) {
            $data['title_2'] = $heroData['tab2']['title'] ?? null;
            $data['description_2'] = $heroData['tab2']['description'] ?? null;
            $data['action_label_2'] = $heroData['tab2']['action_label'] ?? null;
            $data['action_url_2'] = $heroData['tab2']['action_url'] ?? null;
            if (!empty($heroData['tab2']['image'])) {
                $data['image_2'] = $this->saveBase64Image($heroData['tab2']['image'], 'hero');
            }
        }
        
        // Tab 3: title_3, description_3, action_label_3, action_url_3, image_3
        if (isset($heroData['tab3'])) {
            $data['title_3'] = $heroData['tab3']['title'] ?? null;
            $data['description_3'] = $heroData['tab3']['description'] ?? null;
            $data['action_label_3'] = $heroData['tab3']['action_label'] ?? null;
            $data['action_url_3'] = $heroData['tab3']['action_url'] ?? null;
            if (!empty($heroData['tab3']['image'])) {
                $data['image_3'] = $this->saveBase64Image($heroData['tab3']['image'], 'hero');
            }
        }
        
        // Tab 4: title_4, description_4, action_label_4, action_url_4, image_4
        if (isset($heroData['tab4'])) {
            $data['title_4'] = $heroData['tab4']['title'] ?? null;
            $data['description_4'] = $heroData['tab4']['description'] ?? null;
            $data['action_label_4'] = $heroData['tab4']['action_label'] ?? null;
            $data['action_url_4'] = $heroData['tab4']['action_url'] ?? null;
            if (!empty($heroData['tab4']['image'])) {
                $data['image_4'] = $this->saveBase64Image($heroData['tab4']['image'], 'hero');
            }
        }
        
        // Tab 5: title_5, description_5, action_label_5, action_url_5, image_5
        if (isset($heroData['tab5'])) {
            $data['title_5'] = $heroData['tab5']['title'] ?? null;
            $data['description_5'] = $heroData['tab5']['description'] ?? null;
            $data['action_label_5'] = $heroData['tab5']['action_label'] ?? null;
            $data['action_url_5'] = $heroData['tab5']['action_url'] ?? null;
            if (!empty($heroData['tab5']['image'])) {
                $data['image_5'] = $this->saveBase64Image($heroData['tab5']['image'], 'hero');
            }
        }
        
        // Tab 6: title_6, description_6, action_label_6, action_url_6, image_6
        if (isset($heroData['tab6'])) {
            $data['title_6'] = $heroData['tab6']['title'] ?? null;
            $data['description_6'] = $heroData['tab6']['description'] ?? null;
            $data['action_label_6'] = $heroData['tab6']['action_label'] ?? null;
            $data['action_url_6'] = $heroData['tab6']['action_url'] ?? null;
            if (!empty($heroData['tab6']['image'])) {
                $data['image_6'] = $this->saveBase64Image($heroData['tab6']['image'], 'hero');
            }
        }
        } elseif ($heroStyle === '2') {
            // Style 2: 1 form dengan title, description, 4 images, 2 action buttons
            // Map to: title, description, action_label (1&2), action_url (1&2), image, image_2, image_3, image_4
            $data['title'] = $heroData['title'] ?? null;
            $data['description'] = $heroData['description'] ?? null;
            $data['action_label'] = $heroData['action_label'] ?? null;      // Not action_label_1
            $data['action_label_2'] = $heroData['action_label_2'] ?? null;
            $data['action_url'] = $heroData['action_url'] ?? null;          // Not action_url_1
            $data['action_url_2'] = $heroData['action_url_2'] ?? null;
            
            // Save 4 images to image, image_2, image_3, image_4 (sequential order)
            if (!empty($heroData['image'])) {                               // Not image_1
                $data['image'] = $this->saveBase64Image($heroData['image'], 'hero');
            }
            if (!empty($heroData['image_2'])) {
                $data['image_2'] = $this->saveBase64Image($heroData['image_2'], 'hero');
            }
            if (!empty($heroData['image_3'])) {
                $data['image_3'] = $this->saveBase64Image($heroData['image_3'], 'hero');
            }
            if (!empty($heroData['image_4'])) {
                $data['image_4'] = $this->saveBase64Image($heroData['image_4'], 'hero');
            }
        } elseif ($heroStyle === '3') {
            // Style 3: 1 form dengan 2 titles, description, 3 images, 2 action buttons
            // Map to: title, title_2, description, action_label, action_label_2, action_url, action_url_2, image, image_2, image_3
            $data['title'] = $heroData['title'] ?? null;                    // Title 1
            $data['title_2'] = $heroData['title_2'] ?? null;                // Title 2
            $data['description'] = $heroData['description'] ?? null;
            $data['action_label'] = $heroData['action_label'] ?? null;      // Action Label 1
            $data['action_label_2'] = $heroData['action_label_2'] ?? null;  // Action Label 2
            $data['action_url'] = $heroData['action_url'] ?? null;          // Action URL 1
            $data['action_url_2'] = $heroData['action_url_2'] ?? null;      // Action URL 2
            
            // Save 3 images to image, image_2, image_3 (sequential order)
            if (!empty($heroData['image'])) {
                $data['image'] = $this->saveBase64Image($heroData['image'], 'hero');
            }
            if (!empty($heroData['image_2'])) {
                $data['image_2'] = $this->saveBase64Image($heroData['image_2'], 'hero');
            }
            if (!empty($heroData['image_3'])) {
                $data['image_3'] = $this->saveBase64Image($heroData['image_3'], 'hero');
            }
        }
        
        // Update existing atau create new
        if ($sectionHeroId) {
            $sectionHero = SectionHero::findOrFail($sectionHeroId);
            $sectionHero->update($data);
        } else {
            $sectionHero = SectionHero::create($data);
        }
        
        return $sectionHero;
    }
    
    /**
     * Save base64 image to storage dan return path
     * 
     * @param string $base64Image - Base64 encoded image
     * @param string $folder - Folder name dalam storage/app/public
     * @return string - Path relatif ke image
     */
    private function saveBase64Image($base64Image, $folder = 'images')
    {
        try {
            // Check if it's a base64 image
            if (strpos($base64Image, 'data:image') !== 0) {
                $normalized = trim((string) $base64Image);

                if (preg_match('/^https?:\/\//', $normalized)) {
                    $path = parse_url($normalized, PHP_URL_PATH);
                    if (!empty($path)) {
                        $normalized = $path;
                    }
                }

                $normalized = preg_replace('#^/storage/#', '', $normalized);
                $normalized = preg_replace('#^storage/#', '', $normalized);

                return ltrim($normalized, '/');
            }
            
            // Extract image data
            $image = str_replace('data:image/webp;base64,', '', $base64Image);
            $image = str_replace(' ', '+', $image);
            $imageData = base64_decode($image);
            
            // Generate unique filename
            $filename = Str::random(40) . '.webp';
            $path = $folder . '/' . $filename;
            
            // Save to storage/app/public/{folder}
            Storage::disk('public')->put($path, $imageData);
            
            // Return path relatif
            return $path;
            
        } catch (\Exception $e) {
            Log::error('Failed to save base64 image: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Create or Update Section About
     * 
     * @param array $aboutData - Data from frontend
     * @param int|null $sectionAboutId - Existing section_about ID (for update)
     * @param string $aboutStyle - Style number ('1', '2', '3')
     * @return \App\Models\SectionAbout
     */
    private function createOrUpdateSectionAbout($aboutData, $sectionAboutId = null, $aboutStyle = '1')
    {
        // Prepare data untuk section_about table
        $data = [];
        
        // Handle based on style
        if ($aboutStyle === '1') {
            // Style 1: Section info, 3 images, 6 benefits
            $data['section_label'] = $aboutData['section_label'] ?? 'KEUNGGULAN KAMI';
            $data['section_title'] = $aboutData['section_title'] ?? '';
            $data['section_description'] = $aboutData['section_description'] ?? null;
            $data['benefit_title'] = $aboutData['benefit_title'] ?? 'Keuntungan memilih sparepart kami:';
            
            // Handle 3 images
            for ($i = 1; $i <= 3; $i++) {
                // Get image type from frontend (upload or url)
                $imageType = $aboutData["image_{$i}_type"] ?? 'upload';
                $data["image_{$i}_type"] = $imageType;
                
                // Save image based on type
                if (!empty($aboutData["image_{$i}_source"])) {
                    if ($imageType === 'url') {
                        // Direct URL, save as is
                        $data["image_{$i}_source"] = $aboutData["image_{$i}_source"];
                    } else {
                        // Upload, process base64
                        $savedPath = $this->saveBase64Image($aboutData["image_{$i}_source"], 'about');
                        if ($savedPath) {
                            $data["image_{$i}_source"] = $savedPath;
                        }
                    }
                }
                
                // Save alt text
                $data["image_{$i}_alt"] = $aboutData["image_{$i}_alt"] ?? null;
            }
            
            // Handle 6 benefits
            for ($i = 1; $i <= 6; $i++) {
                $data["benefit_{$i}_text"] = $aboutData["benefit_{$i}_text"] ?? null;
                $data["benefit_{$i}_icon"] = $aboutData["benefit_{$i}_icon"] ?? 'check';
                $data["benefit_{$i}_enabled"] = $aboutData["benefit_{$i}_enabled"] ?? true;
            }
            
            // Default styling values
            $data['section_background'] = 'gray-100';
            $data['label_color'] = 'blue-600';
            $data['title_color'] = 'gray-900';
            $data['description_color'] = 'gray-600';
            $data['benefit_icon_color'] = 'blue-500';
            $data['is_active'] = true;
        }
        // Add more styles here when implemented
        
        // Update existing atau create new
        if ($sectionAboutId) {
            $sectionAbout = SectionAbout::findOrFail($sectionAboutId);
            $sectionAbout->update($data);
        } else {
            $sectionAbout = SectionAbout::create($data);
        }
        
        return $sectionAbout;
    }
}
