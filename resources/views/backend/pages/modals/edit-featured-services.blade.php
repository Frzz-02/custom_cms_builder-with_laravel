<!-- Edit Featured Services Modal -->
<div id="editFeaturedServicesModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-5 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Edit Shortcode - Service</h2>
                        <p class="text-sm text-purple-100">Configure your featured services</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditFeaturedServicesModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                <div class="space-y-6">
                    <!-- Service Style (Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Service Style
                        </label>
                        <input type="text" 
                               id="serviceStyleDisplay" 
                               class="w-full px-4 py-3 bg-slate-100 border border-slate-300 rounded-lg text-slate-700 font-medium cursor-not-allowed"
                               readonly>
                        <input type="hidden" id="serviceStyle" name="service_style">
                    </div>

                    <!-- Select Service -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">
                            Select Service
                        </label>
                        <div id="servicesList" class="space-y-2 max-h-80 overflow-y-auto border border-slate-200 rounded-lg p-4 bg-slate-50">
                            <!-- Services will be loaded here dynamically -->
                            <div class="flex items-center justify-center py-8">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-3 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <p class="text-sm text-slate-500">Loading services...</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Select the services you want to display on this section</p>
                    </div>

                    <!-- Info Box -->
                    <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-purple-800">
                                <p class="font-semibold">Service Selection</p>
                                <p class="text-purple-600 mt-1">Choose one or more services to display. The selected services will be shown in the order they appear.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex items-center justify-between gap-3">
                <button type="button" 
                        id="deleteFeaturedServicesBtn"
                        onclick="deleteFeaturedServicesBlock()"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2">
                    <svg id="deleteFeaturedServicesIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg id="deleteFeaturedServicesLoading" class="w-5 h-5 animate-spin hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span id="deleteFeaturedServicesText">Delete</span>
                </button>
                <div class="flex items-center gap-3">
                    <button type="button" 
                            onclick="closeEditFeaturedServicesModal()"
                            class="px-5 py-2.5 text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors font-semibold">
                        Cancel
                    </button>
                    <button type="button" 
                            id="saveFeaturedServicesBtn"
                            onclick="saveFeaturedServicesBlock()"
                            class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2">
                        <svg id="saveFeaturedServicesIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <svg id="saveFeaturedServicesLoading" class="w-5 h-5 animate-spin hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span id="saveFeaturedServicesText">Save</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
