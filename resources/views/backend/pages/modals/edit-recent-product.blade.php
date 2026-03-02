<!-- Edit Recent Product Modal -->
<div id="editRecentProductModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Edit Recent Product</h3>
                    <p class="text-sm text-green-100">Configure your recent products section</p>
                </div>
            </div>
            <button type="button" onclick="closeEditRecentProductModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 space-y-5">
            <!-- Hidden field to store shortcode ID -->
            <input type="hidden" id="recentproduct_shortcode_id" value="">

            <!-- Title -->
            <div>
                <label for="recentproduct_title" class="block text-sm font-semibold text-slate-700 mb-2">
                    Title
                </label>
                <input 
                    type="text" 
                    id="recentproduct_title" 
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" 
                    placeholder="e.g., Our Latest Products"
                >
            </div>

            <!-- Subtitle -->
            <div>
                <label for="recentproduct_subtitle" class="block text-sm font-semibold text-slate-700 mb-2">
                    Subtitle
                </label>
                <input 
                    type="text" 
                    id="recentproduct_subtitle" 
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all" 
                    placeholder="e.g., Check out our newest arrivals"
                >
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4">
                <!-- Delete Button -->
                <button 
                    type="button" 
                    id="deleteRecentProductBtn"
                    onclick="deleteRecentProductBlock()" 
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2"
                >
                    <svg id="deleteRecentProductIconTrash" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg id="deleteRecentProductIconLoading" class="animate-spin h-5 w-5 text-white hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="deleteRecentProductButtonText">Delete</span>
                </button>

                <!-- Save Button -->
                <button 
                    type="button" 
                    id="saveRecentProductBtn"
                    onclick="saveRecentProductBlock()" 
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2"
                >
                    <svg id="saveRecentProductIconCheck" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <svg id="saveRecentProductIconLoading" class="animate-spin h-5 w-5 text-white hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="saveRecentProductButtonText">Save Changes</span>
                </button>
            </div>
        </div>
    </div>
</div>
