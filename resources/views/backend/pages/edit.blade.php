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
                        <a href="{{ url($page->slug) }}" 
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
                                           placeholder="page-url-slug">
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
                                        onclick="openBlockLibrary()"
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
                                            onclick="openBlockLibrary()"
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
                                    <div class="text-green-700 text-sm" id="seoPreviewUrl">{{ url('/') }}/{{ $page->slug }}</div>
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
                                    <option value="header style 1" {{ old('header_style', 'Header style 1') === 'Header style 1' ? 'selected' : '' }}>Header style 1</option>
                                    <option value="header style 2" {{ old('header_style', $page->header_style) === 'Header style 2' ? 'selected' : '' }}>Header style 2</option>
                                    <option value="header style 3" {{ old('header_style', $page->header_style) === 'Header style 3' ? 'selected' : '' }}>Header style 3</option>
                                    <option value="header style 4" {{ old('header_style', $page->header_style) === 'Header style 4' ? 'selected' : '' }}>Header style 4</option>
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
@include('backend.pages.modals.edit-default')




<!-- Trix Editor CSS -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
@endsection





@push('scripts')
<!-- Trix Editor Script -->
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Block Library Modal (hidden, replaced with partial)
<div id="blockLibraryModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">UI Blocks</h2>
                        <p class="text-sm text-indigo-100">Choose a block to add to your page</p>
                    </div>
                </div>
                <button type="button" onclick="closeBlockLibrary()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <!-- Title Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Title</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a heading title</p>
                            <button type="button" onclick="addBlock('title')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Simple Text Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Simple text</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a simple text block</p>
                            <button type="button" onclick="addBlock('simple-text')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Text Editor Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Text editor</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a rich text editor</p>
                            <button type="button" onclick="addBlock('text-editor')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Complete Counts Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Complete Counts</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a complete count</p>
                            <button type="button" onclick="addBlock('complete-counts')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Hero Banner Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Hero banner</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a hero banner</p>
                            <button type="button" onclick="addBlock('hero-banner')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- About Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">About us</h3>
                            <p class="text-sm text-slate-500 mb-4">Add an about section</p>
                            <button type="button" onclick="addBlock('about')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Brands Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-amber-500 to-orange-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Brands</h3>
                            <p class="text-sm text-slate-500 mb-4">Display partner brands</p>
                            <button type="button" onclick="addBlock('brands')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Block Modal -->
