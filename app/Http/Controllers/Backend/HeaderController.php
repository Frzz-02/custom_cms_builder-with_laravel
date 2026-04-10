<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Navbar;
use Illuminate\Http\Request;
use App\Models\Setting;

class HeaderController extends Controller
{
    public function index()
    {
        $navbars = Navbar::orderBy('menu_order')->get();
        $settings = Setting::first();
        return view('backend.header.index', compact('navbars', 'settings'));
    }

    public function create()
    {
        $settings = Setting::first();
        return view('backend.header.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_label' => 'required|string|max:100',
            'menu_slug' => 'required|string|max:100',
            'menu_url' => 'nullable|string|max:255',
            'menu_icon' => 'nullable|string|max:100',
            'menu_location' => 'required|in:navbar,sidebar,both,footer',
            'menu_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:navbar,id',
            'show_in_navbar' => 'nullable|boolean',
            'show_in_sidebar' => 'nullable|boolean',
            'show_in_footer' => 'nullable|boolean',
            'is_external' => 'nullable|boolean',
            'open_new_tab' => 'nullable|boolean',
            'is_button' => 'nullable|boolean',
            'button_style' => 'nullable|string|max:50',
            'require_auth' => 'nullable|boolean',
            'allowed_roles' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);

        // Set default values for checkboxes
        $validated['show_in_navbar'] = $request->has('show_in_navbar');
        $validated['show_in_sidebar'] = $request->has('show_in_sidebar');
        $validated['show_in_footer'] = $request->has('show_in_footer');
        $validated['is_external'] = $request->has('is_external');
        $validated['open_new_tab'] = $request->has('open_new_tab');
        $validated['is_button'] = $request->has('is_button');
        $validated['require_auth'] = $request->has('require_auth');
        $validated['is_active'] = $request->has('is_active');

        Navbar::create($validated);

        return redirect()->route('backend.header.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function edit(Navbar $header)
    {
        $navbars = Navbar::where('id', '!=', $header->id)->get();
        $settings = Setting::first();
        return view('backend.header.edit', compact('header', 'navbars', 'settings'));
    }

    public function update(Request $request, Navbar $header)
    {
        $validated = $request->validate([
            'menu_label' => 'required|string|max:100',
            'menu_slug' => 'required|string|max:100',
            'menu_url' => 'nullable|string|max:255',
            'menu_icon' => 'nullable|string|max:100',
            'menu_location' => 'required|in:navbar,sidebar,both,footer',
            'menu_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:navbar,id',
            'show_in_navbar' => 'nullable|boolean',
            'show_in_sidebar' => 'nullable|boolean',
            'show_in_footer' => 'nullable|boolean',
            'is_external' => 'nullable|boolean',
            'open_new_tab' => 'nullable|boolean',
            'is_button' => 'nullable|boolean',
            'button_style' => 'nullable|string|max:50',
            'require_auth' => 'nullable|boolean',
            'allowed_roles' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);

        // Set default values for checkboxes
        $validated['show_in_navbar'] = $request->has('show_in_navbar');
        $validated['show_in_sidebar'] = $request->has('show_in_sidebar');
        $validated['show_in_footer'] = $request->has('show_in_footer');
        $validated['is_external'] = $request->has('is_external');
        $validated['open_new_tab'] = $request->has('open_new_tab');
        $validated['is_button'] = $request->has('is_button');
        $validated['require_auth'] = $request->has('require_auth');
        $validated['is_active'] = $request->has('is_active');

        $header->update($validated);

        return redirect()->route('backend.header.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Navbar $header)
    {
        $header->delete();

        return redirect()->route('backend.header.index')
            ->with('success', 'Menu item deleted successfully.');
    }
}
