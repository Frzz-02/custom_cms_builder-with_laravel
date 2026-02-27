<!-- Edit Text Editor Modal -->
<div id="editTextEditorModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] flex flex-col overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <h2 class="text-lg font-bold text-white">Edit Shortcode - Text Editor</h2>
            <button type="button" onclick="closeEditTextEditorModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Modal Body (Scrollable) -->
        <div class="p-6 overflow-y-auto flex-1">
            <!-- Hidden ID field -->
            <input type="hidden" id="textEditorBlockId" value="">
            
            <!-- Content Label -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-3">Content</label>
                
                <!-- Trix Editor -->
                <input id="textEditorContent" type="hidden" name="content">
                <trix-editor input="textEditorContent" class="trix-content rounded-lg" style="min-height: 400px; max-height: 500px; overflow-y: auto;"></trix-editor>
            </div>
        </div>
        
        <!-- Action Buttons (Fixed Bottom) -->
        <div class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex-shrink-0">
            <div class="flex gap-3">
                <button type="button" id="saveTextEditorBtn" onclick="saveTextEditorBlock()" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg id="saveTextEditorIconCheck" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    <svg id="saveTextEditorIconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="saveTextEditorButtonText">Save</span>
                </button>
                <button type="button" id="deleteTextEditorBtn" onclick="deleteTextEditorBlock()" class="flex-1 bg-red-500 hover:bg-red-600 text-white font-semibold py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg id="deleteTextEditorIconTrash" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg id="deleteTextEditorIconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="deleteTextEditorButtonText">Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Trix Editor Styles -->
<style>
    /* Fix Trix Editor Styling */
    trix-editor {
        border: 1px solid #cbd5e1;
        padding: 1rem;
        background: white;
    }
    
    trix-editor:focus {
        outline: 2px solid #6366f1;
        outline-offset: -2px;
        border-color: #6366f1;
    }
    
    /* Remove the gray line (attachment toolbar) */
    trix-editor .attachment {
        border: none !important;
    }
    
    trix-editor .attachment__toolbar {
        display: none !important;
    }
    
    /* Better image handling */
    trix-editor img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 1rem 0;
    }
    
    /* Scrollable content */
    trix-editor {
        overflow-y: auto !important;
    }
    
    trix-editor::-webkit-scrollbar {
        width: 8px;
    }
    
    trix-editor::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    
    trix-editor::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    trix-editor::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
