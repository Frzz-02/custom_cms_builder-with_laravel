<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;
use App\Models\Setting;

class FooterController extends Controller
{
    public function index()
    {
        $footer = Footer::first();
        $settings = Setting::first();
        return view('backend.footer.index', compact('footer', 'settings'));
    }

    public function create()
    {
        // Check if data already exists
        if (Footer::count() > 0) {
            return redirect()->route('backend.footer.index')
                ->with('error', 'Footer already exists. Please delete the existing data first.');
        }
        $settings = Setting::first();
        return view('backend.footer.create', compact('settings'));
    }

    public function store(Request $request)
    {
        // Check if data already exists
        if (Footer::count() > 0) {
            return redirect()->route('backend.footer.index')
                ->with('error', 'Footer already exists. Please delete the existing data first.');
        }

        $validated = $request->validate([
            // Company Info
            'company_name' => 'nullable|string|max:100',
            'company_tagline' => 'nullable|string|max:100',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:100',
            'company_whatsapp' => 'nullable|string|max:50',
            'company_website' => 'nullable|string|max:255',
            
            // Contact Column
            'contact_column_title' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:50',
            'contact_link_1_label' => 'nullable|string|max:100',
            'contact_link_1_url' => 'nullable|string|max:255',
            'contact_link_2_label' => 'nullable|string|max:100',
            'contact_link_2_url' => 'nullable|string|max:255',
            'contact_link_3_label' => 'nullable|string|max:100',
            'contact_link_3_url' => 'nullable|string|max:255',
            
            // Product Column
            'product_column_title' => 'nullable|string|max:100',
            'product_link_1_label' => 'nullable|string|max:100',
            'product_link_1_url' => 'nullable|string|max:255',
            'product_link_2_label' => 'nullable|string|max:100',
            'product_link_2_url' => 'nullable|string|max:255',
            'product_link_3_label' => 'nullable|string|max:100',
            'product_link_3_url' => 'nullable|string|max:255',
            
            // Media Coverage
            'media_column_title' => 'nullable|string|max:100',
            'media_1_name' => 'nullable|string|max:100',
            'media_1_url' => 'nullable|url|max:255',
            'media_2_name' => 'nullable|string|max:100',
            'media_2_url' => 'nullable|url|max:255',
            'media_3_name' => 'nullable|string|max:100',
            'media_3_url' => 'nullable|url|max:255',
            'media_4_name' => 'nullable|string|max:100',
            'media_4_url' => 'nullable|url|max:255',
            
            // Legal Column
            'legal_column_title' => 'nullable|string|max:100',
            'legal_link_1_label' => 'nullable|string|max:100',
            'legal_link_1_url' => 'nullable|string|max:255',
            'legal_link_2_label' => 'nullable|string|max:100',
            'legal_link_2_url' => 'nullable|string|max:255',
            'legal_whatsapp_label' => 'nullable|string|max:100',
            'legal_whatsapp_number' => 'nullable|string|max:50',
            'legal_whatsapp_url' => 'nullable|url|max:255',
            'legal_website_label' => 'nullable|string|max:100',
            'legal_website_url' => 'nullable|url|max:255',
            
            // Social Media
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            
            // Guarantee Badge
            'guarantee_text' => 'nullable|string|max:100',
            'guarantee_subtitle' => 'nullable|string|max:100',
            'guarantee_icon_path' => 'nullable|string|max:255',
            
            // WhatsApp Float
            'whatsapp_float_number' => 'nullable|string|max:50',
            'whatsapp_float_message' => 'nullable|string',
            'whatsapp_float_position' => 'nullable|string|max:20',
            
            // Copyright
            'copyright_text' => 'nullable|string|max:255',
            'copyright_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'copyright_credit' => 'nullable|string|max:100',
            
            // Styling
            'footer_background_color' => 'nullable|string|max:50',
            'footer_text_color' => 'nullable|string|max:50',
            'footer_link_color' => 'nullable|string|max:50',
            'footer_link_hover_color' => 'nullable|string|max:50',
        ]);

        // Handle boolean checkboxes
        $validated['facebook_enabled'] = $request->has('facebook_enabled');
        $validated['instagram_enabled'] = $request->has('instagram_enabled');
        $validated['linkedin_enabled'] = $request->has('linkedin_enabled');
        $validated['tiktok_enabled'] = $request->has('tiktok_enabled');
        $validated['twitter_enabled'] = $request->has('twitter_enabled');
        $validated['youtube_enabled'] = $request->has('youtube_enabled');
        $validated['guarantee_enabled'] = $request->has('guarantee_enabled');
        $validated['whatsapp_float_enabled'] = $request->has('whatsapp_float_enabled');
        $validated['is_active'] = $request->has('is_active');

        Footer::create($validated);

        return redirect()->route('backend.footer.index')
            ->with('success', 'Footer created successfully.');
    }




