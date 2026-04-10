<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Setting;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::orderBy('created_at', 'desc')->paginate(10);
        $settings = Setting::first();
        return view('backend.blog-categories.index', compact('categories', 'settings'));
    }

    public function create()
    {
        $settings = Setting::first();
        return view('backend.blog-categories.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        BlogCategory::create($validated);

        return redirect()->route('backend.blog-categories.index')
            ->with('success', 'Blog category created successfully!');
    }

    public function edit(BlogCategory $blogCategory)
    {
        $settings = Setting::first();
        return view('backend.blog-categories.edit', compact('blogCategory', 'settings'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:blog_categories,slug,' . $blogCategory->id,
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $blogCategory->update($validated);

        return redirect()->route('backend.blog-categories.index')
            ->with('success', 'Blog category updated successfully!');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return redirect()->route('backend.blog-categories.index')
            ->with('success', 'Blog category deleted successfully!');
    }
}
