{{-- Modal Edit Hero Banner Style 3 --}}
<div id="editHeroBannerStyle3Modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-rose-600 to-pink-600 px-8 py-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-1">Hero Banner Style 3</h3>
                    <p class="text-rose-100 text-sm">2 Titles • 1 Description • 6 Images • 2 Action Buttons</p>
                </div>
                <button 
                    onclick="closeEditHeroBannerStyle3Modal()" 
                    class="text-white/80 hover:text-white transition-colors p-2 hover:bg-white/10 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Body dengan Scroll --}}
        <div class="overflow-y-auto" style="max-height: calc(90vh - 180px);">
            <div class="p-8 space-y-6">
                
                {{-- Title 1 Input --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Title 1 <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="heroStyle3Title1"
                        placeholder="Enter first title..." 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all">
                </div>

                {{-- Title 2 Input --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Title 2 <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="heroStyle3Title2"
                        placeholder="Enter second title..." 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all">
                </div>
                
                
                
                {{-- Experience Input --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Experience <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                               id="heroStyle3Subtitle" 
                               min="1"
                               step="1"
                               value="1"
                               inputmode="numeric"
                               placeholder="Minimum 1"
                               onkeydown="if(['e','E','+','-','.'].includes(event.key)) event.preventDefault();"
                               oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value === '' || parseInt(this.value, 10) < 1){ this.value = '1'; }"
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-rose-500 focus:ring-2 focus:ring-rose-200 outline-none transition-all">
                        <p class="text-xs text-slate-500">Only positive number is allowed (minimum: 1)</p>
                </div>


                
                {{-- Description Input --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="heroStyle3Description"
                        rows="4" 
                        placeholder="Enter description..." 
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all resize-none"></textarea>
                </div>

                {{-- 6 Images Upload (in Grid) --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">
                        Images <span class="text-red-500">* (6 images required)</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div data-media-picker
                             data-field-name="heroStyle3Image1"
                             data-field-id="heroStyle3Image1"
                             data-label="Image 1"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>

                        <div data-media-picker
                             data-field-name="heroStyle3Image2"
                             data-field-id="heroStyle3Image2"
                             data-label="Image 2"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>

                        <div data-media-picker
                             data-field-name="heroStyle3Image3"
                             data-field-id="heroStyle3Image3"
                             data-label="Image 3"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>

                        <div data-media-picker
                             data-field-name="heroStyle3Image4"
                             data-field-id="heroStyle3Image4"
                             data-label="Image 4"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>

                        <div data-media-picker
                             data-field-name="heroStyle3Image5"
                             data-field-id="heroStyle3Image5"
                             data-label="Image 5"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>

                        <div data-media-picker
                             data-field-name="heroStyle3Image6"
                             data-field-id="heroStyle3Image6"
                             data-label="Image 6"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>
                    </div>
                </div>

                {{-- Action Button 1 --}}
                <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-rose-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">1</span>
                        </div>
                        <h4 class="text-lg font-semibold text-slate-800">Action Button 1</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Button Label <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="heroStyle3ActionLabel1"
                                placeholder="e.g., Get Started" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Button URL <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="url" 
                                id="heroStyle3ActionUrl1"
                                placeholder="https://example.com" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all">
                        </div>
                    </div>
                </div>

                {{-- Action Button 2 --}}
                <div class="bg-slate-50 rounded-xl p-6 border border-slate-200">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-rose-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">2</span>
                        </div>
                        <h4 class="text-lg font-semibold text-slate-800">Action Button 2</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Button Label <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="heroStyle3ActionLabel2"
                                placeholder="e.g., Learn More" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Button URL <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="url" 
                                id="heroStyle3ActionUrl2"
                                placeholder="https://example.com" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition-all">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Footer dengan Action Buttons --}}
        <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
            <button 
                type="button" 
                id="deleteHeroBannerStyle3Btn"
                onclick="deleteHeroBannerStyle3Block()" 
                class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-all flex items-center gap-2 shadow-sm hover:shadow">
                <svg id="deleteHeroBannerStyle3IconTrash" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <svg id="deleteHeroBannerStyle3IconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="deleteHeroBannerStyle3Text">Delete</span>
            </button>
            
            <div class="flex items-center gap-3">
                <button 
                    type="button" 
                    onclick="closeEditHeroBannerStyle3Modal()" 
                    class="px-6 py-2.5 bg-white border-2 border-slate-300 hover:border-slate-400 text-slate-700 font-medium rounded-lg transition-all">
                    Cancel
                </button>
                <button 
                    type="button" 
                    id="saveHeroBannerStyle3Btn"
                    onclick="saveHeroBannerStyle3Block()" 
                    class="px-6 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-lg transition-all flex items-center gap-2 shadow-sm hover:shadow">
                    <svg id="saveHeroBannerStyle3Icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg id="saveHeroBannerStyle3Loading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="saveHeroBannerStyle3Text">Save</span>
                </button>
            </div>
        </div>
    </div>
</div>
