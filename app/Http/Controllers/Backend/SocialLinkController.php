<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use App\Models\Setting;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::latest()->get();
        $settings = Setting::first();
        return view('backend.social-links.index', compact('socialLinks', 'settings'));
    }

    public function create()
    {
        $settings = Setting::first();
        return view('backend.social-links.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        SocialLink::create($validated);

        return redirect()->route('backend.social-links.index')
            ->with('success', 'Social Link created successfully.');
    }

    public function edit(SocialLink $socialLink)
    {
        $settings = Setting::first();
        return view('backend.social-links.edit', compact('socialLink', 'settings'));
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);

        $socialLink->update($validated);

        return redirect()->route('backend.social-links.index')
            ->with('success', 'Social Link updated successfully.');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return redirect()->route('backend.social-links.index')
            ->with('success', 'Social Link deleted successfully.');
    }
}
