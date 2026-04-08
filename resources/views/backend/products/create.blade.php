@extends('backend.app.layout')

@section('title', 'Create Product')

@section('content')
<div class="p-6">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('backend.products.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Products
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create New Product</h1>
            <p class="text-gray-600 mt-1">Add a new product to your inventory</p>
        </div>

        <!-- Form -->
        <form action="{{ route('backend.products.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Code -->
                    <div>
                        <label for="products_code" class="block text-sm font-semibold text-gray-700 mb-2">
                            Product Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="products_code" id="products_code" value="{{ old('products_code') }}" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('products_code') border-red-500 @enderror">
                        @error('products_code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="product_categories_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="product_categories_id" id="product_categories_id" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('product_categories_id') border-red-500 @enderror">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('product_categories_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_categories_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Title -->
                <div class="mt-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Product Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mt-6">
                    <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                        Slug <span class="text-gray-400 text-xs">(Leave empty to auto-generate)</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Overview -->
                <div class="mt-6">
                    <label for="overview" class="block text-sm font-semibold text-gray-700 mb-2">
                        Overview
                    </label>
                    <textarea name="overview" id="overview" rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('overview') border-red-500 @enderror">{{ old('overview') }}</textarea>
                    @error('overview')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div class="mt-6">
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="content" id="content" rows="6"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Pricing & Stock -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing & Stock</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Regular Price
                        </label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Price -->
                    <div>
                        <label for="sale_price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Sale Price
                        </label>
                        <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('sale_price') border-red-500 @enderror">
                        @error('sale_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                            Stock
                        </label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('stock') border-red-500 @enderror">
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Image</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Image URL with Media Picker -->
                    <div data-media-picker 
                         data-field-name="image" 
                         data-field-id="image"
                         data-label="Image URL"
                         data-placeholder="https://example.com/image.jpg"
                         data-initial-value="{{ old('image') }}">
                        @include('backend.components.media-picker-input')
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Select from media library or enter custom URL</p>
                    </div>

                    <!-- Image Title -->
                    <div>
                        <label for="image_title" class="block text-sm font-semibold text-gray-700 mb-2">
                            Image Title (Alt Text)
                        </label>
                        <input type="text" name="image_title" id="image_title" value="{{ old('image_title') }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('image_title') border-red-500 @enderror">
                        @error('image_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Settings</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Is Featured -->
                    <div>
                        <label for="is_featured" class="block text-sm font-semibold text-gray-700 mb-2">
                            Featured Product
                        </label>
                        <select name="is_featured" id="is_featured"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="no" {{ old('is_featured') === 'no' ? 'selected' : '' }}>No</option>
                            <option value="yes" {{ old('is_featured') === 'yes' ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Show Price -->
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                    name="show_price" 
                                    value="1" 
                                    {{ old('show_price', true) ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                            <span class="ml-3 text-sm font-medium text-slate-700">Displays Prices</span>
                        </label>
                    </div>

                </div>
            </div>

            <!-- SEO Settings -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Settings</h3>

                <!-- Meta Title -->
                <div class="mb-6">
                    <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Meta Title
                    </label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Meta Description -->
                <div class="mb-6">
                    <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Meta Description
                    </label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('meta_description') }}</textarea>
                </div>

                <!-- Meta Keywords -->
                <div class="mb-6">
                    <label for="meta_keywords" class="block text-sm font-semibold text-gray-700 mb-2">
                        Meta Keywords
                    </label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="keyword1, keyword2, keyword3">
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    Create Product
                </button>
                <a href="{{ route('backend.products.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value || slugInput.dataset.userEdited !== 'true') {
            slugInput.value = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
        }
    });

    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.userEdited = 'true';
    });

    // Preview image from URL
    function previewImageFromUrl(event) {
        const url = event.target.value;
        const preview = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('imagePreviewContainer');
        
        if (url) {
            const img = new Image();
            img.onload = function() {
                preview.src = url;
                previewContainer.classList.remove('hidden');
            };
            img.onerror = function() {
                previewContainer.classList.add('hidden');
            };
            img.src = url;
        } else {
            previewContainer.classList.add('hidden');
        }
    }
</script>

<!-- Media Picker Modal (Outside Form) -->
@include('backend.components.media-picker-modal')
@endsection
