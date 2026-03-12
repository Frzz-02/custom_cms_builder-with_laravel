@extends('backend.app.layout')

@section('title', 'Create Product Category')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('backend.product-categories.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-2 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Categories
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create New Category</h1>
            <p class="text-gray-600 mt-1">Add a new product category to organize your products</p>
        </div>

        <!-- Form -->
        <form action="{{ route('backend.product-categories.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm p-6">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-6">
                <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                    Slug <span class="text-gray-400 text-xs">(Leave empty to auto-generate)</span>
                </label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror">
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Image -->
            <div class="mb-6">
                <div data-media-picker 
                     data-field-name="image_url" 
                     data-field-id="image_url"
                     data-label="Category Image"
                     data-placeholder="https://example.com/image.jpg"
                     data-initial-value="{{ old('image_url') }}">
                    @include('backend.components.media-picker')
                    @error('image_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Select from media library or enter custom URL. Images will be converted to WebP automatically.</p>
                </div>
            </div>

            <!-- Background Color -->
            <div class="mb-6">
                <label for="background_color" class="block text-sm font-semibold text-gray-700 mb-3">
                    Background Color
                </label>
                
                <!-- Color Palette -->
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-2">Quick Select:</p>
                    <div class="grid grid-cols-10 gap-2">
                        <button type="button" onclick="selectColor('#ef4444')" class="w-10 h-10 rounded-lg bg-red-500 hover:ring-2 hover:ring-red-300 transition-all" title="Red"></button>
                        <button type="button" onclick="selectColor('#f97316')" class="w-10 h-10 rounded-lg bg-orange-500 hover:ring-2 hover:ring-orange-300 transition-all" title="Orange"></button>
                        <button type="button" onclick="selectColor('#f59e0b')" class="w-10 h-10 rounded-lg bg-amber-500 hover:ring-2 hover:ring-amber-300 transition-all" title="Amber"></button>
                        <button type="button" onclick="selectColor('#eab308')" class="w-10 h-10 rounded-lg bg-yellow-500 hover:ring-2 hover:ring-yellow-300 transition-all" title="Yellow"></button>
                        <button type="button" onclick="selectColor('#22c55e')" class="w-10 h-10 rounded-lg bg-green-500 hover:ring-2 hover:ring-green-300 transition-all" title="Green"></button>
                        <button type="button" onclick="selectColor('#3b82f6')" class="w-10 h-10 rounded-lg bg-blue-500 hover:ring-2 hover:ring-blue-300 transition-all" title="Blue"></button>
                        <button type="button" onclick="selectColor('#6366f1')" class="w-10 h-10 rounded-lg bg-indigo-500 hover:ring-2 hover:ring-indigo-300 transition-all" title="Indigo"></button>
                        <button type="button" onclick="selectColor('#a855f7')" class="w-10 h-10 rounded-lg bg-purple-500 hover:ring-2 hover:ring-purple-300 transition-all" title="Purple"></button>
                        <button type="button" onclick="selectColor('#ec4899')" class="w-10 h-10 rounded-lg bg-pink-500 hover:ring-2 hover:ring-pink-300 transition-all" title="Pink"></button>
                        <button type="button" onclick="selectColor('#6b7280')" class="w-10 h-10 rounded-lg bg-gray-500 hover:ring-2 hover:ring-gray-300 transition-all" title="Gray"></button>
                    </div>
                </div>

                <!-- HEX Input -->
                <div class="flex gap-3 items-center">
                    <div class="flex-1">
                        <input type="text" name="background_color" id="background_color" placeholder="#3b82f6" maxlength="7" oninput="updateColorPreview(this)"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono">
                        <p class="mt-1 text-xs text-gray-500">Enter HEX color code (e.g., #3b82f6)</p>
                    </div>
                    <div id="colorPreview" class="w-16 h-16 rounded-lg border-2 border-gray-300 shadow-sm bg-gray-100"></div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-6">
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

            <!-- SEO Section -->
            <div class="border-t border-gray-200 pt-6 mb-6">
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

            <!-- Submit Button -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    Create Category
                </button>
                <a href="{{ route('backend.product-categories.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('input', function() {
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

    // Toggle between upload and URL input
    function toggleImageInput(type) {
        const uploadSection = document.getElementById('uploadSection');
        const urlSection = document.getElementById('urlSection');
        const imagePreview = document.getElementById('imagePreview');
        
        if (type === 'upload') {
            uploadSection.classList.remove('hidden');
            urlSection.classList.add('hidden');
            document.getElementById('image_url').value = '';
        } else {
            uploadSection.classList.add('hidden');
            urlSection.classList.remove('hidden');
            document.getElementById('image_file').value = '';
        }
        
        // Hide preview when switching
        imagePreview.classList.add('hidden');
    }

    // Preview uploaded image
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
        }
    }

    // Preview image from URL
    function previewImageUrl(input) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const url = input.value.trim();
        
        if (url && url.startsWith('http')) {
            previewImg.src = url;
            preview.classList.remove('hidden');
            
            // Hide preview if image fails to load
            previewImg.onerror = function() {
                preview.classList.add('hidden');
            };
        } else {
            preview.classList.add('hidden');
        }
    }

    // Select color from palette
    function selectColor(hexColor) {
        const bgColorInput = document.getElementById('background_color');
        const colorPreview = document.getElementById('colorPreview');
        
        bgColorInput.value = hexColor;
        colorPreview.style.backgroundColor = hexColor;
    }

    // Update color preview from HEX input
    function updateColorPreview(input) {
        const colorPreview = document.getElementById('colorPreview');
        const hexValue = input.value.trim();
        
        // Validate HEX format
        const hexPattern = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/;
        
        if (hexPattern.test(hexValue)) {
            colorPreview.style.backgroundColor = hexValue;
        } else if (hexValue === '') {
            colorPreview.style.backgroundColor = '#f3f4f6'; // Gray-100 default
        }
    }
</script>
@endsection
