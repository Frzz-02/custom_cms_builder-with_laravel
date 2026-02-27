<!-- Edit Brands Modal -->
<div id="editBrandsModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[90vh] flex flex-col overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <h2 class="text-lg font-bold text-white">Edit Shortcode - Brand</h2>
            <button type="button" onclick="closeEditBrandsModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body (Scrollable) -->
        <div class="p-6 overflow-y-auto flex-1">
            <!-- Hidden ID field -->
            <input type="hidden" id="brandsBlockId" value="">
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">Select Brands</label>
                
                <!-- Brands List -->
                <div class="space-y-2" id="brandsList">
                    @php
                        $brands = \App\Models\SectionBrand::where('status', 'active')->orderBy('name')->get();
                    @endphp
                    
                    @forelse($brands as $brand)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 hover:border-indigo-400 hover:bg-indigo-50 transition-all cursor-pointer group">
                            <input type="checkbox" 
                                   name="brands[]" 
                                   value="{{ $brand->id }}"
                                   class="w-5 h-5 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer">
                            <span class="flex-1 text-slate-700 font-medium group-hover:text-indigo-700">
                                {{ $brand->name }}
                            </span>
                            @if($brand->logo)
                                <img src="{{ $brand->logo }}" 
                                     alt="{{ $brand->name }}" 
                                     class="w-8 h-8 object-contain rounded">
                            @else
                                <div class="w-8 h-8 bg-slate-100 rounded flex items-center justify-center group-hover:bg-indigo-100">
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                            @endif
                        </label>
                    @empty
                        <div class="text-center py-8 text-slate-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="font-medium">No brands available</p>
                            <p class="text-sm mt-1">Please add brands first</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Action Buttons (Fixed Bottom) -->
        <div class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex-shrink-0">
            <div class="flex gap-3">
                <button type="button" id="saveBrandsBtn" onclick="saveBrandsBlock()" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg id="saveBrandsIconCheck" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    <svg id="saveBrandsIconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="saveBrandsButtonText">Save</span>
                </button>
                <button type="button" id="deleteBrandsBtn" onclick="deleteBrandsBlock()" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg id="deleteBrandsIconTrash" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg id="deleteBrandsIconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="deleteBrandsButtonText">Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>
