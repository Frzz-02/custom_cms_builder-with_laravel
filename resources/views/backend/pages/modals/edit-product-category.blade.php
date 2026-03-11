<!-- Edit Product Category Modal -->
<div id="editProductCategoryModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-5 flex items-center justify-between rounded-t-2xl flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Configure Product Category Block</h2>
                        <p class="text-sm text-green-100">Edit section content and settings</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditProductCategoryModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body (Scrollable) -->
            <div class="flex-1 overflow-y-auto p-6">
                <form id="productCategoryForm" class="space-y-6">
                    
                    <!-- Section Header -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="font-bold text-green-800">Section Information</h3>
                        </div>
                        <p class="text-sm text-green-700">Configure the title, subtitle, and display settings for your product category section</p>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="productCategoryTitle" class="block text-sm font-semibold text-slate-700 mb-2">
                            Section Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="productCategoryTitle" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                               placeholder="e.g., Browse Our Categories"
                               required>
                        <p class="mt-1.5 text-xs text-slate-500">Main heading for the product category section</p>
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label for="productCategorySubtitle" class="block text-sm font-semibold text-slate-700 mb-2">
                            Section Subtitle
                        </label>
                        <input type="text" 
                               id="productCategorySubtitle" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                               placeholder="e.g., Find the perfect products for your needs">
                        <p class="mt-1.5 text-xs text-slate-500">Optional subtitle text below the main heading</p>
                    </div>

                    <!-- Product Category Limit -->
                    <div>
                        <label for="productCategoryLimit" class="block text-sm font-semibold text-slate-700 mb-2">
                            Items Per Page <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   id="productCategoryLimit" 
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                   placeholder="12"
                                   min="1"
                                   max="100"
                                   value="12"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500">Number of category items to display per page (used for pagination)</p>
                    </div>

                    <!-- Info Alert -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-800 mb-1">About Product Categories</p>
                                <p class="text-xs text-blue-700">Product categories are managed separately in the Product Category section. This block only controls how they are displayed on your page with pagination support.</p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal Footer (Fixed) -->
            <div class="bg-slate-50 px-6 py-4 flex items-center justify-between border-t border-slate-200 rounded-b-2xl flex-shrink-0">
                <button type="button" 
                        id="deleteProductCategoryBtn"
                        onclick="deleteProductCategoryBlock()"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 disabled:bg-red-400 disabled:cursor-not-allowed text-white rounded-lg font-medium transition-all flex items-center gap-2 disabled:opacity-50">
                    <svg id="deleteProductCategoryIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <!-- Loading Spinner (Hidden by default) -->
                    <svg id="deleteProductCategoryLoading" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="deleteProductCategoryText">Delete Block</span>
                </button>
                
                <div class="flex items-center gap-3">
                    <button type="button" 
                            onclick="closeEditProductCategoryModal()"
                            class="px-5 py-2.5 text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-all font-medium">
                        Cancel
                    </button>
                    <button type="button" 
                            id="saveProductCategoryBtn"
                            onclick="saveProductCategoryBlock()"
                            class="px-5 py-2.5 bg-green-600 hover:bg-green-700 disabled:bg-green-400 disabled:cursor-not-allowed text-white rounded-lg font-medium transition-all flex items-center gap-2 disabled:opacity-50">
                        <svg id="saveProductCategoryIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <!-- Loading Spinner (Hidden by default) -->
                        <svg id="saveProductCategoryLoading" class="hidden w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="saveProductCategoryText">Save Changes</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
