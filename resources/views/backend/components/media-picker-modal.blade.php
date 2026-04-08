<!-- Media Picker Modal (Outside Form) -->
<div x-data="mediaPickerModal()" x-init="init()" x-cloak>
    <!-- Media Picker Modal -->
        <div x-show="isOpen" 
            class="fixed inset-0 z-[100] overflow-y-auto" 
         role="dialog" 
         aria-modal="true"
         @keydown.escape.window="closePicker()">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="isOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="closePicker()"
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="isOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full">
                
                <div class="bg-white">
                    <!-- Header -->
                    <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-gray-900">Select Image</h3>
                        <button @click="closePicker()" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex gap-3">
                        <button @click="showUploadModal = true" 
                                type="button"
                                class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Media
                        </button>
                        <a href="/bagoosh/media" 
                           target="_blank"
                           class="px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            View All Media
                        </a>
                    </div>

                    <!-- Media Grid -->
                    <div class="px-6 py-4" style="max-height: 500px; overflow-y: auto;">
                        <div x-show="loading" class="text-center py-12">
                            <svg class="animate-spin h-10 w-10 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-gray-500 mt-2">Loading media...</p>
                        </div>

                        <div x-show="!loading && mediaList.length > 0" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                            <template x-for="media in mediaList" :key="media.id">
                                <div @click="selectImage(media)" 
                                     class="group relative bg-gray-50 rounded-lg overflow-hidden border-2 cursor-pointer transition-all duration-200"
                                     :class="tempSelectedUrl === media.url ? 'border-indigo-600 ring-2 ring-indigo-200' : 'border-gray-200 hover:border-indigo-400'">
                                    <div class="aspect-square overflow-hidden bg-white">
                                        <img :src="media.url" 
                                             :alt="media.alternative_text" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                        <div class="p-2 w-full">
                                            <p class="text-white text-xs font-medium truncate" x-text="media.filename"></p>
                                        </div>
                                    </div>
                                    <!-- Selected checkmark -->
                                    <div x-show="tempSelectedUrl === media.url" 
                                         class="absolute top-2 right-2 bg-indigo-600 rounded-full p-1">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div x-show="!loading && mediaList.length === 0" class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">No images found</p>
                            <button @click="showUploadModal = true" 
                                    type="button"
                                    class="mt-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                                Upload Your First Image
                            </button>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-200">
                        <button @click="closePicker()" 
                                type="button"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                            Cancel
                        </button>
                        <button @click="confirmSelection()" 
                                type="button"
                                :disabled="!tempSelectedUrl"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            Select Image
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
        <div x-show="showUploadModal" 
            class="fixed inset-0 z-[110] overflow-y-auto" 
         role="dialog" 
         aria-modal="true"
         @keydown.escape.window="showUploadModal = false">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showUploadModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" 
                 @click="showUploadModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

            <div x-show="showUploadModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="uploadMediaForm" enctype="multipart/form-data">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
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
                                                    <label for="modal-upload-file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                        <span>Upload a file</span>
                                                        <input id="modal-upload-file" 
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
                                                <p x-show="uploadFileName" class="text-sm text-indigo-600 font-medium" x-text="uploadFileName"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Alternative Text -->
                                    <div>
                                        <label for="modal-alt-text" class="block text-sm font-medium text-gray-700 mb-2">
                                            Alternative Text (Optional)
                                        </label>
                                        <input type="text" 
                                               name="alternative_text" 
                                               id="modal-alt-text"
                                               x-model="uploadAltText"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                               placeholder="Describe the image">
                                    </div>

                                    <!-- Preview -->
                                    <div x-show="uploadPreviewUrl" class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                                        <img :src="uploadPreviewUrl" alt="Preview" class="w-full h-48 object-contain bg-gray-50 rounded-lg border border-gray-200">
                                        <p class="text-xs text-gray-500 mt-2">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Image will be automatically converted to WebP format
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                                @click="uploadImage()"
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
                                @click="closeUploadModal()"
                                :disabled="uploading"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>

<script>
function mediaPickerModal() {
    return {
        isOpen: false,
        showUploadModal: false,
        loading: false,
        uploading: false,
        mediaList: [],
        tempSelectedUrl: '',
        currentFieldId: '',
        
        uploadFileName: '',
        uploadAltText: '',
        uploadPreviewUrl: '',
        
        apiUrl: '/bagoosh/media/list',
        uploadUrl: '/bagoosh/media',
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',

        init() {
            // Listen for open picker event
            window.addEventListener('open-media-picker', (event) => {
                this.currentFieldId = event.detail.fieldId;
                this.tempSelectedUrl = event.detail.currentUrl || '';
                this.openPicker();
            });
        },

        openPicker() {
            this.isOpen = true;
            this.loadMedia();
        },

        closePicker() {
            this.isOpen = false;
            this.tempSelectedUrl = '';
            this.currentFieldId = '';
        },

        async loadMedia() {
            this.loading = true;
            try {
                const response = await fetch(this.apiUrl);
                const data = await response.json();
                if (data.success) {
                    this.mediaList = data.data.map(media => ({
                        id: media.id,
                        url: `/storage/uploads/${media.file_encrypt}`,
                        filename: media.filename,
                        alternative_text: media.alternative_text
                    }));
                }
            } catch (error) {
                console.error('Failed to load media:', error);
            } finally {
                this.loading = false;
            }
        },

        selectImage(media) {
            this.tempSelectedUrl = media.url;
        },

        confirmSelection() {
            // Dispatch event to update input field
            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: { 
                    fieldId: this.currentFieldId,
                    url: this.tempSelectedUrl
                }
            }));
            this.closePicker();
        },

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.uploadFileName = file.name;
                this.uploadPreviewUrl = URL.createObjectURL(file);
                if (!this.uploadAltText) {
                    this.uploadAltText = file.name.replace(/\.[^/.]+$/, '');
                }
            }
        },

        handleFileDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                document.getElementById('modal-upload-file').files = event.dataTransfer.files;
                this.uploadFileName = file.name;
                this.uploadPreviewUrl = URL.createObjectURL(file);
                if (!this.uploadAltText) {
                    this.uploadAltText = file.name.replace(/\.[^/.]+$/, '');
                }
            }
        },

        async uploadImage() {
            this.uploading = true;
            
            const fileInput = document.getElementById('modal-upload-file');
            if (!fileInput || !fileInput.files || !fileInput.files[0]) {
                alert('Please select a file');
                this.uploading = false;
                return;
            }

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('alternative_text', this.uploadAltText || '');

            try {
                const response = await fetch(this.uploadUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: 'Upload failed' }));
                    throw new Error(errorData.message || 'Upload failed');
                }

                const data = await response.json();

                if (data.success) {
                    this.closeUploadModal();
                    await this.loadMedia();
                    this.tempSelectedUrl = data.url;
                    alert('Image uploaded successfully!');
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
            this.showUploadModal = false;
            this.uploadFileName = '';
            this.uploadAltText = '';
            this.uploadPreviewUrl = '';
            const uploadInput = document.getElementById('modal-upload-file');
            if (uploadInput) uploadInput.value = '';
        }
    }
}
</script>
