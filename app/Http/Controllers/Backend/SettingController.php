<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the setting form.
     */
    public function index()
    {
        // Get the first (and only) setting record
        $setting = Setting::firstOrCreate([], [
            'site_title' => 'Mitracom',
            'site_subtitle' => 'Your Gateway to Excellence',
            'time_zone' => 'UTC',
            'locale_language' => 'en',
            'site_description' => 'Website description',
            'site_keywords' => 'keywords, here',
            'site_url' => url('/'),
        ]);

        return view('backend.settings.index', compact('setting'));
    }

    /**
     * Update the setting.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'site_subtitle' => 'nullable|string|max:255',
            'time_zone' => 'nullable|string|max:255',
            'locale_language' => 'nullable|string|max:255',
            'site_description' => 'nullable|string',
            'site_keywords' => 'nullable|string|max:255',
            'site_url' => 'nullable|url|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'site_logo_2' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'preloader' => 'nullable|image|mimes:gif,svg|max:2048',
        ]);

        // Get the first (and only) setting record
        $setting = Setting::firstOrFail();

        // Prepare data for update
        $data = $request->except(['site_logo', 'site_logo_2', 'favicon', 'preloader']);

        // Handle site_logo upload
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            if ($setting->site_logo && Storage::disk('public')->exists($setting->site_logo)) {
                Storage::disk('public')->delete($setting->site_logo);
            }
            
            $data['site_logo'] = $request->file('site_logo')->store('settings', 'public');
        }

        // Handle site_logo_2 upload
        if ($request->hasFile('site_logo_2')) {
            // Delete old logo if exists
            if ($setting->site_logo_2 && Storage::disk('public')->exists($setting->site_logo_2)) {
                Storage::disk('public')->delete($setting->site_logo_2);
            }
            
            $data['site_logo_2'] = $request->file('site_logo_2')->store('settings', 'public');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($setting->favicon && Storage::disk('public')->exists($setting->favicon)) {
                Storage::disk('public')->delete($setting->favicon);
            }
            
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        // Handle preloader upload
        if ($request->hasFile('preloader')) {
            // Delete old preloader if exists
            if ($setting->preloader && Storage::disk('public')->exists($setting->preloader)) {
                Storage::disk('public')->delete($setting->preloader);
            }
            
            $data['preloader'] = $request->file('preloader')->store('settings', 'public');
        }

        // Update the setting
        $setting->update($data);

        return redirect()->route('backend.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Remove uploaded image
     */
    public function removeImage(Request $request)
    {
        $request->validate([
            'field' => 'required|in:site_logo,site_logo_2,favicon,preloader',
        ]);

        $setting = Setting::firstOrFail();
        $field = $request->input('field');

        // Delete the file from storage
        if ($setting->$field && Storage::disk('public')->exists($setting->$field)) {
            Storage::disk('public')->delete($setting->$field);
        }

        // Update the field to null
        $setting->update([$field => null]);

        return response()->json([
            'success' => true,
            'message' => 'Image removed successfully!'
        ]);
    }
}
