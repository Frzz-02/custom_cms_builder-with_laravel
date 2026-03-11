<!-- Select Product Category Style Modal -->
<div id="selectProductCategoryStyleModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-5 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Select Product Category Style</h2>
                        <p class="text-sm text-green-100">Choose a style for your product category section</p>
                    </div>
                </div>
                <button type="button" onclick="closeSelectProductCategoryStyleModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Style 1: Grid Layout -->
                    <div class="group cursor-pointer" onclick="selectProductCategoryStyle('1')">
                        <div class="border-2 border-slate-200 rounded-xl overflow-hidden hover:border-green-500 hover:shadow-xl transition-all duration-300">
                            <!-- Preview -->
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 aspect-video flex items-center justify-center relative">
                                <div class="absolute top-3 right-3">
                                    <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold">Style 1</span>
                                </div>
                                
                                <!-- Grid Preview -->
                                <div class="grid grid-cols-3 gap-3 w-full">
                                    <div class="bg-white rounded-lg p-3 shadow-md">
                                        <div class="w-full h-12 bg-gradient-to-br from-green-200 to-emerald-200 rounded mb-2"></div>
                                        <div class="h-2 bg-slate-200 rounded mb-1"></div>
                                        <div class="h-2 bg-slate-200 rounded w-2/3"></div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 shadow-md">
                                        <div class="w-full h-12 bg-gradient-to-br from-green-200 to-emerald-200 rounded mb-2"></div>
                                        <div class="h-2 bg-slate-200 rounded mb-1"></div>
                                        <div class="h-2 bg-slate-200 rounded w-2/3"></div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 shadow-md">
                                        <div class="w-full h-12 bg-gradient-to-br from-green-200 to-emerald-200 rounded mb-2"></div>
                                        <div class="h-2 bg-slate-200 rounded mb-1"></div>
                                        <div class="h-2 bg-slate-200 rounded w-2/3"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="p-4 bg-white border-t border-slate-200">
                                <h3 class="font-bold text-slate-800 mb-1 group-hover:text-green-600 transition-colors">Grid Layout</h3>
                                <p class="text-sm text-slate-600">Display product categories in a 3-column grid with images and titles</p>
                            </div>
                        </div>
                    </div>

                    <!-- Style 2: List Layout -->
                    <div class="group cursor-pointer" onclick="selectProductCategoryStyle('2')">
                        <div class="border-2 border-slate-200 rounded-xl overflow-hidden hover:border-emerald-500 hover:shadow-xl transition-all duration-300">
                            <!-- Preview -->
                            <div class="bg-gradient-to-br from-emerald-50 to-green-50 p-8 aspect-video flex items-center justify-center relative">
                                <div class="absolute top-3 right-3">
                                    <span class="bg-emerald-500 text-white text-xs px-3 py-1 rounded-full font-semibold">Style 2</span>
                                </div>
                                
                                <!-- List Preview -->
                                <div class="space-y-3 w-full">
                                    <div class="bg-white rounded-lg p-3 shadow-md flex items-center gap-3">
                                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-200 to-green-200 rounded flex-shrink-0"></div>
                                        <div class="flex-1">
                                            <div class="h-2 bg-slate-200 rounded mb-1.5 w-3/4"></div>
                                            <div class="h-2 bg-slate-200 rounded w-1/2"></div>
                                        </div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 shadow-md flex items-center gap-3">
                                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-200 to-green-200 rounded flex-shrink-0"></div>
                                        <div class="flex-1">
                                            <div class="h-2 bg-slate-200 rounded mb-1.5 w-3/4"></div>
                                            <div class="h-2 bg-slate-200 rounded w-1/2"></div>
                                        </div>
                                    </div>
                                    <div class="bg-white rounded-lg p-3 shadow-md flex items-center gap-3">
                                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-200 to-green-200 rounded flex-shrink-0"></div>
                                        <div class="flex-1">
                                            <div class="h-2 bg-slate-200 rounded mb-1.5 w-3/4"></div>
                                            <div class="h-2 bg-slate-200 rounded w-1/2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="p-4 bg-white border-t border-slate-200">
                                <h3 class="font-bold text-slate-800 mb-1 group-hover:text-emerald-600 transition-colors">List Layout</h3>
                                <p class="text-sm text-slate-600">Display product categories in a vertical list with larger images</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
