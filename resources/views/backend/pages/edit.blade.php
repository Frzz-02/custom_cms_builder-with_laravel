@extends('backend.app.layout')

@section('title', 'Edit Page')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    <!-- Top Bar -->
    <div class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('backend.pages.index') }}" 
                       class="text-slate-600 hover:text-slate-800 transition-colors p-2 hover:bg-slate-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-slate-800">Edit Page</h1>
                        <p class="text-sm text-slate-500 mt-0.5">Update your page content and settings</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    @if($page->status === 'published')
                        <a href="{{ is_null($page->slug) ? route('home') : url($page->slug) }}" 
                           target="_blank"
                           class="px-4 py-2 text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            View Page
                        </a>
                    @endif
                    <a href="{{ route('backend.pages.index') }}" 
                       class="px-4 py-2 text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('backend.pages.update', $page) }}" method="POST" id="pageForm">
        @csrf
        @method('PUT')
        
        <div class="max-w-[1600px] mx-auto p-6">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm animate-pulse">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-red-800 font-medium mb-2">There were some errors with your submission:</p>
                            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="grid grid-cols-12 gap-6">
                <!-- Main Content Area - 8 columns -->
                <div class="col-span-8 space-y-6">
                    <!-- Page Header -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-6 space-y-5">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Page Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       value="{{ old('title', $page->title) }}"
                                       class="w-full px-4 py-3 text-lg border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                       placeholder="Enter your page title..." 
                                       required>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Page Slug
                                </label>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-slate-500 bg-slate-50 px-3 py-3 rounded-lg border border-slate-200">
                                        {{ url('/') }}/
                                    </span>
                                    <input type="text" 
                                           name="slug" 
                                           id="slug" 
                                           value="{{ old('slug', $page->slug) }}"
                                           class="flex-1 px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           placeholder="page-url-slug"
                                           @if (is_null($page->slug)) readonly disabled autocomplete="off" @endif >
                                </div>
                                <p class="mt-2 text-xs text-slate-500">Leave empty to auto-generate from title</p>
                                @error('slug')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- UI Blocks Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold text-white">Page Builder</h2>
                                        <p class="text-sm text-indigo-100">Build your page with drag & drop blocks</p>
                                    </div>
                                </div>
                                <button type="button" 
                                        id="openLibraryBtn"
                                        class="px-5 py-2.5 bg-white text-indigo-600 rounded-lg hover:bg-indigo-50 transition-all font-semibold text-sm shadow-lg hover:shadow-xl flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    UI Blocks
                                </button>
                            </div>
                        </div>
                        
                        <!-- Blocks List -->
                        <div id="blocksContainer" class="min-h-[200px]">
                            <div id="blocksList" class="divide-y divide-slate-200">
                                <!-- Blocks will be added here dynamically -->
                            </div>
                            
                            <!-- Empty State -->
                            <div id="emptyState" class="p-12 text-center bg-slate-50">
                                <div class="max-w-md mx-auto">
                                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-slate-700 mb-2">No blocks added yet</h3>
                                    <p class="text-sm text-slate-500 mb-6">Start building your page by adding UI blocks</p>
                                    <button type="button" 
                                            id="addFirstBlockBtn"
                                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Add Your First Block
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Configuration -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-green-100 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-slate-800">Search Engine Optimization</h2>
                                    <p class="text-sm text-slate-500">Improve your page visibility in search results</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-5">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Meta Title
                                </label>
                                <input type="text" 
                                       name="meta_title" 
                                       id="meta_title" 
                                       value="{{ old('meta_title', $page->meta_title) }}"
                                       maxlength="60"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="SEO optimized title (60 characters max)">
                                <div class="mt-2 flex items-center justify-between">
                                    <p class="text-xs text-slate-500">Shown in search engine results</p>
                                    <span class="text-xs text-slate-400" id="metaTitleCount">{{ strlen($page->meta_title ?? '') }} / 60</span>
                                </div>
                                @error('meta_title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Meta Description
                                </label>
                                <textarea name="meta_description" 
                                          id="meta_description" 
                                          rows="3"
                                          maxlength="160"
                                          class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none"
                                          placeholder="Brief description of your page (160 characters max)">{{ old('meta_description', $page->meta_description) }}</textarea>
                                <div class="mt-2 flex items-center justify-between">
                                    <p class="text-xs text-slate-500">Displayed below the title in search results</p>
                                    <span class="text-xs text-slate-400" id="metaDescCount">{{ strlen($page->meta_description ?? '') }} / 160</span>
                                </div>
                                @error('meta_description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <label for="meta_keywords" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Focus Keywords
                                </label>
                                <input type="text" 
                                       name="meta_keywords" 
                                       id="meta_keywords" 
                                       value="{{ old('meta_keywords', $page->meta_keywords) }}"
                                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                       placeholder="keyword1, keyword2, keyword3">
                                <p class="mt-2 text-xs text-slate-500">Separate keywords with commas</p>
                                @error('meta_keywords')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SEO Preview -->
                            <div class="mt-6 p-4 bg-slate-50 border border-slate-200 rounded-lg">
                                <p class="text-xs font-semibold text-slate-600 mb-3 uppercase tracking-wide">Search Result Preview</p>
                                <div class="space-y-1">
                                    <div class="text-blue-600 text-lg font-medium" id="seoPreviewTitle">{{ $page->meta_title ?? $page->title }}</div>
                                    <div class="text-green-700 text-sm" id="seoPreviewUrl">{{ url('/') }}/{{ $page->slug ?? '' }}</div>
                                    <div class="text-slate-600 text-sm leading-relaxed" id="seoPreviewDesc">{{ $page->meta_description ?? 'Your meta description will appear here...' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - 4 columns -->
                <div class="col-span-4 space-y-6">
                    <!-- Publish Box -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white">Publish</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" 
                                        id="status" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        required>
                                    <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Template -->
                            <div>
                                <label for="template" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Template <span class="text-red-500">*</span>
                                </label>
                                <select name="template" 
                                        id="template" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        required>
                                    <option value="default" {{ old('template', $page->template) === 'default' ? 'selected' : '' }}>Default</option>
                                    <option value="homepage" {{ old('template', $page->template) === 'homepage' ? 'selected' : '' }}>Homepage</option>
                                    <option value="sidebar" {{ old('template', $page->template) === 'sidebar' ? 'selected' : '' }}>With Sidebar</option>
                                    <option value="page detail" {{ old('template', $page->template) === 'page detail' ? 'selected' : '' }}>Page Detail</option>
                                    <option value="coming soon" {{ old('template', $page->template) === 'coming soon' ? 'selected' : '' }}>Coming Soon</option>
                                </select>
                                @error('template')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Header Style -->
                            <div>
                                <label for="header_style" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Header Style <span class="text-red-500">*</span>
                                </label>
                                <select name="header_style" 
                                        id="header_style" 
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        required>
                                    <option value="header style 1" {{ old('header_style', $page->header_style) === 'header style 1' ? 'selected' : '' }}>Header Style 1</option>
                                    <option value="header style 2" {{ old('header_style', $page->header_style) === 'header style 2' ? 'selected' : '' }}>Header Style 2</option>
                                    <option value="header style 3" {{ old('header_style', $page->header_style) === 'header style 3' ? 'selected' : '' }}>Header Style 3</option>
                                    <option value="header style 4" {{ old('header_style', $page->header_style) === 'header style 4' ? 'selected' : '' }}>Header Style 4</option>
                                </select>
                                @error('header_style')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <hr class="border-slate-200">

                            <!-- Save Button -->
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3.5 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all font-bold shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Page
                            </button>
                        </div>
                    </div>

                    <!-- Page Info -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                            <h3 class="text-sm font-bold text-slate-800">Page Information</h3>
                        </div>
                        <div class="p-6 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-600">Created:</span>
                                <span class="font-medium text-slate-800">{{ $page->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Updated:</span>
                                <span class="font-medium text-slate-800">{{ $page->updated_at->format('M d, Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">ID:</span>
                                <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded text-slate-800">{{ $page->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Include Modals --}}
@include('backend.pages.modals.library-modal')
@include('backend.pages.modals.edit-title')
@include('backend.pages.modals.edit-simple-text')
@include('backend.pages.modals.edit-text-editor')
@include('backend.pages.modals.edit-brands')
@include('backend.pages.modals.edit-completecounts')
@include('backend.pages.modals.select-hero-style')
@include('backend.pages.modals.edit-hero-banner')
@include('backend.pages.modals.edit-hero-banner-style2')
@include('backend.pages.modals.edit-hero-banner-style3')
@include('backend.pages.modals.select-about-style')
@include('backend.pages.modals.edit-about')
@include('backend.pages.modals.select-testimonials-style')
@include('backend.pages.modals.edit-testimonials')
@include('backend.pages.modals.edit-recent-product')
@include('backend.pages.modals.select-product-category-style')
@include('backend.pages.modals.edit-product-category')
@include('backend.pages.modals.select-service-style')
@include('backend.pages.modals.edit-featured-services')
@include('backend.pages.modals.edit-newsletter')
@include('backend.pages.modals.select-latestnews-style')
@include('backend.pages.modals.edit-latestnews')
@include('backend.pages.modals.edit-comingsoon')
@include('backend.pages.modals.edit-contact')
@include('backend.pages.modals.edit-default')




<!-- Trix Editor CSS -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endsection

@push('scripts')
<!-- Trix Editor Script -->
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<!-- SortableJS Library untuk Drag & Drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<!-- Set Page ID untuk JavaScript -->
<script>
    // Variable global yang bisa diakses dari file page-builder.js
    // Digunakan saat menyimpan data block ke database
    window.pageId = {{ $page->id }};
    
    // ⭐ Existing shortcodes data dari database
    // Data ini akan di-load saat halaman pertama kali dibuka
    // Format: array of objects dengan semua field dari tabel page_shortcodes
    window.existingShortcodes = @json($existingShortcodes);
    window.isHomePageSlugLocked = @json(is_null($page->slug));
    
    console.log('🔍 Existing shortcodes loaded:', window.existingShortcodes);
    
    // Character counter and SEO preview
    document.addEventListener('DOMContentLoaded', function() {
        // Meta Title Character Counter
        const metaTitleInput = document.getElementById('meta_title');
        const metaTitleCount = document.getElementById('metaTitleCount');
        
        if (metaTitleInput && metaTitleCount) {
            metaTitleInput.addEventListener('input', function() {
                const length = this.value.length;
                metaTitleCount.textContent = length + ' / 60';
                
                // Update SEO Preview
                const previewTitle = document.getElementById('seoPreviewTitle');
                if (previewTitle) {
                    previewTitle.textContent = this.value || document.getElementById('title').value;
                }
            });
        }
        
        // Meta Description Character Counter
        const metaDescInput = document.getElementById('meta_description');
        const metaDescCount = document.getElementById('metaDescCount');
        
        if (metaDescInput && metaDescCount) {
            metaDescInput.addEventListener('input', function() {
                const length = this.value.length;
                metaDescCount.textContent = length + ' / 160';
                
                // Update SEO Preview
                const previewDesc = document.getElementById('seoPreviewDesc');
                if (previewDesc) {
                    previewDesc.textContent = this.value || 'Your meta description will appear here...';
                }
            });
        }
        
        // Update SEO Preview URL on slug change
        const slugInput = document.getElementById('slug');
        if (slugInput) {
            slugInput.addEventListener('input', function() {
                const previewUrl = document.getElementById('seoPreviewUrl');
                if (previewUrl) {
                    const baseUrl = '{{ url('/') }}';
                    previewUrl.textContent = baseUrl + '/' + (this.value || 'your-page-slug');
                }
            });
        }
        
        // Update SEO Preview Title on title change (if meta title is empty)
        const titleInput = document.getElementById('title');
        if (titleInput) {
            titleInput.addEventListener('input', function() {
                const previewTitle = document.getElementById('seoPreviewTitle');
                const metaTitleInput = document.getElementById('meta_title');
                if (previewTitle && (!metaTitleInput || !metaTitleInput.value)) {
                    previewTitle.textContent = this.value;
                }
                
                // Auto-generate slug if slug is empty (non-home page only)
                const slugInput = document.getElementById('slug');
                if (!window.isHomePageSlugLocked && slugInput && !slugInput.value) {
                    const slug = this.value.toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    slugInput.value = slug;
                    
                    // Update preview URL
                    const previewUrl = document.getElementById('seoPreviewUrl');
                    if (previewUrl) {
                        const baseUrl = '{{ url('/') }}';
                        previewUrl.textContent = baseUrl + '/' + (slug || 'your-page-slug');
                    }
                }
            });
        }
    });
</script>

<!-- File JavaScript Utama untuk Page Builder -->
<!-- Berisi semua fungsi untuk mengelola blocks, modals, dll -->
<script src="{{ asset('assets/js/backend/page-builder.js') }}?v={{ time() }}"></script>

@endpush
