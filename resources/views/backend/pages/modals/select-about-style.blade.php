<!-- Select About Style Modal -->
<div id="selectAboutStyleModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-5 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Choose About Us Style</h2>
                        <p class="text-sm text-blue-100">Select a layout style for about us section</p>
                    </div>
                </div>
                <button type="button" onclick="closeSelectAboutStyleModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Style 1 -->
                    <button type="button" onclick="selectAboutStyle('1')" 
                            class="group relative bg-white border-2 border-blue-200 rounded-xl hover:border-blue-500 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="aspect-video bg-gradient-to-br from-blue-50 to-cyan-50 flex items-center justify-center border-b-2 border-blue-200">
                            <div class="text-center p-4">
                                <div class="w-16 h-16 mx-auto mb-3 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3z"/>
                                    </svg>
                                </div>
                                <div class="text-xs text-blue-600 font-medium">3 Images Grid</div>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <div class="font-semibold text-gray-900 mb-1">Style 1</div>
                            <div class="text-xs text-gray-500">Grid layout with benefits</div>
                        </div>
                    </button>

                    <!-- Style 2 -->
                    <button type="button" onclick="selectAboutStyle('2')" 
                            class="group relative bg-white border-2 border-blue-200 rounded-xl hover:border-blue-500 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="aspect-video bg-gradient-to-br from-purple-50 to-pink-50 flex items-center justify-center border-b-2 border-purple-200">
                            <div class="text-center p-4">
                                <div class="w-16 h-16 mx-auto mb-3 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="text-xs text-purple-600 font-medium">Coming Soon</div>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <div class="font-semibold text-gray-900 mb-1">Style 2</div>
                            <div class="text-xs text-gray-500">Alternative layout</div>
                        </div>
                    </button>

                    <!-- Style 3 -->
                    <button type="button" onclick="selectAboutStyle('3')" 
                            class="group relative bg-white border-2 border-blue-200 rounded-xl hover:border-blue-500 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="aspect-video bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center border-b-2 border-green-200">
                            <div class="text-center p-4">
                                <div class="w-16 h-16 mx-auto mb-3 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div class="text-xs text-green-600 font-medium">Coming Soon</div>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <div class="font-semibold text-gray-900 mb-1">Style 3</div>
                            <div class="text-xs text-gray-500">Modern layout</div>
                        </div>
                    </button>
                </div>

                <!-- Cancel Button -->
                <div class="mt-8 flex justify-center">
                    <button type="button" onclick="closeSelectAboutStyleModal()" 
                            class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
