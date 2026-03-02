<!-- Select Latest News Style Modal -->
<div id="selectLatestNewsStyleModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-rose-600 to-pink-600 px-6 py-5 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Choose Latest News Style</h2>
                        <p class="text-sm text-rose-100">Select a layout style for your news section</p>
                    </div>
                </div>
                <button type="button" onclick="closeSelectLatestNewsStyleModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-8 overflow-y-auto max-h-[calc(90vh-80px)]">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Style 1 - Grid Layout -->
                    <div class="group cursor-pointer" onclick="selectLatestNewsStyle('1')">
                        <div class="relative bg-white border-2 border-slate-300 rounded-xl overflow-hidden hover:border-rose-500 hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-video bg-gradient-to-br from-slate-50 to-slate-100 p-4 flex items-center justify-center">
                                <div class="w-full space-y-2">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="bg-rose-200 rounded h-16"></div>
                                        <div class="bg-rose-200 rounded h-16"></div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div class="bg-rose-200 rounded h-16"></div>
                                        <div class="bg-rose-200 rounded h-16"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 bg-white border-t border-slate-200">
                                <h3 class="font-bold text-slate-800 text-lg mb-1">Style 1</h3>
                                <p class="text-sm text-slate-500">Grid Layout - Modern card design</p>
                            </div>
                            <div class="absolute inset-0 bg-rose-500/0 group-hover:bg-rose-500/10 transition-colors"></div>
                        </div>
                    </div>

                    <!-- Style 2 - List Layout -->
                    <div class="group cursor-pointer" onclick="selectLatestNewsStyle('2')">
                        <div class="relative bg-white border-2 border-slate-300 rounded-xl overflow-hidden hover:border-rose-500 hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-video bg-gradient-to-br from-slate-50 to-slate-100 p-4 flex items-center justify-center">
                                <div class="w-full space-y-2">
                                    <div class="flex gap-2">
                                        <div class="bg-rose-200 rounded w-1/3 h-12"></div>
                                        <div class="bg-rose-200 rounded flex-1 h-12"></div>
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="bg-rose-200 rounded w-1/3 h-12"></div>
                                        <div class="bg-rose-200 rounded flex-1 h-12"></div>
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="bg-rose-200 rounded w-1/3 h-12"></div>
                                        <div class="bg-rose-200 rounded flex-1 h-12"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 bg-white border-t border-slate-200">
                                <h3 class="font-bold text-slate-800 text-lg mb-1">Style 2</h3>
                                <p class="text-sm text-slate-500">List Layout - Horizontal cards</p>
                            </div>
                            <div class="absolute inset-0 bg-rose-500/0 group-hover:bg-rose-500/10 transition-colors"></div>
                        </div>
                    </div>

                    <!-- Style 3 - Masonry Layout -->
                    <div class="group cursor-pointer" onclick="selectLatestNewsStyle('3')">
                        <div class="relative bg-white border-2 border-slate-300 rounded-xl overflow-hidden hover:border-rose-500 hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-video bg-gradient-to-br from-slate-50 to-slate-100 p-4 flex items-center justify-center">
                                <div class="w-full space-y-2">
                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="bg-rose-200 rounded h-20"></div>
                                        <div class="bg-rose-200 rounded h-12"></div>
                                        <div class="bg-rose-200 rounded h-16"></div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div class="bg-rose-200 rounded h-12"></div>
                                        <div class="bg-rose-200 rounded h-20"></div>
                                        <div class="bg-rose-200 rounded h-16"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 bg-white border-t border-slate-200">
                                <h3 class="font-bold text-slate-800 text-lg mb-1">Style 3</h3>
                                <p class="text-sm text-slate-500">Masonry Layout - Dynamic columns</p>
                            </div>
                            <div class="absolute inset-0 bg-rose-500/0 group-hover:bg-rose-500/10 transition-colors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
