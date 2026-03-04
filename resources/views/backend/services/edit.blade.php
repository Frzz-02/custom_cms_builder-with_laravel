@extends('backend.app.layout')

@section('title', 'Edit Service')

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
                <h1 class="text-2xl font-bold text-slate-800">Edit Service</h1>
                <p class="text-slate-600 mt-1">Update service information</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('backend.services.update', $service) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
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
                               value="{{ old('name', $service->name) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
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
                               value="{{ old('slug', $service->slug) }}"
                               class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('slug') border-red-500 @enderror"
                               required>
                        @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if($service->image)
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Current Image</label>
                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" class="w-32 h-32 rounded-lg object-cover border-2 border-slate-200" loading="lazy" width="128" height="128">
                    </div>
                    @endif

                    <!-- New Image -->
                    <div>
                        <label for="image" class="block text-sm font-semibold text-slate-700 mb-2">
                            {{ $service->image ? 'Change Image' : 'Service Image' }}
                        </label>
                        <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="previewImage(event, 'imagePreview')">
                        <div id="imagePreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-slate-700 mb-2">New Preview:</p>
                            <img src="" alt="Preview" class="w-32 h-32 rounded-lg object-cover border-2 border-slate-200" loading="lazy">
                        </div>
                    </div>

                    <!-- Current Featured Image -->
                    @if($service->image_featured)
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Current Featured Image</label>
                        <img src="{{ Storage::url($service->image_featured) }}" alt="{{ $service->name }}" class="w-48 h-32 rounded-lg object-cover border-2 border-slate-200" loading="lazy">
                    </div>
                    @endif

                    <!-- New Featured Image -->
                    <div>
                        <label for="image_featured" class="block text-sm font-semibold text-slate-700 mb-2">
                            {{ $service->image_featured ? 'Change Featured Image' : 'Featured Image' }}
                        </label>
                        <input type="file" id="image_featured" name="image_featured" accept="image/*" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="previewImage(event, 'featuredPreview')">
                        <div id="featuredPreview" class="mt-4 hidden">
                            <p class="text-sm font-medium text-slate-700 mb-2">New Preview:</p>
                            <img src="" alt="Preview" class="w-48 h-32 rounded-lg object-cover border-2 border-slate-200" loading="lazy">
                        </div>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-semibold text-slate-700 mb-2">Service Description</label>
                        <textarea id="content" name="content" rows="6" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('content', $service->content) }}</textarea>
                    </div>

                    <!-- SEO Fields -->
                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">SEO Settings</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="meta_title" class="block text-sm font-semibold text-slate-700 mb-2">Meta Title</label>
                                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $service->meta_title) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="meta_description" class="block text-sm font-semibold text-slate-700 mb-2">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('meta_description', $service->meta_description) }}</textarea>
                            </div>
                            <div>
                                <label for="meta_keyword" class="block text-sm font-semibold text-slate-700 mb-2">Meta Keywords</label>
                                <input type="text" id="meta_keyword" name="meta_keyword" value="{{ old('meta_keyword', $service->meta_keyword) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-span-4">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 space-y-6 sticky top-24">
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="active" {{ old('status', $service->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $service->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $service->is_featured) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-2 focus:ring-indigo-500">
                            <div>
                                <div class="text-sm font-semibold text-slate-700">Featured Service</div>
                                <div class="text-xs text-slate-500">Show in featured section</div>
                            </div>
                        </label>
                    </div>

                    <hr class="border-slate-200">

                    <div class="space-y-3">
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Service
                        </button>
                        <a href="{{ route('backend.services.index') }}" class="w-full px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition-colors text-center block">Cancel</a>
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
</script>
@endsection
