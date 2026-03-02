<!-- Edit Testimonials Modal -->
<div id="editTestimonialsModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-yellow-500 to-amber-600 px-6 py-5 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Configure Testimonials</h2>
                        <p class="text-sm text-yellow-50">Customize your testimonials section</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditTestimonialsModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                <input type="hidden" id="testimonials_shortcode_id" value="">
                <input type="hidden" id="testimonials_style_value" value="">
                
                <div class="space-y-6">
                    <!-- Style Display -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Selected Style
                        </label>
                        <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-yellow-50 to-amber-50 border-2 border-yellow-200 rounded-lg">
                            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-slate-800" id="testimonials_style_display">Style 1</div>
                                <div class="text-sm text-slate-600">Testimonials layout style</div>
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="testimonials_title" class="block text-sm font-semibold text-slate-700 mb-2">
                            Section Title
                        </label>
                        <input type="text" 
                               id="testimonials_title" 
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                               placeholder="e.g., What Our Clients Say">
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label for="testimonials_subtitle" class="block text-sm font-semibold text-slate-700 mb-2">
                            Section Subtitle
                        </label>
                        <input type="text" 
                               id="testimonials_subtitle" 
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all"
                               placeholder="e.g., Real feedback from our amazing clients">
                    </div>

                    <!-- Select Testimonials -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">
                            Select Testimonials
                        </label>
                        <div id="testimonialsList" class="space-y-3 max-h-64 overflow-y-auto border-2 border-slate-200 rounded-lg p-4">
                            <!-- Will be populated by JavaScript -->
                            <div class="text-center py-8 text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Loading testimonials...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-slate-50 px-6 py-4 flex items-center justify-between sticky bottom-0">
                <button type="button" 
                        id="deleteTestimonialsBtn"
                        onclick="deleteTestimonialsBlock()" 
                        class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-all flex items-center gap-2">
                    <svg id="deleteTestimonialsIconTrash" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg id="deleteTestimonialsIconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="deleteTestimonialsButtonText">Delete</span>
                </button>
                <div class="flex items-center gap-3">
                    <button type="button" 
                            onclick="closeEditTestimonialsModal()" 
                            class="px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-semibold transition-colors">
                        Cancel
                    </button>
                    <button type="button" 
                            id="saveTestimonialsBtn"
                            onclick="saveTestimonialsBlock()" 
                            class="px-6 py-2.5 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-600 hover:to-amber-700 text-white rounded-lg font-semibold transition-all flex items-center gap-2 shadow-lg">
                        <svg id="saveTestimonialsIconCheck" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <svg id="saveTestimonialsIconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="saveTestimonialsButtonText">Save Changes</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
