<!-- Media Picker Input (Inside Form) -->
<div x-data="mediaPickerInput()" x-init="init()">
    <label :for="fieldId" class="block text-sm font-semibold text-gray-700 mb-2">
        <span x-text="label"></span>
    </label>
    <div class="flex gap-2">
        <input type="text" 
               :name="fieldName" 
               :id="fieldId" 
               x-model="selectedUrl"
             @input="handleManualUrlInput()"
             @change="handleManualUrlInput()"
               :readonly="readonly"
               :class="inputClass"
               :placeholder="placeholder">
        <button type="button" 
                @click="openMediaPicker" 
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors whitespace-nowrap">
            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Browse
        </button>
    </div>
    
    <!-- Preview -->
    <div x-show="selectedUrl" class="mt-3">
        <img :src="selectedUrl" alt="Preview" class="h-32 w-auto object-cover rounded-lg border border-gray-300">
    </div>
</div>

<script>
function mediaPickerInput() {
    return {
        fieldName: '',
        fieldId: '',
        label: 'Image',
        placeholder: 'https://example.com/image.jpg',
        inputClass: 'w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500',
        readonly: false,
        selectedUrl: '',
        lastDispatchedUrl: null,

        init() {
            const container = this.$el.closest('[data-media-picker]');
            if (container) {
                this.fieldName = container.dataset.fieldName || this.fieldName;
                this.fieldId = container.dataset.fieldId || this.fieldId;
                this.label = container.dataset.label || this.label;
                this.placeholder = container.dataset.placeholder || this.placeholder;
                this.selectedUrl = container.dataset.initialValue || this.selectedUrl;

                if (/media\s*library/i.test(this.placeholder) && !/external\s*image\s*url/i.test(this.placeholder)) {
                    this.placeholder = 'Select from media library or paste external image URL';
                }
            }

            // Listen for media selection event
            window.addEventListener('media-selected', (event) => {
                if (event.detail.fieldId === this.fieldId) {
                    this.selectedUrl = event.detail.url;
                }
            });
        },

        handleManualUrlInput() {
            const value = (this.selectedUrl || '').trim();

            if (!this.fieldId) {
                return;
            }

            if (this.lastDispatchedUrl === value) {
                return;
            }

            this.lastDispatchedUrl = value;

            window.dispatchEvent(new CustomEvent('media-selected', {
                detail: {
                    fieldId: this.fieldId,
                    url: value
                }
            }));
        },

        openMediaPicker() {
            // Dispatch event to open modal
            window.dispatchEvent(new CustomEvent('open-media-picker', {
                detail: { 
                    fieldId: this.fieldId,
                    currentUrl: this.selectedUrl
                }
            }));
        }
    }
}
</script>
