<!-- Select Testimonials Style Modal -->
<div id="selectTestimonialsStyleModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-yellow-500 to-amber-600 px-6 py-5">
            <h2 class="text-2xl font-bold text-white">Select Testimonials Style</h2>
            <p class="text-yellow-50 text-sm mt-1">Choose a testimonials layout style for your page</p>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Style 1 -->
                <div class="group cursor-pointer border-2 border-slate-200 rounded-xl hover:border-yellow-500 hover:shadow-xl transition-all duration-300 overflow-hidden" onclick="selectTestimonialsStyle('1')">
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 p-8 h-48 flex items-center justify-center border-b border-slate-200">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-yellow-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div class="text-sm font-semibold text-slate-700">Classic Grid</div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <h3 class="font-bold text-slate-800 text-center">Style 1</h3>
                        <p class="text-xs text-slate-500 text-center mt-1">Grid layout with cards</p>
                    </div>
                </div>

                <!-- Style 2 -->
                <div class="group cursor-pointer border-2 border-slate-200 rounded-xl hover:border-yellow-500 hover:shadow-xl transition-all duration-300 overflow-hidden" onclick="selectTestimonialsStyle('2')">
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 p-8 h-48 flex items-center justify-center border-b border-slate-200">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-amber-500 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div class="text-sm font-semibold text-slate-700">Slider View</div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <h3 class="font-bold text-slate-800 text-center">Style 2</h3>
                        <p class="text-xs text-slate-500 text-center mt-1">Carousel slider</p>
                    </div>
                </div>

                <!-- Style 3 -->
                <div class="group cursor-pointer border-2 border-slate-200 rounded-xl hover:border-yellow-500 hover:shadow-xl transition-all duration-300 overflow-hidden" onclick="selectTestimonialsStyle('3')">
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 p-8 h-48 flex items-center justify-center border-b border-slate-200">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-orange-500 rounded-xl mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div class="text-sm font-semibold text-slate-700">Masonry Layout</div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <h3 class="font-bold text-slate-800 text-center">Style 3</h3>
                        <p class="text-xs text-slate-500 text-center mt-1">Staggered grid</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="bg-slate-50 px-6 py-4 flex justify-end">
            <button type="button" onclick="closeSelectTestimonialsStyleModal()" class="px-6 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-medium transition-colors">
                Cancel
            </button>
        </div>
    </div>
</div>
