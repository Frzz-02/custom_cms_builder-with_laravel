@extends('backend.app.layout')

@section('title', 'Media Library')

@section('content')
<div class="p-8" x-data="mediaManager()" x-init="init()">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Media Library</h1>
            <p class="text-gray-600 text-sm mt-1">Manage all your images here</p>
        </div>
        <button @click="openUploadModal = true" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md transition-all duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            Upload Image
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-5 py-4 rounded-lg mb-5 text-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 px-5 py-4 rounded-lg mb-5 text-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Media Grid -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
        @if($media->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($media as $item)
                    <div class="group relative bg-gray-50 rounded-lg overflow-hidden border border-gray-200 hover:border-indigo-500 transition-all duration-300 cursor-pointer" @click="viewImage('{{ asset('storage/uploads/' . $item->file_encrypt) }}', '{{ $item->filename }}', '{{ $item->alternative_text }}', {{ $item->id }})">
                        <div class="aspect-square overflow-hidden bg-white relative">
                            <!-- Loading placeholder -->
                            <div class="absolute inset-0 bg-gray-200 animate-pulse lazy-placeholder"></div>
                            <!-- Lazy loaded image -->
                            <img data-src="{{ asset('storage/uploads/' . $item->file_encrypt) }}" 
                                 alt="{{ $item->alternative_text }}" 
                                 loading="lazy"
                                 class="lazy-image w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 opacity-0">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                            <div class="p-3 w-full">
                                <p class="text-white text-xs font-medium truncate">{{ $item->filename }}</p>
                                <p class="text-gray-300 text-xs truncate">{{ number_format($item->file_size / 1024, 2) }} KB</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $media->links() }}
            </div>
        @else
            <div class="flex flex-col items-center py-16">
                <svg class="w-24 h-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">No images found</p>
                <p class="text-gray-400 text-sm mt-1">Get started by uploading your first image</p>
                <button @click="openUploadModal = true" class="mt-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                    Upload Image
                </button>
            </div>
        @endif
    </div>

    <!-- Upload Modal -->
    <div x-show="openUploadModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true"
         @keydown.escape.window="openUploadModal = false">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="openUploadModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="openUploadModal = false"
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="openUploadModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form @submit.prevent="uploadImage" enctype="multipart/form-data">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Upload New Image
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <!-- File Input -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Image</label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors"
                                             @drop.prevent="handleFileDrop($event)"
                                             @dragover.prevent
                                             @dragenter.prevent="$el.classList.add('border-indigo-500')"
                                             @dragleave.prevent="$el.classList.remove('border-indigo-500')">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                        <span>Upload a file</span>
                                                        <input id="file-upload" 
                                                               name="file" 
                                                               type="file" 
                                                               accept="image/*"
                                                               class="sr-only" 
                                                               @change="handleFileSelect($event)"
                                                               required>
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG, WEBP up to 5MB</p>
                                                <p x-show="fileName" class="text-sm text-indigo-600 font-medium" x-text="fileName"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Alternative Text -->
                                    <div>
                                        <label for="alternative_text" class="block text-sm font-medium text-gray-700 mb-2">
                                            Alternative Text (Optional)
                                        </label>
                                        <input type="text" 
                                               name="alternative_text" 
                                               id="alternative_text"
                                               x-model="alternativeText"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                               placeholder="Describe the image">
                                    </div>

                                    <!-- Preview -->
                                    <div x-show="previewUrl" class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                                        <img :src="previewUrl" alt="Preview" class="w-full h-48 object-contain bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-xs text-gray-500 mt-2">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Image will be automatically converted to WebP format for better performance
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                                :disabled="uploading"
                                :class="uploading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-700'"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <span x-show="!uploading">Upload</span>
                            <span x-show="uploading" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Uploading...
                            </span>
                        </button>
                        <button type="button"
                                @click="closeUploadModal"
                                :disabled="uploading"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Image Modal -->
    <div x-show="openViewModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" 
         aria-modal="true"
         @keydown.escape.window="openViewModal = false">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openViewModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900 bg-opacity-90 transition-opacity" 
                 @click="openViewModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="openViewModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900" x-text="viewingFilename"></h3>
                            <p class="text-sm text-gray-500" x-text="viewingAlt"></p>
                            <p class="text-xs text-indigo-600 mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Optimized WebP Format
                            </p>
                        </div>
                        <button @click="openViewModal = false" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="mb-4 relative">
                        <!-- Loading spinner -->
                        <div x-show="imageLoading" class="absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg">
                            <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <img :src="viewingUrl" 
                             :alt="viewingAlt" 
                             @load="imageLoading = false"
                             class="w-full h-auto max-h-96 object-contain bg-gray-50 rounded-lg"
                             :class="{ 'opacity-0': imageLoading, 'opacity-100': !imageLoading }"
                             style="transition: opacity 0.3s;">
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                        <div class="flex">
                            <input type="text" 
                                   :value="viewingUrl" 
                                   readonly
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg bg-white text-sm"
                                   @click="$event.target.select()">
                            <button @click="copyUrl(viewingUrl)" 
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button @click="openViewModal = false"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Close
                        </button>
                        <button @click="deleteImage(viewingId)"
                                :disabled="deleting"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50">
                            <span x-show="!deleting">Delete</span>
                            <span x-show="deleting">Deleting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    /* Lazy loading styles */
    .lazy-image {
        transition: opacity 0.5s ease-in-out;
    }
    
    .lazy-image.loaded {
        opacity: 1 !important;
    }
    
    .lazy-placeholder {
        transition: opacity 0.3s ease-in-out;
    }
    
    .lazy-placeholder.hidden {
        opacity: 0;
    }
