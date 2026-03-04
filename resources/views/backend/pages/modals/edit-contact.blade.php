<!-- Edit Contact Modal -->
<div id="editContactModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-teal-600 to-cyan-600 px-6 py-5 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Configure Contact Section</h2>
                        <p class="text-sm text-teal-100">Set up your contact information display</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditContactModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Loading State -->
                <div id="contactLoadingState" class="hidden py-12 text-center">
                    <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-teal-200 border-t-teal-600"></div>
                    <p class="mt-4 text-slate-600 font-medium">Loading contacts...</p>
                </div>

                <!-- Form Content -->
                <div id="contactFormContent" class="space-y-6">
                    <!-- Title Input -->
                    <div class="space-y-2">
                        <label for="contactTitle" class="block text-sm font-semibold text-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                Title
                            </span>
                        </label>
                        <input type="text" 
                               id="contactTitle" 
                               placeholder="e.g., Get In Touch"
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200 outline-none transition-all">
                        <p class="text-xs text-slate-500">Main heading for the contact section</p>
                    </div>

                    <!-- Subtitle Input -->
                    <div class="space-y-2">
                        <label for="contactSubtitle" class="block text-sm font-semibold text-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                                </svg>
                                Subtitle
                            </span>
                        </label>
                        <input type="text" 
                               id="contactSubtitle" 
                               placeholder="e.g., We'd love to hear from you"
                               class="w-full px-4 py-3 border-2 border-slate-300 rounded-lg focus:border-teal-500 focus:ring-2 focus:ring-teal-200 outline-none transition-all">
                        <p class="text-xs text-slate-500">Supporting text below the title</p>
                    </div>

                    <!-- Select Contacts -->
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-slate-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Select Contacts
                            </span>
                        </label>
                        
                        <!-- Contacts List Container -->
                        <div id="contactsListContainer" class="border-2 border-slate-300 rounded-lg p-4 max-h-64 overflow-y-auto bg-slate-50">
                            <!-- Loading message -->
                            <div id="contactsListLoading" class="text-center py-8 text-slate-500">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-2 border-teal-200 border-t-teal-600 mb-2"></div>
                                <p class="text-sm">Loading contacts...</p>
                            </div>
                            
                            <!-- Contacts will be populated here -->
                            <div id="contactsCheckboxList" class="hidden space-y-2"></div>
                            
                            <!-- Empty state -->
                            <div id="contactsEmptyState" class="hidden text-center py-8 text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-sm font-medium">No contacts available</p>
                                <p class="text-xs mt-1">Please add contacts first</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500">Select the contact information to display</p>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-teal-50 border border-teal-200 rounded-lg p-4 flex gap-3">
                        <svg class="w-5 h-5 text-teal-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-teal-700">
                            <p class="font-semibold mb-1">Contact Display</p>
                            <p>Selected contacts will be displayed in the order you choose. Make sure to select at least one contact method.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-between items-center flex-shrink-0">
                <button type="button"
                        onclick="deleteContactBlock()"
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
                <div class="flex gap-3">
                    <button type="button"
                            onclick="closeEditContactModal()"
                            class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="button"
                            onclick="saveContactBlock()"
                            class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2 shadow-sm hover:shadow-md">
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
