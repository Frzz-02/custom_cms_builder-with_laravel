<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PageShortcode;
use App\Models\SectionTestimonial;
use App\Models\SectionService;
use App\Models\Newsletter;
use App\Models\SectionNewsletter;
use App\Models\Contact;
use Illuminate\Http\Request;

class PageShortcodeController extends Controller
{
    public function getTestimonialsList()
    {
        $testimonials = SectionTestimonial::select('id', 'name', 'position', 'content', 'star', 'status')
            ->where('status', 'active')
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
        $validated = $request->validate([
            // Common fields for title, simple-text, text-editor
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            // Complex block fields
            'testimonials_title' => 'nullable|string|max:255',
            'testimonials_subtitle' => 'nullable|string|max:255',
            'testimonials_style' => 'nullable|string|max:255',
            'section_testimoni_id' => 'nullable|array',
            'section_testimoni_id.*' => 'integer',
            'product_title' => 'nullable|string|max:255',
            'product_subtitle' => 'nullable|string|max:255',
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
            'contact_title_1' => 'nullable|string|max:255',
            'contact_subtitle' => 'nullable|string|max:255',
            'contact_id' => 'nullable|array',
            'contact_id.*' => 'integer',
            'pages_id' => 'required|integer|exists:pages,id',
            'sort_id' => 'nullable|integer',
            'type' => 'required|string|max:255',
        ]);
        
        // Convert array to JSON if needed
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
        
        $shortcode = PageShortcode::create($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Page shortcode created successfully',
            'data' => $shortcode
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $shortcode = PageShortcode::findOrFail($id);
        
        $validated = $request->validate([
            // Common fields for title, simple-text, text-editor
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'heading' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            // Complex block fields
            'testimonials_title' => 'nullable|string|max:255',
            'testimonials_subtitle' => 'nullable|string|max:255',
            'testimonials_style' => 'nullable|string|max:255',
            'section_testimoni_id' => 'nullable|array',
            'section_testimoni_id.*' => 'integer',
            'product_title' => 'nullable|string|max:255',
            'product_subtitle' => 'nullable|string|max:255',
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
            'contact_title_1' => 'nullable|string|max:255',
            'contact_subtitle' => 'nullable|string|max:255',
            'contact_id' => 'nullable|array',
            'contact_id.*' => 'integer',
            'sort_id' => 'nullable|integer',
        ]);
        
        // Convert array to JSON if needed
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
        
        $shortcode->update($validated);
        
        return response()->json([
            'success' => true,
            'message' => 'Page shortcode updated successfully',
            'data' => $shortcode->fresh()
        ]);
    }
    
    public function destroy($id)
    {
        $shortcode = PageShortcode::findOrFail($id);
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
        $shortcode = PageShortcode::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $shortcode
        ]);
    }
}
