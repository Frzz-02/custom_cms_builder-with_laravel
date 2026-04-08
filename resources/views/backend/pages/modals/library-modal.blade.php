<!-- Block Library Modal -->
<div id="blockLibraryModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-6xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">UI Blocks</h2>
                        <p class="text-sm text-indigo-100">Choose a block to add to your page</p>
                    </div>
                </div>
                <button type="button" onclick="closeBlockLibrary()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <!-- Title Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Title</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a heading title</p>
                            <button type="button" onclick="addBlock('title')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Simple Text Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Simple text</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a simple text block</p>
                            <button type="button" onclick="addBlock('simple-text')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Text Editor Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Text editor</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a rich text editor</p>
                            <button type="button" onclick="addBlock('text-editor')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Complete Counts Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Complete Counts</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a complete count</p>
                            <button type="button" onclick="addBlock('complete-counts')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Hero Banner Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Hero banner</h3>
                            <p class="text-sm text-slate-500 mb-4">Add a hero banner</p>
                            <button type="button" onclick="addBlock('hero-banner')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- About Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-500 to-cyan-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">About us</h3>
                            <p class="text-sm text-slate-500 mb-4">Add an about section</p>
                            <button type="button" onclick="addBlock('about')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Brands Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-amber-500 to-orange-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Brands</h3>
                            <p class="text-sm text-slate-500 mb-4">Display partner brands</p>
                            <button type="button" onclick="addBlock('brands')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Testimonials Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-yellow-500 to-amber-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Testimonials</h3>
                            <p class="text-sm text-slate-500 mb-4">Display client reviews</p>
                            <button type="button" onclick="addBlock('testimonials')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Recent Product Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Recent Product</h3>
                            <p class="text-sm text-slate-500 mb-4">Display recent products</p>
                            <button type="button" onclick="addBlock('recent-product')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Product Category Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-green-500 to-teal-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Product Category</h3>
                            <p class="text-sm text-slate-500 mb-4">Display product categories with pagination</p>
                            <button type="button" onclick="addBlock('product-category')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Featured Services Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-purple-500 to-pink-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Featured Services</h3>
                            <p class="text-sm text-slate-500 mb-4">Display featured services</p>
                            <button type="button" onclick="addBlock('featured-services')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Newsletter Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Newsletter</h3>
                            <p class="text-sm text-slate-500 mb-4">Add newsletter subscription</p>
                            <button type="button" onclick="addBlock('newsletter')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Latest News & Blog Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-rose-500 to-pink-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Latest News & Blog</h3>
                            <p class="text-sm text-slate-500 mb-4">Display recent blog posts</p>
                            <button type="button" onclick="addBlock('latestnews')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Coming Soon Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-violet-500 to-purple-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Coming Soon</h3>
                            <p class="text-sm text-slate-500 mb-4">Add coming soon teaser section</p>
                            <button type="button" onclick="addBlock('comingsoon')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>

                    <!-- Contact Block -->
                    <div class="group bg-white border-2 border-slate-200 rounded-xl hover:border-indigo-400 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="bg-gradient-to-br from-teal-500 to-cyan-500 p-6 h-32 flex items-center justify-center border-b border-slate-200">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800 text-base mb-1">Contact</h3>
                            <p class="text-sm text-slate-500 mb-4">Add contact information</p>
                            <button type="button" onclick="addBlock('contact')" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Use
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
