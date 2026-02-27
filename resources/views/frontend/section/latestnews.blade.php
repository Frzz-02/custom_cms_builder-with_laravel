@if ($shortcode->type == 'latestnews')
    @if ($shortcode->latestnews_style == 'Style 1')

        <!-- Blog Slider Section - Auto Animate -->
        <section class="py-16 bg-gray-50">
            <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24 mb-10">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-medium tracking-[0.3em] text-gray-400 mb-2 block">BLOG & ARTIKEL</span>
                        <h2 class="text-3xl md:text-4xl font-light text-gray-900">Inspirasi & Tips</h2>
                    </div>
                    <a href="{{ route('blog') }}" class="text-sm font-medium tracking-wider text-gray-600 hover:text-red-600 transition-colors border-b border-gray-400 pb-1">
                        LIHAT SEMUA
                    </a>
                </div>
            </div>

            <!-- Auto Scroll Slider -->
            <div class="relative overflow-hidden" x-data="{
                isPaused: false
            }"
            x-on:mouseenter="isPaused = true"
            x-on:mouseleave="isPaused = false">

                <div class="flex animate-scroll gap-6 pl-6"
                    :style="isPaused ? 'animation-play-state: paused' : 'animation-play-state: running'">

                    <!-- Blog Card 1 -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">MATERIAL</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Tips Memilih Produk ATK Berkualitas untuk Kantor</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">15 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Blog Card 2 -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">TIPS</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Cara Efisiensi Pengadaan Barang untuk Bisnis Anda</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">14 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Blog Card 3 -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">DESIGN</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Rekomendasi Alat Kebersihan Profesional untuk Kantor</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">13 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Blog Card 4 -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">PERAWATAN</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Perlengkapan IT yang Wajib Ada di Kantor Modern</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">12 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Blog Card 5 -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">INSPIRASI</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Furniture Kantor Ergonomis: Investasi untuk Produktivitas</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">11 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Blog Card 6 -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">BISNIS</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Strategi Pengadaan Alat Kesehatan yang Efektif</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">10 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Duplicate cards for seamless loop -->
                    <!-- Blog Card 1 Duplicate -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1586339949916-3e9457bef6d3?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">MATERIAL</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Tips Memilih Produk ATK Berkualitas untuk Kantor</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">15 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Blog Card 2 Duplicate -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">TIPS</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Cara Efisiensi Pengadaan Barang untuk Bisnis Anda</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">14 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Blog Card 3 Duplicate -->
                    <a href="{{ route('blog') }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="https://images.unsplash.com/photo-1542744094-3a31f272c490?w=400&q=80"
                                    alt="Blog" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded">DESIGN</span>
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">Rekomendasi Alat Kebersihan Profesional untuk Kantor</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">13 Jan 2026</span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Navigation Dots -->
            <div class="flex justify-center gap-2 mt-8">
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                <span class="w-8 h-2 rounded-full bg-gray-900"></span>
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
            </div>
        </section>
      
    
    @elseif ($shortcode->latestnews_style == 'Style 2')

        

    @endif


@endif