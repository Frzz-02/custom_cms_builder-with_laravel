{{-- Edit Hero Banner Modal --}}
<div id="editHeroBannerModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] overflow-hidden flex flex-col">
        <!-- Modal Header -->
        <div class="px-6 py-5 border-b border-slate-200 bg-gradient-to-r from-indigo-600 to-purple-600 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Configure Hero Banner</h2>
                        <p class="text-sm text-indigo-100">Style <span id="heroBannerStyleDisplay">1</span> - Complete all tabs</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditHeroBannerModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="border-b border-slate-200 bg-slate-50 flex-shrink-0">
            <div class="flex overflow-x-auto px-6">
                <button type="button" onclick="switchHeroTab(1)" data-tab="1" class="hero-tab-btn px-4 py-3 font-medium text-sm border-b-2 border-indigo-600 text-indigo-600 whitespace-nowrap">
                    Tab 1
                </button>
                <button type="button" onclick="switchHeroTab(2)" data-tab="2" class="hero-tab-btn px-4 py-3 font-medium text-sm border-b-2 border-transparent text-slate-600 hover:text-slate-900 whitespace-nowrap">
                    Tab 2
                </button>
                <button type="button" onclick="switchHeroTab(3)" data-tab="3" class="hero-tab-btn px-4 py-3 font-medium text-sm border-b-2 border-transparent text-slate-600 hover:text-slate-900 whitespace-nowrap">
                    Tab 3
                </button>
                <button type="button" onclick="switchHeroTab(4)" data-tab="4" class="hero-tab-btn px-4 py-3 font-medium text-sm border-b-2 border-transparent text-slate-600 hover:text-slate-900 whitespace-nowrap">
                    Tab 4
                </button>
                <button type="button" onclick="switchHeroTab(5)" data-tab="5" class="hero-tab-btn px-4 py-3 font-medium text-sm border-b-2 border-transparent text-slate-600 hover:text-slate-900 whitespace-nowrap">
                    Tab 5
                </button>
                <button type="button" onclick="switchHeroTab(6)" data-tab="6" class="hero-tab-btn px-4 py-3 font-medium text-sm border-b-2 border-transparent text-slate-600 hover:text-slate-900 whitespace-nowrap">
                    Tab 6
                </button>
            </div>
        </div>

        <!-- Modal Body - Scrollable -->
        <div class="flex-1 overflow-y-auto p-6">
            <!-- Tab Content Container -->
            <div id="heroTabsContainer">
                <!-- Tab 1 -->
                <div id="heroTab1" class="hero-tab-content">
                    <div class="space-y-4">
                        <!-- Category Dropdown -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Category
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="heroCategory1" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Select Category</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>

                        <!-- Title Input -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Title
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroTitle1" placeholder="Enter title" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>

                        <!-- Description Textarea -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Description
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea id="heroDescription1" rows="4" placeholder="Enter description" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                        </div>

                        <!-- Action Label Input -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action Label
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionLabel1" placeholder="e.g., Shop Now, Learn More, View Details" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>

                        <!-- Action URL Input -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action URL
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionUrl1" placeholder="e.g., /products or https://example.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <p class="text-xs text-slate-500 mt-1">Internal route: /products, /about | External: https://example.com</p>
                        </div>

                        <!-- Image Upload -->
                        <div data-media-picker 
                             data-field-name="heroImage1" 
                             data-field-id="heroImage1"
                             data-label="Image"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                            <p class="mt-1 text-xs text-slate-500">Select from media library or enter custom URL. Images will be converted to WebP automatically.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 2 -->
                <div id="heroTab2" class="hero-tab-content hidden">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Category
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="heroCategory2" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Title
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroTitle2" placeholder="Enter title" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Description
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea id="heroDescription2" rows="4" placeholder="Enter description" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action Label
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionLabel2" placeholder="e.g., Shop Now, Learn More, View Details" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action URL
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionUrl2" placeholder="e.g., /products or https://example.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <p class="text-xs text-slate-500 mt-1">Internal route: /products, /about | External: https://example.com</p>
                        </div>
                        <div data-media-picker 
                             data-field-name="heroImage2" 
                             data-field-id="heroImage2"
                             data-label="Image"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                            <p class="mt-1 text-xs text-slate-500">Select from media library or enter custom URL. Images will be converted to WebP automatically.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 3 -->
                <div id="heroTab3" class="hero-tab-content hidden">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Category
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="heroCategory3" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Title
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroTitle3" placeholder="Enter title" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Description
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea id="heroDescription3" rows="4" placeholder="Enter description" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action Label
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionLabel3" placeholder="e.g., Shop Now, Learn More, View Details" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action URL
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionUrl3" placeholder="e.g., /products or https://example.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <p class="text-xs text-slate-500 mt-1">Internal route: /products, /about | External: https://example.com</p>
                        </div>
                        <div data-media-picker 
                             data-field-name="heroImage3" 
                             data-field-id="heroImage3"
                             data-label="Image"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                            <p class="mt-1 text-xs text-slate-500">Select from media library or enter custom URL. Images will be converted to WebP automatically.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 4 -->
                <div id="heroTab4" class="hero-tab-content hidden">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Category
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="heroCategory4" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Title
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroTitle4" placeholder="Enter title" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Description
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea id="heroDescription4" rows="4" placeholder="Enter description" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action Label
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionLabel4" placeholder="e.g., Shop Now, Learn More, View Details" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action URL
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionUrl4" placeholder="e.g., /products or https://example.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <p class="text-xs text-slate-500 mt-1">Internal route: /products, /about | External: https://example.com</p>
                        </div>
                        <div data-media-picker 
                             data-field-name="heroImage4" 
                             data-field-id="heroImage4"
                             data-label="Image"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                            <p class="mt-1 text-xs text-slate-500">Select from media library or enter custom URL. Images will be converted to WebP automatically.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 5 -->
                <div id="heroTab5" class="hero-tab-content hidden">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Category
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="heroCategory5" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Title
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroTitle5" placeholder="Enter title" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Description
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea id="heroDescription5" rows="4" placeholder="Enter description" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action Label
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionLabel5" placeholder="e.g., Shop Now, Learn More, View Details" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action URL
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionUrl5" placeholder="e.g., /products or https://example.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <p class="text-xs text-slate-500 mt-1">Internal route: /products, /about | External: https://example.com</p>
                        </div>
                        <div data-media-picker 
                             data-field-name="heroImage5" 
                             data-field-id="heroImage5"
                             data-label="Image"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                            <p class="mt-1 text-xs text-slate-500">Select from media library or enter custom URL. Images will be converted to WebP automatically.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 6 -->
                <div id="heroTab6" class="hero-tab-content hidden">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Product Category
                                <span class="text-red-500">*</span>
                            </label>
                            <select id="heroCategory6" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Title
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroTitle6" placeholder="Enter title" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Description
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea id="heroDescription6" rows="4" placeholder="Enter description" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action Label
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionLabel6" placeholder="e.g., Shop Now, Learn More, View Details" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Action URL
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="heroActionUrl6" placeholder="e.g., /products or https://example.com" class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <p class="text-xs text-slate-500 mt-1">Internal route: /products, /about | External: https://example.com</p>
                        </div>
                        <div data-media-picker 
                             data-field-name="heroImage6" 
                             data-field-id="heroImage6"
                             data-label="Image"
                             data-placeholder="Select from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                            <p class="mt-1 text-xs text-slate-500">Select from media library or enter custom URL. Images will be converted to WebP automatically.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between flex-shrink-0">
            <button type="button" id="deleteHeroBannerBtn" onclick="deleteHeroBannerBlock()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg id="deleteHeroBannerIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <svg id="deleteHeroBannerLoading" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="deleteHeroBannerText">Delete</span>
            </button>
            <div class="flex gap-3">
                <button type="button" onclick="closeEditHeroBannerModal()" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="button" id="saveHeroBannerBtn" onclick="saveHeroBannerBlock()" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg id="saveHeroBannerIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg id="saveHeroBannerLoading" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="saveHeroBannerText">Save</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Media Picker Modal (Outside Form) -->
@include('backend.components.media-picker-modal')