    public function show(Footer $footer)
    {
        return redirect()->route('backend.footer.edit', $footer);
    }



    
    public function edit(Footer $footer)
    {
        $settings = Setting::first();
        return view('backend.footer.edit', compact('footer', 'settings'));
    }





    public function update(Request $request, Footer $footer)
    {
        $validated = $request->validate([
            // Company Info
            'company_name' => 'nullable|string|max:100',
            'company_tagline' => 'nullable|string|max:100',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:100',
            'company_whatsapp' => 'nullable|string|max:50',
            'company_website' => 'nullable|string|max:255',
            
            // Contact Column
            'contact_column_title' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:50',
            'contact_link_1_label' => 'nullable|string|max:100',
            'contact_link_1_url' => 'nullable|string|max:255',
            'contact_link_2_label' => 'nullable|string|max:100',
            'contact_link_2_url' => 'nullable|string|max:255',
            'contact_link_3_label' => 'nullable|string|max:100',
            'contact_link_3_url' => 'nullable|string|max:255',
            
            // Product Column
            'product_column_title' => 'nullable|string|max:100',
            'product_link_1_label' => 'nullable|string|max:100',
            'product_link_1_url' => 'nullable|string|max:255',
            'product_link_2_label' => 'nullable|string|max:100',
            'product_link_2_url' => 'nullable|string|max:255',
            'product_link_3_label' => 'nullable|string|max:100',
            'product_link_3_url' => 'nullable|string|max:255',
            
            // Media Coverage
            'media_column_title' => 'nullable|string|max:100',
            'media_1_name' => 'nullable|string|max:100',
            'media_1_url' => 'nullable|url|max:255',
            'media_2_name' => 'nullable|string|max:100',
            'media_2_url' => 'nullable|url|max:255',
            'media_3_name' => 'nullable|string|max:100',
            'media_3_url' => 'nullable|url|max:255',
            'media_4_name' => 'nullable|string|max:100',
            'media_4_url' => 'nullable|url|max:255',
            
            // Legal Column
            'legal_column_title' => 'nullable|string|max:100',
            'legal_link_1_label' => 'nullable|string|max:100',
            'legal_link_1_url' => 'nullable|string|max:255',
            'legal_link_2_label' => 'nullable|string|max:100',
            'legal_link_2_url' => 'nullable|string|max:255',
            'legal_whatsapp_label' => 'nullable|string|max:100',
            'legal_whatsapp_number' => 'nullable|string|max:50',
            'legal_whatsapp_url' => 'nullable|url|max:255',
            'legal_website_label' => 'nullable|string|max:100',
            'legal_website_url' => 'nullable|url|max:255',
            
            // Social Media
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            
            // Guarantee Badge
            'guarantee_text' => 'nullable|string|max:100',
            'guarantee_subtitle' => 'nullable|string|max:100',
            'guarantee_icon_path' => 'nullable|string|max:255',
            
            // WhatsApp Float
            'whatsapp_float_number' => 'nullable|string|max:50',
            'whatsapp_float_message' => 'nullable|string',
            'whatsapp_float_position' => 'nullable|string|max:20',
            
            // Copyright
            'copyright_text' => 'nullable|string|max:255',
            'copyright_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'copyright_credit' => 'nullable|string|max:100',
            
            // Styling
            'footer_background_color' => 'nullable|string|max:50',
            'footer_text_color' => 'nullable|string|max:50',
            'footer_link_color' => 'nullable|string|max:50',
            'footer_link_hover_color' => 'nullable|string|max:50',
        ]);

        // Handle boolean checkboxes
        $validated['facebook_enabled'] = $request->has('facebook_enabled');
        $validated['instagram_enabled'] = $request->has('instagram_enabled');
        $validated['linkedin_enabled'] = $request->has('linkedin_enabled');
        $validated['tiktok_enabled'] = $request->has('tiktok_enabled');
        $validated['twitter_enabled'] = $request->has('twitter_enabled');
        $validated['youtube_enabled'] = $request->has('youtube_enabled');
        $validated['guarantee_enabled'] = $request->has('guarantee_enabled');
        $validated['whatsapp_float_enabled'] = $request->has('whatsapp_float_enabled');
        $validated['is_active'] = $request->has('is_active');

        $footer->update($validated);

        return redirect()->route('backend.footer.index')
            ->with('success', 'Footer updated successfully.');
    }

    public function destroy(Footer $footer)
    {
        $footer->delete();

        return redirect()->route('backend.footer.index')
            ->with('success', 'Footer deleted successfully.');
    }
}
