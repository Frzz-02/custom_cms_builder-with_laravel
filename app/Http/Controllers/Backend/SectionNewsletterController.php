<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SectionNewsletter;
use Illuminate\Http\Request;

class SectionNewsletterController extends Controller
{
    /**
     * Display and edit the newsletter settings (single record pattern)
     */
    public function index()
    {
        $newsletterSettings = SectionNewsletter::first();
        return view('backend.newsletter.settings', compact('newsletterSettings'));
    }

    /**
     * Store or update newsletter settings (single record pattern)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'action_label' => 'nullable|string|max:255',
            'placeholder' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $newsletterSettings = SectionNewsletter::first();

        if ($newsletterSettings) {
            $newsletterSettings->update($validated);
            $message = 'Newsletter settings updated successfully!';
        } else {
            SectionNewsletter::create($validated);
            $message = 'Newsletter settings created successfully!';
        }

        return redirect()->route('backend.newsletter.settings')
            ->with('success', $message);
    }
}
