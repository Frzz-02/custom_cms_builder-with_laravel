<!-- Edit About Us Modal (Style 1) - REVISED VERSION -->
<div id="editAboutModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-5 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Configure About Us Section</h2>
                        <p class="text-sm text-blue-100">Style 1 - Grid Layout</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditAboutModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Modal Body - Scrollable -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                <!-- Section Information -->
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-6 border border-blue-200">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Section Information
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Label</label>
                            <input type="text" id="aboutSectionLabel" 
                                   class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="e.g., KEUNGGULAN KAMI">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Title <span class="text-red-500">*</span></label>
                            <input type="text" id="aboutSectionTitle" required
                                   class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="About Us Section Title">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Section Description</label>
                            <textarea id="aboutSectionDescription" rows="3"
                                      class="w-full px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Brief description about your company..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-200">
                    <h3 class="text-lg font-semibold text-indigo-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Images (3 Images Grid)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Image 1 -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Image 1 <span class="text-red-500">*</span></label>
                            
                            <!-- Radio Options -->
                            <div class="flex gap-4 mb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="aboutImage1Type" value="upload" checked onchange="toggleAboutImageInput(1, 'upload')" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">Upload</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="aboutImage1Type" value="url" onchange="toggleAboutImageInput(1, 'url')" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">URL</span>
                                </label>
                            </div>
                            
                            <!-- Upload Section -->
                            <div id="aboutImage1UploadSection">
                                <input type="file" id="aboutImage1" accept="image/*" 
                                       onchange="handleAboutImageUpload(1, this)"
                                       class="hidden">
                                <button type="button" onclick="document.getElementById('aboutImage1').click()"
                                        class="w-full px-4 py-3 border-2 border-dashed border-indigo-300 rounded-lg hover:border-indigo-500 transition-colors flex items-center justify-center gap-2 text-indigo-600 hover:bg-indigo-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Upload Image
                                </button>
                            </div>
                            
                            <!-- URL Section -->
                            <div id="aboutImage1UrlSection" class="hidden">
                                <input type="url" id="aboutImage1Url" 
                                       onchange="handleAboutImageUrl(1, this)"
                                       class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="https://example.com/image.jpg">
                            </div>
                            
                            <div id="aboutImage1Preview" class="hidden">
                                <img src="" alt="Preview" class="w-full h-40 object-cover rounded-lg border border-indigo-200">
                            </div>
                            <input type="text" id="aboutImage1Alt" 
                                   class="w-full px-3 py-2 text-sm border border-indigo-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="Image alt text (optional)">
                        </div>

                        <!-- Image 2 -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Image 2 <span class="text-red-500">*</span></label>
                            
                            <!-- Radio Options -->
                            <div class="flex gap-4 mb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="aboutImage2Type" value="upload" checked onchange="toggleAboutImageInput(2, 'upload')" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">Upload</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="aboutImage2Type" value="url" onchange="toggleAboutImageInput(2, 'url')" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">URL</span>
                                </label>
                            </div>
                            
                            <!-- Upload Section -->
                            <div id="aboutImage2UploadSection">
                                <input type="file" id="aboutImage2" accept="image/*" 
                                       onchange="handleAboutImageUpload(2, this)"
                                       class="hidden">
                                <button type="button" onclick="document.getElementById('aboutImage2').click()"
                                        class="w-full px-4 py-3 border-2 border-dashed border-indigo-300 rounded-lg hover:border-indigo-500 transition-colors flex items-center justify-center gap-2 text-indigo-600 hover:bg-indigo-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Upload Image
                                </button>
                            </div>
                            
                            <!-- URL Section -->
                            <div id="aboutImage2UrlSection" class="hidden">
                                <input type="url" id="aboutImage2Url" 
                                       onchange="handleAboutImageUrl(2, this)"
                                       class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="https://example.com/image.jpg">
                            </div>
                            
                            <div id="aboutImage2Preview" class="hidden">
                                <img src="" alt="Preview" class="w-full h-40 object-cover rounded-lg border border-indigo-200">
                            </div>
                            <input type="text" id="aboutImage2Alt" 
                                   class="w-full px-3 py-2 text-sm border border-indigo-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="Image alt text (optional)">
                        </div>

                        <!-- Image 3 -->
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700">Image 3 <span class="text-red-500">*</span></label>
                            
                            <!-- Radio Options -->
                            <div class="flex gap-4 mb-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="aboutImage3Type" value="upload" checked onchange="toggleAboutImageInput(3, 'upload')" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">Upload</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="aboutImage3Type" value="url" onchange="toggleAboutImageInput(3, 'url')" class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-700">URL</span>
                                </label>
                            </div>
                            
                            <!-- Upload Section -->
                            <div id="aboutImage3UploadSection">
                                <input type="file" id="aboutImage3" accept="image/*" 
                                       onchange="handleAboutImageUpload(3, this)"
                                       class="hidden">
                                <button type="button" onclick="document.getElementById('aboutImage3').click()"
                                        class="w-full px-4 py-3 border-2 border-dashed border-indigo-300 rounded-lg hover:border-indigo-500 transition-colors flex items-center justify-center gap-2 text-indigo-600 hover:bg-indigo-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Upload Image
                                </button>
                            </div>
                            
                            <!-- URL Section -->
                            <div id="aboutImage3UrlSection" class="hidden">
                                <input type="url" id="aboutImage3Url" 
                                       onchange="handleAboutImageUrl(3, this)"
                                       class="w-full px-4 py-2 border border-indigo-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                       placeholder="https://example.com/image.jpg">
                            </div>
                            
                            <div id="aboutImage3Preview" class="hidden">
                                <img src="" alt="Preview" class="w-full h-40 object-cover rounded-lg border border-indigo-200">
                            </div>
                            <input type="text" id="aboutImage3Alt" 
                                   class="w-full px-3 py-2 text-sm border border-indigo-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="Image alt text (optional)">
                        </div>
                    </div>
                </div>

                <!-- Benefits Section -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                    <h3 class="text-lg font-semibold text-green-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Benefits
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Benefits Title</label>
                            <input type="text" id="aboutBenefitTitle" 
                                   class="w-full px-4 py-2 border border-green-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                   placeholder="e.g., Keuntungan memilih sparepart kami:">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Benefit 1 -->
                            <div class="p-4 bg-white rounded-lg border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-medium text-gray-700">Benefit 1</label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="aboutBenefit1Enabled" checked class="rounded text-green-600 focus:ring-green-500">
                                        <span class="text-xs text-gray-600">Active</span>
                                    </label>
                                </div>
                                <input type="text" id="aboutBenefit1Text" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg mb-2"
                                       placeholder="Benefit text">
                                <input type="text" id="aboutBenefit1Icon" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg"
                                       placeholder="Icon name (e.g., check, star, heart)">
                            </div>

                            <!-- Benefit 2 -->
                            <div class="p-4 bg-white rounded-lg border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-medium text-gray-700">Benefit 2</label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="aboutBenefit2Enabled" checked class="rounded text-green-600 focus:ring-green-500">
                                        <span class="text-xs text-gray-600">Active</span>
                                    </label>
                                </div>
                                <input type="text" id="aboutBenefit2Text" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg mb-2"
                                       placeholder="Benefit text">
                                <input type="text" id="aboutBenefit2Icon" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg"
                                       placeholder="Icon name (e.g., check, star, heart)">
                            </div>

                            <!-- Benefit 3 -->
                            <div class="p-4 bg-white rounded-lg border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-medium text-gray-700">Benefit 3</label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="aboutBenefit3Enabled" checked class="rounded text-green-600 focus:ring-green-500">
                                        <span class="text-xs text-gray-600">Active</span>
                                    </label>
                                </div>
                                <input type="text" id="aboutBenefit3Text" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg mb-2"
                                       placeholder="Benefit text">
                                <input type="text" id="aboutBenefit3Icon" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg"
                                       placeholder="Icon name (e.g., check, star, heart)">
                            </div>

                            <!-- Benefit 4 -->
                            <div class="p-4 bg-white rounded-lg border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-medium text-gray-700">Benefit 4</label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="aboutBenefit4Enabled" checked class="rounded text-green-600 focus:ring-green-500">
                                        <span class="text-xs text-gray-600">Active</span>
                                    </label>
                                </div>
                                <input type="text" id="aboutBenefit4Text" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg mb-2"
                                       placeholder="Benefit text">
                                <input type="text" id="aboutBenefit4Icon" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg"
                                       placeholder="Icon name (e.g., check, star, heart)">
                            </div>

                            <!-- Benefit 5 -->
                            <div class="p-4 bg-white rounded-lg border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-medium text-gray-700">Benefit 5</label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="aboutBenefit5Enabled" checked class="rounded text-green-600 focus:ring-green-500">
                                        <span class="text-xs text-gray-600">Active</span>
                                    </label>
                                </div>
                                <input type="text" id="aboutBenefit5Text" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg mb-2"
                                       placeholder="Benefit text">
                                <input type="text" id="aboutBenefit5Icon" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg"
                                       placeholder="Icon name (e.g., check, star, heart)">
                            </div>

                            <!-- Benefit 6 -->
                            <div class="p-4 bg-white rounded-lg border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-sm font-medium text-gray-700">Benefit 6</label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="aboutBenefit6Enabled" checked class="rounded text-green-600 focus:ring-green-500">
                                        <span class="text-xs text-gray-600">Active</span>
                                    </label>
                                </div>
                                <input type="text" id="aboutBenefit6Text" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg mb-2"
                                       placeholder="Benefit text">
                                <input type="text" id="aboutBenefit6Icon" 
                                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg"
                                       placeholder="Icon name (e.g., check, star, heart)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex-shrink-0 bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between gap-3">
                <button type="button" id="deleteAboutBtn" onclick="deleteAboutBlock()" 
                        class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg id="deleteAboutIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <svg id="deleteAboutLoading" class="animate-spin w-4 h-4 hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="deleteAboutText">Delete Block</span>
                </button>
                <div class="flex gap-3">
                    <button type="button" onclick="closeEditAboutModal()" 
                            class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="button" id="saveAboutBtn" onclick="saveAboutBlock()" 
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white rounded-lg font-medium transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg id="saveAboutIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <svg id="saveAboutLoading" class="animate-spin w-4 h-4 hidden" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="saveAboutText">Save Changes</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
