@extends('backend.app.layout')

@section('title', 'Edit Product Category')

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
            <h1 class="text-3xl font-bold text-gray-900">Edit Category</h1>
            <p class="text-gray-600 mt-1">Update category information</p>
        </div>

        <!-- Form -->
        <form action="{{ route('backend.product-categories.update', $productCategory) }}" method="POST" class="bg-white rounded-xl shadow-sm p-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $productCategory->name) }}" required
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
                <input type="text" name="slug" id="slug" value="{{ old('slug', $productCategory->slug) }}"
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
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $productCategory->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                    <option value="active" {{ old('status', $productCategory->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $productCategory->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $productCategory->meta_title) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Meta Description -->
                <div class="mb-6">
                    <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Meta Description
                    </label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('meta_description', $productCategory->meta_description) }}</textarea>
                </div>

                <!-- Meta Keywords -->
                <div class="mb-6">
                    <label for="meta_keywords" class="block text-sm font-semibold text-gray-700 mb-2">
                        Meta Keywords
                    </label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $productCategory->meta_keywords) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="keyword1, keyword2, keyword3">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    Update Category
                </button>
                <a href="{{ route('backend.product-categories.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const originalSlug = '{{ $productCategory->slug }}';
    
    document.getElementById('name').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value || slugInput.value === originalSlug || slugInput.dataset.userEdited !== 'true') {
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
</script>
@endsection
