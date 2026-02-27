@extends('backend.app.layout')

@section('title', 'Edit Brand')

@section('content')
<div class="p-8">
    <div class="mb-6">
        <div class="flex items-center text-sm text-gray-600 mb-4">
            <a href="{{ route('backend.brands.index') }}" class="hover:text-gray-900">Brands</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-900">Edit</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Brand</h1>
        <p class="text-gray-600 text-sm mt-1">Update the brand information</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('backend.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Brand Name -->
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Brand Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $brand->name) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        placeholder="Enter brand name"
                        required
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo URL -->
                <div class="col-span-2">
                    <label for="logo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Logo URL
                    </label>
                    <input 
                        type="url" 
                        id="logo" 
                        name="logo" 
                        value="{{ old('logo', $brand->logo) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('logo') border-red-500 @enderror"
                        placeholder="https://example.com/logo.png"
                        onchange="previewImageFromUrl(event)"
                    >
                    @error('logo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Enter the URL of the brand logo image</p>
                    @if($brand->logo)
                        <div class="mt-3">
                            <p class="text-xs text-gray-600 mb-2">Current Logo:</p>
                            <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" class="h-16 w-auto object-contain border border-gray-200 rounded p-2">
                        </div>
                    @endif
                    <div id="imagePreview" class="mt-3 hidden">
                        <p class="text-xs text-gray-600 mb-2">New Logo Preview:</p>
                        <img id="preview" src="" alt="Preview" class="h-16 w-auto object-contain border border-gray-200 rounded p-2">
                    </div>
                </div>

                <!-- Website URL -->
                <div class="col-span-2">
                    <label for="url" class="block text-sm font-semibold text-gray-700 mb-2">
                        Website URL
                    </label>
                    <input 
                        type="url" 
                        id="url" 
                        name="url" 
                        value="{{ old('url', $brand->url) }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('url') border-red-500 @enderror"
                        placeholder="https://example.com"
                    >
                    @error('url')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-span-2">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="status" 
                        name="status" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('status') border-red-500 @enderror"
                        required
                    >
                        <option value="active" @selected(old('status', $brand->status) == 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $brand->status) == 'inactive')>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex items-center space-x-4">
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md transition-all duration-300"
                >
                    Update Brand
                </button>
                <a 
                    href="{{ route('backend.brands.index') }}" 
                    class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImageFromUrl(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const url = event.target.value;
    
    if (url) {
        // Test if URL is valid image
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
@endpush
@endsection