</style>

<script>
function mediaManager() {
    return {
        openUploadModal: false,
        openViewModal: false,
        uploading: false,
        deleting: false,
        imageLoading: false,
        fileName: '',
        alternativeText: '',
        previewUrl: '',
        viewingUrl: '',
        viewingFilename: '',
        viewingAlt: '',
        viewingId: null,

        init() {
            // Initialize lazy loading with Intersection Observer
            this.initLazyLoading();
        },

        initLazyLoading() {
            // Check if browser supports Intersection Observer
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            const placeholder = img.previousElementSibling;
                            
                            // Load the image
                            img.src = img.dataset.src;
                            
                            // When image is loaded, hide placeholder and show image
                            img.onload = () => {
                                img.classList.add('loaded');
                                if (placeholder && placeholder.classList.contains('lazy-placeholder')) {
                                    placeholder.classList.add('hidden');
                                }
                            };
                            
                            // Stop observing this image
                            observer.unobserve(img);
                        }
                    });
                }, {
                    // Load images 50px before they enter viewport
                    rootMargin: '50px'
                });

                // Observe all lazy images
                document.querySelectorAll('.lazy-image').forEach(img => {
                    imageObserver.observe(img);
                });
            } else {
                // Fallback for older browsers - load all images immediately
                document.querySelectorAll('.lazy-image').forEach(img => {
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    const placeholder = img.previousElementSibling;
                    if (placeholder && placeholder.classList.contains('lazy-placeholder')) {
                        placeholder.classList.add('hidden');
                    }
                });
            }
        },

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.fileName = file.name;
                this.previewUrl = URL.createObjectURL(file);
                if (!this.alternativeText) {
                    this.alternativeText = file.name.replace(/\.[^/.]+$/, '');
                }
            }
        },

        handleFileDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('file-upload').files = event.dataTransfer.files;
                this.fileName = file.name;
                this.previewUrl = URL.createObjectURL(file);
                if (!this.alternativeText) {
                    this.alternativeText = file.name.replace(/\.[^/.]+$/, '');
                }
            }
        },

        async uploadImage(event) {
            this.uploading = true;
            const formData = new FormData(event.target);

            try {
                const response = await fetch('{{ route('backend.media.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                });

                // Check if response is OK
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: 'Upload failed' }));
                    throw new Error(errorData.message || 'Upload failed');
                }

                const data = await response.json();

                if (data.success) {
                    // Show success message
                    alert('Image uploaded successfully!');
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to upload image');
                }
            } catch (error) {
                console.error('Upload Error:', error);
                alert(error.message || 'An error occurred while uploading');
            } finally {
                this.uploading = false;
            }
        },

        closeUploadModal() {
            this.openUploadModal = false;
            this.fileName = '';
            this.alternativeText = '';
            this.previewUrl = '';
            document.getElementById('file-upload').value = '';
        },

        viewImage(url, filename, alt, id) {
            this.imageLoading = true;
            this.viewingUrl = url;
            this.viewingFilename = filename;
            this.viewingAlt = alt;
            this.viewingId = id;
            this.openViewModal = true;
        },

        async deleteImage(id) {
            if (!confirm('Are you sure you want to delete this image?')) {
                return;
            }

            this.deleting = true;

            try {
                const response = await fetch(`{{ route('backend.media.index') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                });

                const data = await response.json();

                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to delete image');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while deleting');
            } finally {
                this.deleting = false;
            }
        },

        copyUrl(url) {
            navigator.clipboard.writeText(url);
            alert('URL copied to clipboard!');
        }
    }
}
</script>
@endsection
