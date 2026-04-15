@extends('backend.app.layout')

@section('title', 'Edit Blog Post')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar .trix-button-group { margin-bottom: 0; }
    trix-editor { min-height: 300px; }
</style>
@endpush

@section('content')
<div class="p-6">
    @php
        $resolveBlogImageUrl = static function (?string $value): ?string {
            $value = trim((string) $value);

            if ($value === '') {
                return null;
            }

            if (preg_match('/^(https?:\/\/|data:image)/i', $value)) {
                return $value;
            }

            if (str_starts_with($value, '/storage/')) {
                return $value;
            }

            if (str_starts_with($value, 'storage/')) {
                return '/' . $value;
            }

            return asset('storage/' . ltrim($value, '/'));
        };

        $currentImageUrl = $resolveBlogImageUrl($blog->image);
        $currentFeaturedImageUrl = $resolveBlogImageUrl($blog->image_featured);
    @endphp

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('backend.blogs.index') }}" 
               class="text-slate-600 hover:text-slate-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Blog Post</h1>
                <p class="text-slate-600 mt-1">Update blog post information</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('backend.blogs.update', $blog) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-12 gap-6">
            <!-- Main Content -->
            <div class="col-span-8">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $blog->title) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                               placeholder="Enter blog post title"
                               required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-semibold text-slate-700 mb-2">
                            Slug
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $blog->slug) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror"
                               placeholder="Auto-generated from title">
                        <p class="mt-1 text-xs text-slate-500">Leave empty to auto-generate from title</p>
                        @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                            Alternative Name
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $blog->name) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Optional alternative name">
                    </div>

                    <!-- Author -->
                    <div>
                        <label for="author" class="block text-sm font-semibold text-slate-700 mb-2">
                            Author
                        </label>
                        <input type="text" 
                               id="author" 
                               name="author" 
                               value="{{ old('author', $blog->author) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="Author name">
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-semibold text-slate-700 mb-2">
                            Content
                        </label>
                        <input id="content" type="hidden" name="content" value="{{ old('content', $blog->content) }}">
                        <trix-editor input="content" class="border border-slate-300 rounded-lg" autofocus="false"></trix-editor>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Images -->
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Regular Image -->
                        <div>
                            {{-- <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">
                                Blog Image
                            </label> --}}
                            @if($currentImageUrl)
                            <div class="mb-3">
                                {{-- <p class="text-sm text-slate-600 mb-2">Current Image:</p> --}}
                                {{-- <img src="{{ $currentImageUrl }}" 
                                     alt="Current" 
                                     class="w-full h-48 object-cover rounded-lg border border-slate-200"
                                     loading="lazy"> --}}
                            </div>
                            @endif
                            <div data-media-picker
                                 data-field-name="image"
                                 data-field-id="blog_image"
                                 data-label="Blog Image"
                                 data-placeholder="https://example.com/image.webp"
                                 data-initial-value="{{ old('image', $currentImageUrl) }}">
                                @include('backend.components.media-picker-input')
                            </div>
                            @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Select from media library or enter custom image URL.</p>
                        </div>

                        <!-- Featured Image -->
                        <div>
                            {{-- <label for="image_featured" class="block text-sm font-semibold text-slate-700 mb-2">
                                Featured Image
                            </label> --}}
                            @if($currentFeaturedImageUrl)
                            <div class="mb-3">
                                {{-- <p class="text-sm text-slate-600 mb-2">Current Featured Image:</p>
                                <img src="{{ $currentFeaturedImageUrl }}" 
                                     alt="Current Featured" 
                                     class="w-full h-48 object-cover rounded-lg border border-slate-200"
                                     loading="lazy"> --}}
                            </div>
                            @endif
                            <div data-media-picker
                                 data-field-name="image_featured"
                                 data-field-id="blog_image_featured"
                                 data-label="Featured Image"
                                 data-placeholder="https://example.com/featured-image.webp"
                                 data-initial-value="{{ old('image_featured', $currentFeaturedImageUrl) }}">
                                @include('backend.components.media-picker-input')
                            </div>
                            @error('image_featured')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Select from media library or enter custom image URL.</p>
                        </div>
                    </div>

                    <!-- SEO Section -->
                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">SEO Settings</h3>
                        
                        <div class="space-y-4">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Meta Title
                                </label>
                                <input type="text" 
                                       id="meta_title" 
                                       name="meta_title" 
                                       value="{{ old('meta_title', $blog->meta_title) }}"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="SEO optimized title (60 characters max)">
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Meta Description
                                </label>
                                <textarea id="meta_description" 
                                          name="meta_description" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Brief description for search engines (160 characters max)">{{ old('meta_description', $blog->meta_description) }}</textarea>
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <label for="meta_keywords" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Meta Keywords
                                </label>
                                <input type="text" 
                                       id="meta_keywords" 
                                       name="meta_keywords" 
                                       value="{{ old('meta_keywords', $blog->meta_keywords) }}"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="keyword1, keyword2, keyword3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-span-4">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6 sticky top-24">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                            <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <!-- Is Featured -->
                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1" 
                                   {{ old('is_featured', $blog->is_featured) == '1' ? 'checked' : '' }}
                                   class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500">
                            <span class="text-sm font-semibold text-slate-700">Mark as Featured</span>
                        </label>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="blog_categories_id" class="block text-sm font-semibold text-slate-700 mb-2">
                            Category
                        </label>
                        <select id="blog_categories_id" 
                                name="blog_categories_id" 
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('blog_categories_id', $blog->blog_categories_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <hr class="border-slate-200">

                    <!-- Actions -->
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Post
                        </button>
                        <a href="{{ route('backend.blogs.index') }}" 
                           class="w-full px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition-colors text-center block">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@include('backend.components.media-picker-modal')
@endsection

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
@endpush
