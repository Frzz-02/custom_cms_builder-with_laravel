<!-- Edit Complete Counts Modal -->
<div id="editCompleteCountsModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] flex flex-col overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <h2 class="text-lg font-bold text-white">Edit Shortcode - Completecount</h2>
            <button type="button" onclick="closeEditCompleteCountsModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body (Scrollable) -->
        <div class="p-6 overflow-y-auto flex-1">
            <!-- Hidden ID field -->
            <input type="hidden" id="completeCountsBlockId" value="">
            
            <!-- Title Input -->
            <div class="mb-4">
                <label for="completeCountsTitle" class="block text-sm font-semibold text-slate-700 mb-2">
                    Title
                </label>
                <input type="text" 
                       id="completeCountsTitle" 
                       placeholder="e.g., Our Achievements"
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>

            <!-- Subtitle Input -->
            <div class="mb-4">
                <label for="completeCountsSubtitle" class="block text-sm font-semibold text-slate-700 mb-2">
                    Subtitle
                </label>
                <input type="text" 
                       id="completeCountsSubtitle" 
                       placeholder="e.g., Numbers that speak for themselves"
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>

            <!-- Content Input -->
            <div class="mb-5">
                <label for="completeCountsContent" class="block text-sm font-semibold text-slate-700 mb-2">
                    Content / Description
                </label>
                <textarea id="completeCountsContent" 
                          rows="3"
                          placeholder="Enter a brief description..."
                          class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"></textarea>
            </div>

            <hr class="my-5 border-slate-200">

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">Select Complete Counts</label>
                
                <!-- Complete Counts List -->
                <div class="space-y-2" id="completeCountsList">
                    @php
                        $completeCounts = \App\Models\SectionCompletecount::where('status', 'active')->orderBy('title')->get();
                    @endphp
                    
                    @forelse($completeCounts as $count)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-blue-400 hover:bg-blue-50 transition-all cursor-pointer group">
                            <input type="checkbox" 
                                   name="completecounts[]" 
                                   value="{{ $count->id }}"
                                   class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer">
                            <span class="flex-1 text-slate-700 font-medium group-hover:text-blue-700">
                                {{ $count->title }}
                            </span>
                            @if($count->icon)
                                <div class="w-8 h-8 bg-slate-100 rounded flex items-center justify-center group-hover:bg-blue-100">
                                    <i class="{{ $count->icon }} text-slate-600 group-hover:text-blue-600"></i>
                                </div>
                            @endif
                        </label>
                    @empty
                        <div class="text-center py-8 text-slate-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p class="font-medium">No complete counts available</p>
                            <p class="text-sm mt-1">Add complete counts from the Complete Counts management page.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Modal Footer (Fixed) -->
        <div class="bg-slate-50 px-6 py-4 flex gap-3 border-t border-slate-200 flex-shrink-0">
            <button type="button" id="saveCompleteCountsBtn" onclick="saveCompleteCountsBlock()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                <svg id="saveCompleteCountsIconCheck" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg id="saveCompleteCountsIconLoading" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="saveCompleteCountsButtonText">Save</span>
            </button>
            <button type="button" id="deleteCompleteCountsBtn" onclick="deleteCompleteCountsBlock()" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors flex items-center gap-2">
                <svg id="deleteCompleteCountsIconTrash" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <svg id="deleteCompleteCountsIconLoading" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="deleteCompleteCountsButtonText">Delete</span>
            </button>
        </div>
    </div>
</div>
