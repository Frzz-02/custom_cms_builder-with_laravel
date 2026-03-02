{{-- Edit Hero Banner Modal --}}
<div id="editHeroBannerModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between sticky top-0 bg-white rounded-t-xl z-10">
            <h3 class="text-xl font-bold text-gray-900">Configure Hero Banner</h3>
            <button type="button" onclick="closeEditHeroBannerModal()" 
                class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>


        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto px-6 py-4" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9;">
            <div class="space-y-6">
                @csrf
                <input type="hidden" id="hero_banner_id" name="hero_banner_id">

                <!-- Titles Section -->
                <div class="bg-indigo-50 p-4 rounded-lg">
                    <h4 class="font-bold text-indigo-900 mb-3">Titles</h4>
                    <div class="space-y-3">
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">
                                Title 1
                            </label>
                            <input type="text" id="title" name="title"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter title 1">
                        </div>
                        <div>
                            <label for="title_2" class="block text-sm font-semibold text-gray-700 mb-1">
                                Title 2
                            </label>
                            <input type="text" id="title_2" name="title_2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter title 2">
                        </div>
                        <div>
                            <label for="title_3" class="block text-sm font-semibold text-gray-700 mb-1">
                                Title 3
                            </label>
                            <input type="text" id="title_3" name="title_3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Enter title 3">
                        </div>
                    </div>
                </div>

                <!-- Subtitles Section -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="font-bold text-blue-900 mb-3">Subtitles</h4>
                    <div class="space-y-3">
                        <div>
                            <label for="subtitle_1" class="block text-sm font-semibold text-gray-700 mb-1">
                                Subtitle 1
                            </label>
                            <input type="text" id="subtitle_1" name="subtitle_1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter subtitle 1">
                        </div>
                        <div>
                            <label for="subtitle_2" class="block text-sm font-semibold text-gray-700 mb-1">
                                Subtitle 2
                            </label>
                            <input type="text" id="subtitle_2" name="subtitle_2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter subtitle 2">
                        </div>
                        <div>
                            <label for="subtitle_3" class="block text-sm font-semibold text-gray-700 mb-1">
                                Subtitle 3
                            </label>
                            <input type="text" id="subtitle_3" name="subtitle_3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter subtitle 3">
                        </div>
                    </div>
                </div>

                <!-- Descriptions Section -->
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h4 class="font-bold text-purple-900 mb-3">Descriptions</h4>
                    <div class="space-y-3">
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                                Description 1
                            </label>
                            <textarea id="description" name="description" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                placeholder="Enter description 1"></textarea>
                        </div>
                        <div>
                            <label for="description_2" class="block text-sm font-semibold text-gray-700 mb-1">
                                Description 2
                            </label>
                            <textarea id="description_2" name="description_2" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                placeholder="Enter description 2"></textarea>
                        </div>
                        <div>
                            <label for="description_3" class="block text-sm font-semibold text-gray-700 mb-1">
                                Description 3
                            </label>
                            <textarea id="description_3" name="description_3" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                placeholder="Enter description 3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="font-bold text-green-900 mb-3">Images <span class="text-xs font-normal text-gray-600">(Upload file or enter URL)</span></h4>
                    <div class="space-y-4">
                        <!-- Image 1 -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image 1</label>
                            <div class="flex gap-2">
                                <input type="file" id="image_file" name="image_file" accept="image/*"
                                    onchange="handleImageUpload('image', this)"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <span class="text-gray-500 py-2">or</span>
                                <input type="text" id="image" name="image"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="https://example.com/image1.jpg">
                            </div>
                        </div>
                        <!-- Image 2 -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image 2</label>
                            <div class="flex gap-2">
                                <input type="file" id="image_2_file" name="image_2_file" accept="image/*"
                                    onchange="handleImageUpload('image_2', this)"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <span class="text-gray-500 py-2">or</span>
                                <input type="text" id="image_2" name="image_2"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="https://example.com/image2.jpg">
                            </div>
                        </div>
                        <!-- Image 3 -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image 3</label>
                            <div class="flex gap-2">
                                <input type="file" id="image_3_file" name="image_3_file" accept="image/*"
                                    onchange="handleImageUpload('image_3', this)"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                <span class="text-gray-500 py-2">or</span>
                                <input type="text" id="image_3" name="image_3"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    placeholder="https://example.com/image3.jpg">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Background Images Section -->
                <div class="bg-amber-50 p-4 rounded-lg">
                    <h4 class="font-bold text-amber-900 mb-3">Background Images <span class="text-xs font-normal text-gray-600">(Upload file or enter URL)</span></h4>
                    <div class="space-y-4">
                        <!-- Background 1 -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Background Image 1</label>
                            <div class="flex gap-2">
                                <input type="file" id="image_background_file" name="image_background_file" accept="image/*"
                                    onchange="handleImageUpload('image_background', this)"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                                <span class="text-gray-500 py-2">or</span>
                                <input type="text" id="image_background" name="image_background"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    placeholder="https://example.com/bg1.jpg">
                            </div>
                        </div>
                        <!-- Background 2 -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Background Image 2</label>
                            <div class="flex gap-2">
                                <input type="file" id="image_background_2_file" name="image_background_2_file" accept="image/*"
                                    onchange="handleImageUpload('image_background_2', this)"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                                <span class="text-gray-500 py-2">or</span>
                                <input type="text" id="image_background_2" name="image_background_2"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    placeholder="https://example.com/bg2.jpg">
                            </div>
                        </div>
                        <!-- Background 3 -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Background Image 3</label>
                            <div class="flex gap-2">
                                <input type="file" id="image_background_3_file" name="image_background_3_file" accept="image/*"
                                    onchange="handleImageUpload('image_background_3', this)"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                                <span class="text-gray-500 py-2">or</span>
                                <input type="text" id="image_background_3" name="image_background_3"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                                    placeholder="https://example.com/bg3.jpg">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Section -->
                <div class="bg-rose-50 p-4 rounded-lg">
                    <h4 class="font-bold text-rose-900 mb-3">Action Buttons <span class="text-xs font-normal text-gray-600">(External: https://... or Internal: /produk)</span></h4>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="action_label" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Button 1 Label
                                </label>
                                <input type="text" id="action_label" name="action_label"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                                    placeholder="e.g., Get Started">
                            </div>
                            <div>
                                <label for="action_url" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Button 1 URL
                                </label>
                                <input type="text" id="action_url" name="action_url"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                                    placeholder="https://example.com or /produk">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="action_label_2" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Button 2 Label
                                </label>
                                <input type="text" id="action_label_2" name="action_label_2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                                    placeholder="e.g., Learn More">
                            </div>
                            <div>
                                <label for="action_url_2" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Button 2 URL
                                </label>
                                <input type="text" id="action_url_2" name="action_url_2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                                    placeholder="https://example.com or /about">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="action_label_3" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Button 3 Label
                                </label>
                                <input type="text" id="action_label_3" name="action_label_3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                                    placeholder="e.g., Contact Us">
                            </div>
                            <div>
                                <label for="action_url_3" class="block text-sm font-semibold text-gray-700 mb-1">
                                    Button 3 URL
                                </label>
                                <input type="text" id="action_url_3" name="action_url_3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                                    placeholder="https://example.com or /contact">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <!-- Modal Footer -->
        <div class="bg-slate-50 px-6 py-4 flex gap-3 border-t border-slate-200">
            <button type="button" id="saveHeroBannerBtn" onclick="saveHeroBannerBlock()" 
                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                <svg id="saveIconCheck" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <svg id="saveIconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="saveButtonText">Save</span>
            </button>
            <button type="button" id="deleteHeroBannerBtn" onclick="deleteHeroBannerBlock()" 
                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors flex items-center gap-2">
                <svg id="deleteIconTrash" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <svg id="deleteIconLoading" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="deleteButtonText">Delete</span>
            </button>
        </div>
    </div>
</div>
