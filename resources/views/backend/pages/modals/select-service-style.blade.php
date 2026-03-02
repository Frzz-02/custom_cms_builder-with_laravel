<!-- Select Service Style Modal -->
<div id="selectServiceStyleModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
    <div class="min-h-screen px-4 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-5 flex items-center justify-between sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Select Service Style</h2>
                        <p class="text-sm text-purple-100">Choose a style for your featured services</p>
                    </div>
                </div>
                <button type="button" onclick="closeSelectServiceStyleModal()" class="text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Style 1 -->
                    <button type="button" onclick="selectServiceStyle('1')" 
                            class="group border-3 border-slate-200 rounded-xl hover:border-purple-500 hover:shadow-xl transition-all duration-300 overflow-hidden bg-white text-left">
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-8 border-b border-slate-200">
                            <div class="flex items-center justify-center h-48 bg-white rounded-lg shadow-inner">
                                <div class="text-center space-y-4">
                                    <div class="w-20 h-20 bg-purple-100 rounded-full mx-auto flex items-center justify-center">
                                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">Service Name</div>
                                        <div class="text-sm text-slate-500 mt-1">Description</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <h3 class="font-bold text-slate-800 text-lg">Style 1</h3>
                            <p class="text-sm text-slate-500 mt-1">Card with icon, title and description</p>
                        </div>
                    </button>

                    <!-- Style 2 -->
                    <button type="button" onclick="selectServiceStyle('2')" 
                            class="group border-3 border-slate-200 rounded-xl hover:border-purple-500 hover:shadow-xl transition-all duration-300 overflow-hidden bg-white text-left">
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-8 border-b border-slate-200">
                            <div class="flex items-center justify-center h-48 bg-white rounded-lg shadow-inner">
                                <div class="flex items-start gap-4 max-w-xs">
                                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-bold text-slate-800">Service Name</div>
                                        <div class="text-xs text-slate-500 mt-1">Description text here</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <h3 class="font-bold text-slate-800 text-lg">Style 2</h3>
                            <p class="text-sm text-slate-500 mt-1">Horizontal layout with icon on left</p>
                        </div>
                    </button>

                    <!-- Style 3 -->
                    <button type="button" onclick="selectServiceStyle('3')" 
                            class="group border-3 border-slate-200 rounded-xl hover:border-purple-500 hover:shadow-xl transition-all duration-300 overflow-hidden bg-white text-left">
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 border-b border-slate-200">
                            <div class="flex items-center justify-center h-48 bg-white rounded-lg shadow-inner">
                                <div class="text-center space-y-3 max-w-xs">
                                    <div class="w-16 h-16 bg-green-600 rounded-lg mx-auto flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-lg">Service Name</div>
                                        <div class="text-xs text-slate-500 mt-1">Description text here with more details</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <h3 class="font-bold text-slate-800 text-lg">Style 3</h3>
                            <p class="text-sm text-slate-500 mt-1">Minimal design with colored icon</p>
                        </div>
                    </button>

                    <!-- Style 4 -->
                    <button type="button" onclick="selectServiceStyle('4')" 
                            class="group border-3 border-slate-200 rounded-xl hover:border-purple-500 hover:shadow-xl transition-all duration-300 overflow-hidden bg-white text-left">
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 p-8 border-b border-slate-200">
                            <div class="flex items-center justify-center h-48 bg-white rounded-lg shadow-inner">
                                <div class="relative max-w-xs">
                                    <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="border border-slate-200 rounded-lg p-6 pt-10 text-center bg-gradient-to-br from-white to-slate-50">
                                        <div class="font-bold text-slate-800">Service Name</div>
                                        <div class="text-xs text-slate-500 mt-2">Description with floating icon badge</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-white">
                            <h3 class="font-bold text-slate-800 text-lg">Style 4</h3>
                            <p class="text-sm text-slate-500 mt-1">Card with floating icon badge</p>
                        </div>
                    </button>
                </div>

                <div class="mt-6 p-4 bg-purple-50 border border-purple-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-sm text-purple-800">
                            <p class="font-semibold">Choose your preferred style</p>
                            <p class="text-purple-600 mt-1">You can select which services to display after choosing a style.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
