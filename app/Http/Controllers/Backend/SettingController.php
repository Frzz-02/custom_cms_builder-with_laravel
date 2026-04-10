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
        $settings = Setting::first();
        return view('backend.settings.index', compact('setting', 'settings'));
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
            'site_logo' => 'nullable|string|max:2048',
            'site_logo_2' => 'nullable|string|max:2048',
            'favicon' => 'nullable|string|max:2048',
            'preloader' => 'nullable|string|max:2048',
        ]);

        // Get the first (and only) setting record
        $setting = Setting::firstOrFail();

        // Prepare data for update
        $data = $request->except(['site_logo', 'site_logo_2', 'favicon', 'preloader']);

        foreach (['site_logo', 'site_logo_2', 'favicon', 'preloader'] as $field) {
            $data[$field] = $this->normalizeMediaPath($request->input($field));
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
        $filePath = $this->normalizeMediaPath($setting->$field);

        // Delete the file from storage
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Update the field to null
        $setting->update([$field => null]);

        return response()->json([
            'success' => true,
            'message' => 'Image removed successfully!'
        ]);
    }

    private function normalizeMediaPath(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $path = parse_url($value, PHP_URL_PATH) ?: $value;
        $path = ltrim($path, '/');

        if (str_starts_with($path, 'storage/')) {
            return substr($path, 8);
        }

        return $path;
    }
}
