<!-- Edit Latest News & Blog Modal -->
<div id="editLatestNewsModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-rose-600 to-pink-600 px-6 py-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Configure Latest News & Blog</h2>
                        <p class="text-sm text-rose-100">Set title and blog post limit</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditLatestNewsModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- Loading State -->
                <div id="latestNewsLoadingState" class="hidden py-12 text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-rose-200 border-t-rose-600"></div>
                    <p class="mt-4 text-slate-600 font-medium">Loading...</p>
                </div>

                <!-- Form Content -->
                <div id="latestNewsFormContent">
                    <!-- Title Input -->
                    <div class="space-y-2">
                        <label for="latestNewsTitle" class="block text-sm font-semibold text-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                Section Title
                            </span>
                        </label>
                        <input type="text" 
                               id="latestNewsTitle" 
                               placeholder="e.g., Latest News & Blog Posts"
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-rose-500 focus:ring-2 focus:ring-rose-200 outline-none transition-all">
                        <p class="text-xs text-slate-500">This title will appear above the blog posts section</p>
                    </div>

                    <!-- Blog Limit Input -->
                    <div class="space-y-2">
                        <label for="latestNewsBlogLimit" class="block text-sm font-semibold text-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                Number of Posts to Display
                            </span>
                        </label>
                        <input type="number" 
                               id="latestNewsBlogLimit" 
                               min="4"
                               placeholder="Minimum 4 posts"
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-rose-500 focus:ring-2 focus:ring-rose-200 outline-none transition-all">
                        <p class="text-xs text-slate-500">Enter 4 or more to display blog posts (minimum: 4)</p>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-rose-50 border border-rose-200 rounded-lg p-4 flex gap-3">
                        <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-rose-700">
                            <p class="font-semibold mb-1">Display Settings</p>
                            <p>The latest blog posts will be automatically fetched and displayed based on your limit. Posts are shown in reverse chronological order.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center rounded-b-2xl">
                <button type="button"
                        id="deleteLatestNewsBtn"
                        onclick="deleteLatestNewsBlock()"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2 shadow-sm hover:shadow-md">
                    <svg id="deleteLatestNewsIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg id="deleteLatestNewsLoading" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="deleteLatestNewsText">Delete</span>
                </button>
                <div class="flex gap-3">
                    <button type="button"
                            onclick="closeEditLatestNewsModal()"
                            class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="button"
                            onclick="saveLatestNewsBlock()"
                            class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