<div id="editBlockModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-white">Edit Shortcode - <span id="editBlockName">Block</span></h2>
            <button type="button" onclick="closeEditModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-5">
            <!-- Style Dropdown -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Style</label>
                <select class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    <option>Style 1</option>
                    <option>Style 2</option>
                    <option>Style 3</option>
                    <option>Style 4</option>
                </select>
            </div>

            <!-- Edit Button -->
            <button type="button" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </button>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Save
                </button>
                <button type="button" onclick="deleteCurrentBlock()" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Block management
    let blockCounter = 0;
    let currentEditBlockId = null;
    let sortable = null;
    let pendingHeroBannerBlockId = null; // Store pending hero banner block ID

    // Available blocks configuration
    const blockConfig = {
        'title': { name: 'Title', icon: 'text', color: 'slate' },
        'simple-text': { name: 'Simple text', icon: 'align-left', color: 'slate' },
        'text-editor': { name: 'Text editor', icon: 'edit', color: 'slate' },
        'complete-counts': { name: 'Complete Counts', icon: 'chart-bar', color: 'blue' },
        'hero-banner': { name: 'Hero banner', icon: 'photograph', color: 'indigo' },
        'about': { name: 'About us', icon: 'information-circle', color: 'blue' },
        'brands': { name: 'Brands', icon: 'tag', color: 'amber' }
    };

    // Initialize sortable when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initSortable();
    });

    function initSortable() {
        const el = document.getElementById('blocksList');
        if (el && !sortable) {
            sortable = Sortable.create(el, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'bg-indigo-50',
                dragClass: 'opacity-50',
                onEnd: function() {
                    updateBlockOrder();
                }
            });
        }
    }

    function updateBlockOrder() {
        // Update order numbers in the UI
        const blocks = document.querySelectorAll('.block-item');
        blocks.forEach((block, index) => {
            const orderSpan = block.querySelector('.block-order');
            if (orderSpan) {
                orderSpan.textContent = index + 1;
            }
        });
    }

    // Modal transition helper
    function closeModalWithTransition(modalId, callback) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        // Add fade out effect
        modal.style.transition = 'opacity 300ms ease-out';
        modal.style.opacity = '0';
        
        // Wait for transition to complete, then hide
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.style.opacity = '1'; // Reset for next open
            document.body.style.overflow = 'auto';
            
            if (callback && typeof callback === 'function') {
                callback();
            }
        }, 300);
    }

    // Modal functions
    function openBlockLibrary() {
        document.getElementById('blockLibraryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeBlockLibrary() {
        closeModalWithTransition('blockLibraryModal');
    }

    function openEditModal(blockId) {
        currentEditBlockId = blockId;
        const block = document.getElementById(blockId);
        const blockType = block.dataset.type;
        
        // Open the appropriate modal based on block type
        if (blockType === 'title') {
            document.getElementById('editTitleModal').classList.remove('hidden');
        } else if (blockType === 'simple-text') {
            document.getElementById('editSimpleTextModal').classList.remove('hidden');
        } else if (blockType === 'text-editor') {
            document.getElementById('editTextEditorModal').classList.remove('hidden');
        } else if (blockType === 'brands') {
            document.getElementById('editBrandsModal').classList.remove('hidden');
        } else if (blockType === 'complete-counts') {
            document.getElementById('editCompleteCountsModal').classList.remove('hidden');
        } else if (blockType === 'hero-banner') {
            openEditHeroBannerModal();
        } else {
            const blockName = blockConfig[blockType]?.name || 'Block';
            document.getElementById('editBlockName').textContent = blockName;
            document.getElementById('editDefaultModal').classList.remove('hidden');
        }
        
        document.body.style.overflow = 'hidden';
    }

    // Title Modal Functions
    function closeEditTitleModal() {
        closeModalWithTransition('editTitleModal', () => {
            currentEditBlockId = null;
        });
    }

    function saveTitleBlock() {
        // Save functionality will be implemented later
        closeEditTitleModal();
    }

    function deleteTitleBlock() {
        if (!currentEditBlockId) {
            alert('No block selected.');
            return;
        }
        
        if (!confirm('Are you sure you want to delete this block?')) {
            return;
        }

        const blockId = document.getElementById('titleBlockId').value;
        
        // Show loading state
        const deleteBtn = document.getElementById('deleteTitleBtn');
        const deleteIconTrash = document.getElementById('deleteTitleIconTrash');
        const deleteIconLoading = document.getElementById('deleteTitleIconLoading');
        const deleteButtonText = document.getElementById('deleteTitleButtonText');
        
        deleteBtn.disabled = true;
        deleteIconTrash.classList.add('hidden');
        deleteIconLoading.classList.remove('hidden');
        deleteButtonText.textContent = 'Deleting...';

        // If there's saved data, delete from database first
        if (blockId) {
            // TODO: Add API endpoint when backend is ready
            // fetch('/bagoosh/page-shortcode/delete-ajax/' + blockId, {...})
            // For now, just remove from UI
            console.log('Would delete title block ID:', blockId, 'from database');
        }

        // Close modal with transition first, then remove block
        closeModalWithTransition('editTitleModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.remove();
                checkEmptyState();
                updateBlockOrder();
            }
            currentEditBlockId = null;
            
            // Reset loading state
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            
            alert('Block deleted successfully!');
        });
    }

    // Simple Text Modal Functions
    function closeEditSimpleTextModal() {
        closeModalWithTransition('editSimpleTextModal', () => {
            currentEditBlockId = null;
        });
    }

    function saveSimpleTextBlock() {
        // Save functionality will be implemented later
        closeEditSimpleTextModal();
    }

    function deleteSimpleTextBlock() {
        if (!currentEditBlockId) {
            alert('No block selected.');
            return;
        }
        
        if (!confirm('Are you sure you want to delete this block?')) {
            return;
        }

        const blockId = document.getElementById('simpleTextBlockId').value;
        
        // Show loading state
        const deleteBtn = document.getElementById('deleteSimpleTextBtn');
        const deleteIconTrash = document.getElementById('deleteSimpleTextIconTrash');
        const deleteIconLoading = document.getElementById('deleteSimpleTextIconLoading');
        const deleteButtonText = document.getElementById('deleteSimpleTextButtonText');
        
        deleteBtn.disabled = true;
        deleteIconTrash.classList.add('hidden');
        deleteIconLoading.classList.remove('hidden');
        deleteButtonText.textContent = 'Deleting...';

        // If there's saved data, delete from database first
        if (blockId) {
            // TODO: Add API endpoint when backend is ready
            // fetch('/bagoosh/page-shortcode/delete-ajax/' + blockId, {...})
            // For now, just remove from UI
            console.log('Would delete simple text block ID:', blockId, 'from database');
        }

        // Close modal with transition first, then remove block
        closeModalWithTransition('editSimpleTextModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.remove();
                checkEmptyState();
                updateBlockOrder();
            }
            currentEditBlockId = null;
            
            // Reset loading state
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            
            alert('Block deleted successfully!');
        });
    }

    // Text Editor Modal Functions
    function closeEditTextEditorModal() {
        closeModalWithTransition('editTextEditorModal', () => {
            currentEditBlockId = null;
        });
    }

    function saveTextEditorBlock() {
        // Get Trix editor content
        const content = document.getElementById('textEditorContent').value;
        console.log('Text editor content:', content);
        
        // Save functionality will be implemented later
        closeEditTextEditorModal();
    }

    function deleteTextEditorBlock() {
        if (!currentEditBlockId) {
            alert('No block selected.');
            return;
        }
        
        if (!confirm('Are you sure you want to delete this block?')) {
            return;
        }

        const blockId = document.getElementById('textEditorBlockId').value;
        
        // Show loading state
        const deleteBtn = document.getElementById('deleteTextEditorBtn');
        const deleteIconTrash = document.getElementById('deleteTextEditorIconTrash');
        const deleteIconLoading = document.getElementById('deleteTextEditorIconLoading');
        const deleteButtonText = document.getElementById('deleteTextEditorButtonText');
        
        deleteBtn.disabled = true;
        deleteIconTrash.classList.add('hidden');
        deleteIconLoading.classList.remove('hidden');
        deleteButtonText.textContent = 'Deleting...';

        // If there's saved data, delete from database first
        if (blockId) {
            // TODO: Add API endpoint when backend is ready
            // fetch('/bagoosh/page-shortcode/delete-ajax/' + blockId, {...})
            // For now, just remove from UI
            console.log('Would delete text editor block ID:', blockId, 'from database');
        }

        // Close modal with transition first, then remove block
        closeModalWithTransition('editTextEditorModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.remove();
                checkEmptyState();
                updateBlockOrder();
            }
            currentEditBlockId = null;
            
            // Reset loading state
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            
            alert('Block deleted successfully!');
        });
    }

    // Brands Modal Functions
    function closeEditBrandsModal() {
        closeModalWithTransition('editBrandsModal', () => {
            currentEditBlockId = null;
        });
    }

    function saveBrandsBlock() {
        // Get selected brands
        const checkboxes = document.querySelectorAll('#brandsList input[type="checkbox"]:checked');
        const selectedBrands = Array.from(checkboxes).map(cb => ({
            id: cb.value,
            name: cb.parentElement.querySelector('span').textContent.trim()
        }));
        console.log('Selected brands:', selectedBrands);
        
        // Save functionality will be implemented later
        closeEditBrandsModal();
    }

    function deleteBrandsBlock() {
        if (!currentEditBlockId) {
            alert('No block selected.');
            return;
        }
        
        if (!confirm('Are you sure you want to delete this block?')) {
            return;
        }

        const blockId = document.getElementById('brandsBlockId').value;
        
        // Show loading state
        const deleteBtn = document.getElementById('deleteBrandsBtn');
        const deleteIconTrash = document.getElementById('deleteBrandsIconTrash');
        const deleteIconLoading = document.getElementById('deleteBrandsIconLoading');
        const deleteButtonText = document.getElementById('deleteBrandsButtonText');
        
        deleteBtn.disabled = true;
        deleteIconTrash.classList.add('hidden');
        deleteIconLoading.classList.remove('hidden');
        deleteButtonText.textContent = 'Deleting...';

        // If there's saved data, delete from database first
        if (blockId) {
            // TODO: Add API endpoint when backend is ready
            // fetch('/bagoosh/page-shortcode/delete-ajax/' + blockId, {...})
            // For now, just remove from UI
            console.log('Would delete brands block ID:', blockId, 'from database');
        }

        // Close modal with transition first, then remove block
        closeModalWithTransition('editBrandsModal', () => {
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.remove();
                checkEmptyState();
                updateBlockOrder();
            }
            currentEditBlockId = null;
            
            // Reset loading state
            deleteBtn.disabled = false;
            deleteIconTrash.classList.remove('hidden');
            deleteIconLoading.classList.add('hidden');
            deleteButtonText.textContent = 'Delete';
            
            alert('Block deleted successfully!');
        });
    }

    // Complete Counts Modal Functions
    function closeEditCompleteCountsModal() {
        closeModalWithTransition('editCompleteCountsModal', () => {
            currentEditBlockId = null;
        });
    }

    function saveCompleteCountsBlock() {
        // Get selected complete counts
        const checkboxes = document.querySelectorAll('#completeCountsList input[type="checkbox"]:checked');
        const selectedCounts = Array.from(checkboxes).map(cb => ({
            id: cb.value,
            title: cb.parentElement.querySelector('span').textContent.trim()
        }));
        console.log('Selected complete counts:', selectedCounts);
        
        // Save functionality will be implemented later
        closeEditCompleteCountsModal();
    }

    // Hero Banner Modal Functions
    // Select Hero Style Modal Functions
    function closeSelectHeroStyleModal() {
        closeModalWithTransition('selectHeroStyleModal', () => {
            // If there's a pending hero banner block that wasn't completed, cancel it
            if (pendingHeroBannerBlockId) {
                blockCounter--; // Revert counter since block was never added
                pendingHeroBannerBlockId = null;
            }
        });
    }

    function selectHeroStyle(style) {
        if (!pendingHeroBannerBlockId) {
            alert('Error: No pending hero banner block.');
            return;
        }
        
        const blockId = pendingHeroBannerBlockId;
        const config = blockConfig['hero-banner'];
        const blocksList = document.getElementById('blocksList');
        
        // Now actually add the block to DOM
        const blockHTML = `
            <div id="${blockId}" data-type="hero-banner" data-hero-style="${style}" class="block-item bg-white hover:bg-slate-50 transition-all group">
                <div class="flex items-center gap-4 p-4">
                    <!-- Drag Handle -->
                    <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                    </div>
                    
                    <!-- Block Info -->
                    <div class="flex-1 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${getBlockIcon('hero-banner')}
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                                <h3 class="font-semibold text-slate-800">${config.name}</h3>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5 block-content"><span class="text-indigo-600 font-semibold">Hero Banner - Style ${style}</span></p>
                        </div>
                    </div>
                    
                    <!-- Edit Button -->
                    <button type="button" 
                            onclick="openEditModal('${blockId}')"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Configure
                    </button>
                </div>
            </div>
        `;
        
        blocksList.insertAdjacentHTML('beforeend', blockHTML);
        checkEmptyState();
        updateBlockOrder();
        
        // Reinitialize sortable if needed
        if (!sortable) {
            initSortable();
        }
        
        // Clear pending block
        pendingHeroBannerBlockId = null;
        
        closeSelectHeroStyleModal();
        alert(`Hero Banner Style ${style} added! Click "Configure" to edit the content.`);
    }

    function openEditHeroBannerModal() {
        // Check if block has selected style
        const block = document.getElementById(currentEditBlockId);
        const heroStyle = block?.dataset.heroStyle;
        
        if (!heroStyle) {
            alert('Please select a style first by clicking on the hero banner block.');
            return;
        }
        
        // Only open modal for style 1
        if (heroStyle === '1') {
            // Show modal
            document.getElementById('editHeroBannerModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Check if we have saved data to fetch
            const existingId = block.dataset.heroBannerId;
            
            if (existingId) {
                // Fetch existing data and populate form
                fetch('/bagoosh/section-hero/show-ajax/' + existingId, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        populateHeroBannerForm(data.data);
                    } else {
                        console.error('Error fetching hero banner data:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching hero banner:', error);
                });
            } else {
                // Reset form for new data
                document.getElementById('heroBannerForm').reset();
                document.getElementById('hero_banner_id').value = '';
            }
        } else if (heroStyle === '2' || heroStyle === '3') {
            // Don't open modal for style 2 and 3 yet
            alert(`Hero Banner Style ${heroStyle} form is not ready yet. Please wait for further instructions.`);
        }
    }

    function closeEditHeroBannerModal() {
        closeModalWithTransition('editHeroBannerModal', () => {
            currentEditBlockId = null;
        });
    }

    function populateHeroBannerForm(data) {
        // Populate hidden ID field
        document.getElementById('hero_banner_id').value = data.id || '';
        
        // Populate text fields
        document.getElementById('title').value = data.title || '';
        document.getElementById('title_2').value = data.title_2 || '';
        document.getElementById('title_3').value = data.title_3 || '';
        document.getElementById('subtitle_1').value = data.subtitle_1 || '';
        document.getElementById('subtitle_2').value = data.subtitle_2 || '';
        document.getElementById('subtitle_3').value = data.subtitle_3 || '';
        document.getElementById('description').value = data.description || '';
        document.getElementById('description_2').value = data.description_2 || '';
        document.getElementById('description_3').value = data.description_3 || '';
        document.getElementById('action_label').value = data.action_label || '';
        document.getElementById('action_label_2').value = data.action_label_2 || '';
        document.getElementById('action_label_3').value = data.action_label_3 || '';
        document.getElementById('action_url').value = data.action_url || '';
        document.getElementById('action_url_2').value = data.action_url_2 || '';
        document.getElementById('action_url_3').value = data.action_url_3 || '';
        
        // Populate image URL fields (file inputs will remain empty)
        document.getElementById('image').value = data.image || '';
        document.getElementById('image_2').value = data.image_2 || '';
        document.getElementById('image_3').value = data.image_3 || '';
        document.getElementById('image_background').value = data.image_background || '';
        document.getElementById('image_background_2').value = data.image_background_2 || '';
        document.getElementById('image_background_3').value = data.image_background_3 || '';
    }

    function handleImageUpload(fieldName, fileInput) {
        // When file is selected, clear the URL input
        if (fileInput.files.length > 0) {
            document.getElementById(fieldName).value = '';
        }
    }

    function saveHeroBannerBlock() {
        // Show loading state
        const saveBtn = document.getElementById('saveHeroBannerBtn');
        const saveIconCheck = document.getElementById('saveIconCheck');
        const saveIconLoading = document.getElementById('saveIconLoading');
        const saveButtonText = document.getElementById('saveButtonText');
        
        saveBtn.disabled = true;
        saveIconCheck.classList.add('hidden');
        saveIconLoading.classList.remove('hidden');
        saveButtonText.textContent = 'Saving...';
        
        const formData = new FormData();
        
        // Add text fields
        formData.append('title', document.getElementById('title').value);
        formData.append('title_2', document.getElementById('title_2').value);
        formData.append('title_3', document.getElementById('title_3').value);
        formData.append('subtitle_1', document.getElementById('subtitle_1').value);
        formData.append('subtitle_2', document.getElementById('subtitle_2').value);
        formData.append('subtitle_3', document.getElementById('subtitle_3').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('description_2', document.getElementById('description_2').value);
        formData.append('description_3', document.getElementById('description_3').value);
        formData.append('action_label', document.getElementById('action_label').value);
        formData.append('action_label_2', document.getElementById('action_label_2').value);
        formData.append('action_label_3', document.getElementById('action_label_3').value);
        formData.append('action_url', document.getElementById('action_url').value);
        formData.append('action_url_2', document.getElementById('action_url_2').value);
        formData.append('action_url_3', document.getElementById('action_url_3').value);
        
        // Handle images - check if file uploaded or URL provided
        const imageFields = [
            'image', 'image_2', 'image_3', 
            'image_background', 'image_background_2', 'image_background_3'
        ];
        
        imageFields.forEach(field => {
            const fileInput = document.getElementById(field + '_file');
            const urlInput = document.getElementById(field);
            
            if (fileInput && fileInput.files.length > 0) {
                // If file selected, append file
                formData.append(field, fileInput.files[0]);
            } else if (urlInput && urlInput.value) {
                // If URL provided, append URL
                formData.append(field, urlInput.value);
            }
        });

        fetch('/bagoosh/section-hero/store-ajax', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Store ID for later deletion
                document.getElementById('hero_banner_id').value = data.data.id;
                
                // Store ID in block dataset
                const block = document.getElementById(currentEditBlockId);
                if (block) {
                    block.dataset.heroBannerId = data.data.id;
                }
                
                alert('Hero banner saved successfully!');
                closeEditHeroBannerModal();
            } else {
                alert('Error: ' + (data.message || 'Failed to save hero banner'));
            }
        })
        .catch(error => {
            console.error('Error saving hero banner:', error);
            alert('Error saving hero banner. Please try again.');
        })
        .finally(() => {
            // Reset loading state
            saveBtn.disabled = false;
            saveIconCheck.classList.remove('hidden');
            saveIconLoading.classList.add('hidden');
            saveButtonText.textContent = 'Save';
        });
    }

    function deleteHeroBannerBlock() {
        if (!currentEditBlockId) {
            alert('No block selected.');
            return;
        }
        
        if (!confirm('Are you sure you want to delete this hero banner block?')) {
            return;
        }

        const heroId = document.getElementById('hero_banner_id').value;
        
        // Show loading state
        const deleteBtn = document.getElementById('deleteHeroBannerBtn');
        const deleteIconTrash = document.getElementById('deleteIconTrash');
        const deleteIconLoading = document.getElementById('deleteIconLoading');
        const deleteButtonText = document.getElementById('deleteButtonText');
        
        deleteBtn.disabled = true;
        deleteIconTrash.classList.add('hidden');
        deleteIconLoading.classList.remove('hidden');
        deleteButtonText.textContent = 'Deleting...';

        // Function to remove UI block
        const removeUIBlock = () => {
            closeModalWithTransition('editHeroBannerModal', () => {
                const block = document.getElementById(currentEditBlockId);
                if (block) {
                    block.remove();
                    checkEmptyState();
                    updateBlockOrder();
                }
                currentEditBlockId = null;
                
                // Reset loading state
                deleteBtn.disabled = false;
                deleteIconTrash.classList.remove('hidden');
                deleteIconLoading.classList.add('hidden');
                deleteButtonText.textContent = 'Delete';
                
                alert('Hero banner block deleted successfully!');
            });
        };

        // If there's saved data, delete from database first
        if (heroId) {
            fetch('/bagoosh/section-hero/delete-ajax/' + heroId, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    removeUIBlock();
                } else {
                    alert('Error: ' + (data.message || 'Failed to delete hero banner from database'));
                    // Reset loading state
                    deleteBtn.disabled = false;
                    deleteIconTrash.classList.remove('hidden');
                    deleteIconLoading.classList.add('hidden');
                    deleteButtonText.textContent = 'Delete';
                }
            })
            .catch(error => {
                console.error('Error deleting hero banner:', error);
                alert('Error deleting hero banner. Please try again.');
                // Reset loading state
                deleteBtn.disabled = false;
                deleteIconTrash.classList.remove('hidden');
                deleteIconLoading.classList.add('hidden');
                deleteButtonText.textContent = 'Delete';
            });
        } else {
            // No saved data, just remove UI block
            removeUIBlock();
        }
    }

    // Default Modal Functions
    function closeEditDefaultModal() {
        closeModalWithTransition('editDefaultModal', () => {
            currentEditBlockId = null;
        });
    }

    function deleteCurrentBlock() {
        if (!currentEditBlockId) {
            alert('No block selected.');
            return;
        }
        
        if (!confirm('Are you sure you want to delete this block?')) {
            return;
        }
        
        // Close modal with transition first
        closeModalWithTransition('editDefaultModal', () => {
            // Remove block after modal closes
            const block = document.getElementById(currentEditBlockId);
            if (block) {
                block.remove();
                checkEmptyState();
                updateBlockOrder();
            }
            currentEditBlockId = null;
        });
    }

    // Add block to the list
    function addBlock(type) {
        // Special handling for hero-banner: wait for style selection first
        if (type === 'hero-banner') {
            blockCounter++;
            pendingHeroBannerBlockId = `block-${blockCounter}`;
            closeBlockLibrary();
            document.getElementById('selectHeroStyleModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            return;
        }
        
        blockCounter++;
        const blockId = `block-${blockCounter}`;
        const config = blockConfig[type];
        const blocksList = document.getElementById('blocksList');
        
        const blockHTML = `
            <div id="${blockId}" data-type="${type}" class="block-item bg-white hover:bg-slate-50 transition-all group">
                <div class="flex items-center gap-4 p-4">
                    <!-- Drag Handle -->
                    <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                        </svg>
                    </div>
                    
                    <!-- Block Info -->
                    <div class="flex-1 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-${config.color}-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-${config.color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                ${getBlockIcon(type)}
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="block-order inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-200 text-slate-700 text-xs font-bold">${blockCounter}</span>
                                <h3 class="font-semibold text-slate-800">${config.name}</h3>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">Click to configure</p>
                        </div>
                    </div>
                    
                    <!-- Edit Button -->
                    <button type="button" 
                            onclick="openEditModal('${blockId}')"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Configure
                    </button>
                </div>
            </div>
        `;
        
        blocksList.insertAdjacentHTML('beforeend', blockHTML);
        closeBlockLibrary();
        checkEmptyState();
        updateBlockOrder(); // Update order numbers after adding new block
        
        // Reinitialize sortable if needed
        if (!sortable) {
            initSortable();
        }
    }

    function getBlockIcon(type) {
        const icons = {
            'title': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>',
            'simple-text': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>',
            'text-editor': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
            'complete-counts': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
            'hero-banner': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
            'about': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'brands': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>'
        };
        return icons[type] || '';
    }

    function checkEmptyState() {
        const blocksList = document.getElementById('blocksList');
        const emptyState = document.getElementById('emptyState');
        
        if (blocksList.children.length === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeBlockLibrary();
            closeEditTitleModal();
            closeEditSimpleTextModal();
            closeEditTextEditorModal();
            closeEditBrandsModal();
            closeEditCompleteCountsModal();
            closeEditDefaultModal();
            closeBlockLibrary();
            closeEditTitleModal();
            closeEditSimpleTextModal();
            closeEditTextEditorModal();
            closeEditBrandsModal();
            closeEditDefaultModal();
        }
    });

    // Close modals on backdrop click
    document.getElementById('blockLibraryModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeBlockLibrary();
        }
    });

    document.getElementById('editTitleModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditTitleModal();
        }
    });

    document.getElementById('editSimpleTextModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditSimpleTextModal();
        }
    });

    document.getElementById('editTextEditorModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditTextEditorModal();
        }
    });

    document.getElementById('editBrandsModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditBrandsModal();
        }
    });

    document.getElementById('editCompleteCountsModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditCompleteCountsModal();
            closeEditBrandsModal();
        }
    });

    document.getElementById('editDefaultModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditDefaultModal();
        }
    });

    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const metaTitleInput = document.getElementById('meta_title');
    const metaDescInput = document.getElementById('meta_description');
    const originalSlug = '{{ $page->slug }}';
    
    titleInput.addEventListener('input', function() {
        if (!slugInput.value || slugInput.value === originalSlug) {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
        updateSEOPreview();
    });

    slugInput.addEventListener('input', updateSEOPreview);
    metaTitleInput.addEventListener('input', function() {
        document.getElementById('metaTitleCount').textContent = this.value.length + ' / 60';
        updateSEOPreview();
    });
    metaDescInput.addEventListener('input', function() {
        document.getElementById('metaDescCount').textContent = this.value.length + ' / 160';
        updateSEOPreview();
    });

    function updateSEOPreview() {
        const title = metaTitleInput.value || titleInput.value || '{{ $page->title }}';
        const slug = slugInput.value || '{{ $page->slug }}';
        const desc = metaDescInput.value || 'Your meta description will appear here...';
        
        document.getElementById('seoPreviewTitle').textContent = title;
        document.getElementById('seoPreviewUrl').textContent = '{{ url('/') }}/' + slug;
        document.getElementById('seoPreviewDesc').textContent = desc;
    }
</script>
@endpush
