<!-- Edit Coming Soon Modal -->
<div id="editComingSoonModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-violet-600 to-purple-600 px-6 py-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Configure Coming Soon</h2>
                        <p class="text-sm text-violet-100">Set image and content for coming soon block</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditComingSoonModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <div id="comingSoonLoadingState" class="hidden py-12 text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-violet-200 border-t-violet-600"></div>
                    <p class="mt-4 text-slate-600 font-medium">Loading...</p>
                </div>

                <div id="comingSoonFormContent" class="space-y-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-slate-700">Image</label>
                        <div data-media-picker
                             data-field-name="comingSoonImage"
                             data-field-id="comingSoonImage"
                             data-label="Choose image"
                             data-placeholder="Select image from media library"
                             data-initial-value="">
                            @include('backend.components.media-picker-input')
                        </div>
                        <p class="text-xs text-slate-500">Select an image from existing media library</p>
                    </div>

                    <div class="space-y-2">
                        <label for="comingSoonTitle" class="block text-sm font-semibold text-slate-700">Title</label>
                        <input type="text"
                               id="comingSoonTitle"
                               placeholder="e.g., Something awesome is coming soon"
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-violet-500 focus:ring-2 focus:ring-violet-200 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label for="comingSoonSubtitle" class="block text-sm font-semibold text-slate-700">Subtitle</label>
                        <input type="text"
                               id="comingSoonSubtitle"
                               placeholder="e.g., We are preparing a better experience for you"
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-violet-500 focus:ring-2 focus:ring-violet-200 outline-none transition-all">
                    </div>

                    <div class="space-y-2">
                        <label for="comingSoonPlaceholder" class="block text-sm font-semibold text-slate-700">Placeholder</label>
                        <input type="text"
                               id="comingSoonPlaceholder"
                               placeholder="e.g., Enter your email"
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-violet-500 focus:ring-2 focus:ring-violet-200 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center rounded-b-2xl">
                <button type="button"
                        id="deleteComingSoonBtn"
                        onclick="deleteComingSoonBlock()"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2 shadow-sm hover:shadow-md">
                    <svg id="deleteComingSoonIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg id="deleteComingSoonLoading" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="deleteComingSoonText">Delete</span>
                </button>
                <div class="flex gap-3">
                    <button type="button"
                            onclick="closeEditComingSoonModal()"
                            class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="button"
                            onclick="saveComingSoonBlock()"
                            class="px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2 shadow-sm hover:shadow-md">
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
