{{-- Edit Hero Banner Style 2 Modal --}}
<div id="editHeroBannerStyle2Modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
        <!-- Modal Header -->
        <div class="px-6 py-5 border-b border-slate-200 bg-gradient-to-r from-purple-600 to-pink-600 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Configure Hero Banner</h2>
                        <p class="text-sm text-purple-100">Style 2 - Complete all fields</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditHeroBannerStyle2Modal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body - Scrollable -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="space-y-6">
                <!-- Title Input -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Title
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="heroStyle2Title" placeholder="Enter title" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>

                <!-- Description Textarea -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Description
                        <span class="text-red-500">*</span>
                    </label>
                    <textarea id="heroStyle2Description" rows="4" placeholder="Enter description" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"></textarea>
                </div>

                <!-- Images Upload Section -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">
                        Images (4 Required)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <div data-media-picker
                             data-field-name="heroStyle2Image1"
                             data-field-id="heroStyle2Image1"
                             data-label="Image 1"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>

                        <div data-media-picker
                             data-field-name="heroStyle2Image2"
                             data-field-id="heroStyle2Image2"
                             data-label="Image 2"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>

                        <div data-media-picker
                             data-field-name="heroStyle2Image3"
                             data-field-id="heroStyle2Image3"
                             data-label="Image 3"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>

                        <div data-media-picker
                             data-field-name="heroStyle2Image4"
                             data-field-id="heroStyle2Image4"
                             data-label="Image 4"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Section -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">
                        Action Buttons (2 Required)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-4">
                        <!-- Action 1 -->
                        <div class="p-4 border border-slate-200 rounded-lg bg-slate-50">
                            <h4 class="text-sm font-semibold text-slate-700 mb-3">Action Button 1</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">
                                        Label <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="heroStyle2ActionLabel1" placeholder="e.g., Shop Now, Learn More" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">
                                        URL <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="heroStyle2ActionUrl1" placeholder="e.g., /products or https://example.com" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm">
                                    <p class="text-xs text-slate-500 mt-1">Internal: /products | External: https://example.com</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action 2 -->
                        <div class="p-4 border border-slate-200 rounded-lg bg-slate-50">
                            <h4 class="text-sm font-semibold text-slate-700 mb-3">Action Button 2</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">
                                        Label <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="heroStyle2ActionLabel2" placeholder="e.g., View Details, Contact Us" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-600 mb-1">
                                        URL <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="heroStyle2ActionUrl2" placeholder="e.g., /about or https://example.com" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all text-sm">
                                    <p class="text-xs text-slate-500 mt-1">Internal: /about | External: https://example.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Checkboxes Section -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Featured Services (Select Exactly 3)
                        <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 mb-3">You must select exactly 3 services. No more, no less.</p>
                    <div id="heroStyle2ServicesContainer" class="space-y-2 max-h-60 overflow-y-auto p-4 border border-slate-200 rounded-lg bg-slate-50">
                        <div class="flex items-center justify-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600"></div>
                        </div>
                    </div>
                    <div id="heroStyle2ServicesCounter" class="mt-2 text-xs font-medium text-slate-600">
                        Selected: <span id="heroStyle2ServicesCount" class="text-purple-600">0</span> / 3
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between flex-shrink-0">
            <button type="button" id="deleteHeroBannerStyle2Btn" onclick="deleteHeroBannerStyle2Block()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg id="deleteHeroBannerStyle2Icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <svg id="deleteHeroBannerStyle2Loading" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="deleteHeroBannerStyle2Text">Delete</span>
            </button>
            <div class="flex gap-3">
                <button type="button" onclick="closeEditHeroBannerStyle2Modal()" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="button" id="saveHeroBannerStyle2Btn" onclick="saveHeroBannerStyle2Block()" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg id="saveHeroBannerStyle2Icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg id="saveHeroBannerStyle2Loading" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="saveHeroBannerStyle2Text">Save</span>
                </button>
            </div>
        </div>
    </div>
</div>
