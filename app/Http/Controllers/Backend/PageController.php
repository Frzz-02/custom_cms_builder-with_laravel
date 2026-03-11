<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        // Use pagination for better performance
        $pages = Page::select('id', 'title', 'slug', 'template', 'status', 'meta_title', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(20); // Limit to 20 per page
        return view('backend.pages.index', compact('pages'));
    }

    public function initiate()
    {
        // Generate unique random number
        do {
            $randomNumber = rand(100000, 999999);
            $title = 'title-' . $randomNumber;
            $slug = 'slug-' . $randomNumber;
            
            // Check if this combination already exists
            $exists = Page::where('title', $title)
                         ->orWhere('slug', $slug)
                         ->exists();
        } while ($exists);
        
        // Create draft page with auto-generated data
        $page = Page::create([
            'title' => $title,
            'slug' => $slug,
            'status' => 'draft',
            'template' => 'default',
            'header_style' => 'header style 1',
            'meta_title' => null,
            'meta_description' => null,
            'meta_keywords' => null,
        ]);
        
        // Redirect to edit page
        return redirect()->route('backend.pages.edit', $page);
    }

    public function create()
    {
        return view('backend.pages.create');
    }

    public function store(Request $request)
    {
        // Check if we're updating an existing page (from initiate flow)
        if ($request->has('page_id') && $request->page_id) {
            $page = Page::findOrFail($request->page_id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
                'template' => 'required|in:default,homepage,sidebar,page detail,coming soon',
                'header_style' => 'required|string|max:255',
                'status' => 'required|in:draft,published',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
            ]);

            // Auto-generate slug if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            $page->update($validated);

            return redirect()->route('backend.pages.index')
                ->with('success', 'Page updated successfully!');
        }
        
        // Regular create flow
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'template' => 'required|in:default,homepage,sidebar,page detail,coming soon',
            'header_style' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        Page::create($validated);

        return redirect()->route('backend.pages.index')
            ->with('success', 'Page created successfully!');
    }

    public function edit(Page $page)
    {
        // Fetch all shortcodes for this page, ordered by sort_id
        // Include relationships untuk complex blocks (hero, about, dll)
        $existingShortcodes = $page->shortcodes()
            ->with(['hero', 'about']) // Eager load relationships
            ->orderBy('sort_id', 'asc')
            ->get();
        
        // Pass page dan existing shortcodes ke view
        return view('backend.pages.edit', compact('page', 'existingShortcodes'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'template' => 'required|in:default,homepage,sidebar,page detail,coming soon',
            'header_style' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $page->update($validated);

        return redirect()->route('backend.pages.edit', $page)
            ->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('backend.pages.index')
            ->with('success', 'Page deleted successfully!');
    }
}
