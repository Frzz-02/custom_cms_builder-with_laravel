@extends('backend.app.layout')

@section('title', 'Create Service')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('backend.services.index') }}" 
               class="text-slate-600 hover:text-slate-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Create Service</h1>
                <p class="text-slate-600 mt-1">Add a new service offering</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('backend.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-12 gap-6">
            <!-- Main Content -->
            <div class="col-span-8">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                            Service Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                               placeholder="e.g., Web Development"
                               required>
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-semibold text-slate-700 mb-2">
                            Slug <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug') }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror"
                               placeholder="e.g., web-development"
                               required>
                        <p class="mt-1 text-xs text-slate-500">URL-friendly version (will be auto-generated if empty)</p>
                        @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Regular Image -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">
                            Service Image
                        </label>
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('image') border-red-500 @enderror"
                               onchange="previewImage(event, 'imagePreview')">
                        <p class="mt-1 text-xs text-slate-500">Will be converted to WebP format automatically</p>
                        @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-slate-700 mb-2">Preview:</p>
                            <img src="" alt="Preview" class="w-32 h-32 rounded-lg object-cover border-2 border-slate-200" loading="lazy">
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div>
                        <label for="image_featured" class="block text-sm font-semibold text-slate-700 mb-2">
                            Featured Image
                        </label>
                        <input type="file" 
                               id="image_featured" 
                               name="image_featured" 
                               accept="image/*"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('image_featured') border-red-500 @enderror"
                               onchange="previewImage(event, 'featuredPreview')">
                        <p class="mt-1 text-xs text-slate-500">Larger image for featured display. Will be converted to WebP</p>
                        @error('image_featured')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <div id="featuredPreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-slate-700 mb-2">Preview:</p>
                            <img src="" alt="Preview" class="w-48 h-32 rounded-lg object-cover border-2 border-slate-200" loading="lazy">
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-semibold text-slate-700 mb-2">
                            Service Description
                        </label>
                        <textarea id="content" 
                                  name="content" 
                                  rows="6"
                                  class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('content') border-red-500 @enderror"
                                  placeholder="Describe your service...">{{ old('content') }}</textarea>
                        @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SEO Fields -->
                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">SEO Settings</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="meta_title" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Meta Title
                                </label>
                                <input type="text" 
                                       id="meta_title" 
                                       name="meta_title" 
                                       value="{{ old('meta_title') }}"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="SEO title for search engines">
                            </div>

                            <div>
                                <label for="meta_description" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Meta Description
                                </label>
                                <textarea id="meta_description" 
                                          name="meta_description" 
                                          rows="3"
                                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Brief description for search results">{{ old('meta_description') }}</textarea>
                            </div>

                            <div>
                                <label for="meta_keyword" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Meta Keywords
                                </label>
                                <input type="text" 
                                       id="meta_keyword" 
                                       name="meta_keyword" 
                                       value="{{ old('meta_keyword') }}"
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
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Featured Checkbox -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="is_featured" 
                                   value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}
                                   class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-2 focus:ring-indigo-500">
                            <div>
                                <div class="text-sm font-semibold text-slate-700">Featured Service</div>
                                <div class="text-xs text-slate-500">Show in featured section</div>
                            </div>
                        </label>
                    </div>

                    <hr class="border-slate-200">

                    <!-- Actions -->
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create Service
                        </button>
                        <a href="{{ route('backend.services.index') }}" 
                           class="w-full px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition-colors text-center block">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(event, previewId) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            preview.classList.remove('hidden');
            preview.querySelector('img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

// Auto-generate slug from name
document.getElementById('name').addEventListener('blur', function() {
    const slug = document.getElementById('slug');
    if (!slug.value) {
        slug.value = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
    }
});
</script>
@endsection
