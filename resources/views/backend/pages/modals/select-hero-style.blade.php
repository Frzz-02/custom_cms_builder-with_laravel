{{-- Select Hero Banner Style Modal --}}
<div id="selectHeroStyleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between bg-gradient-to-r from-indigo-600 to-purple-600 rounded-t-xl">
            <h3 class="text-xl font-bold text-white">Select Hero Banner Style</h3>
            <button type="button" onclick="closeSelectHeroStyleModal()" 
                class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <p class="text-gray-600 mb-4">Choose a style for your hero banner:</p>
            
            <div class="space-y-3">
                <!-- Style 1 -->
                <button type="button" onclick="selectHeroStyle(1)" 
                    class="w-full p-4 border-2 border-indigo-200 rounded-lg hover:border-indigo-500 hover:bg-indigo-50 transition-all text-left group">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl group-hover:scale-110 transition-transform">
                            1
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 group-hover:text-indigo-600">Style 1</h4>
                            <p class="text-sm text-gray-500">Classic hero banner layout</p>
                        </div>
                    </div>
                </button>

                <!-- Style 2 -->
                <button type="button" onclick="selectHeroStyle(2)" 
                    class="w-full p-4 border-2 border-purple-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all text-left group">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-xl group-hover:scale-110 transition-transform">
                            2
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 group-hover:text-purple-600">Style 2</h4>
                            <p class="text-sm text-gray-500">Modern hero banner design</p>
                        </div>
                    </div>
                </button>

                <!-- Style 3 -->
                <button type="button" onclick="selectHeroStyle(3)" 
                    class="w-full p-4 border-2 border-pink-200 rounded-lg hover:border-pink-500 hover:bg-pink-50 transition-all text-left group">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center text-white font-bold text-xl group-hover:scale-110 transition-transform">
                            3
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 group-hover:text-pink-600">Style 3</h4>
                            <p class="text-sm text-gray-500">Creative hero banner variant</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 rounded-b-xl">
            <button type="button" onclick="closeSelectHeroStyleModal()" 
                class="w-full px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                Cancel
            </button>
        </div>
    </div>
</div>
