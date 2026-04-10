<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WhatsappButton;
use Illuminate\Http\Request;
use App\Models\Setting;


class WhatsAppButtonController extends Controller
{
    public function index()
    {
        $whatsappButton = WhatsappButton::first();
        $settings = Setting::first();
        return view('backend.whatsapp-button.index', compact('whatsappButton', 'settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|max:255',
            'message' => 'required|string',
            'offset_x' => 'required|integer',
            'offset_y' => 'required|integer',
            'position' => 'required|in:bottom-left,bottom-right,top-left,top-right',
            'status' => 'required|in:active,inactive',
        ]);

        // Check if record exists
        $whatsappButton = WhatsappButton::first();
        
        if ($whatsappButton) {
            // Update existing record
            $whatsappButton->update($validated);
            $message = 'WhatsApp Button updated successfully!';
        } else {
            // Create new record
            WhatsappButton::create($validated);
            $message = 'WhatsApp Button created successfully!';
        }

        return redirect()->route('backend.whatsapp-button.index')
            ->with('success', $message);
    }
}
