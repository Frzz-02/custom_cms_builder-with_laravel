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

        <section class="w-full px-8 md:px-16 py-16 bg-gray-50/60 reveal">
            @php
                $blogs = [
                    [
                        'tag'     => 'Produk Lokal',
                        'title'   => 'Mengenal Produk UMKM Malang yang Tembus Pasar Nasional',
                        'date'    => '8 Maret 2026',
                        'comments'=> 'Tanpa Komentar',
                        'img'     => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&auto=format&fit=crop&q=80',
                    ],
                    [
                        'tag'  => 'Kerajinan',
                        'title'=> 'Kerajinan Gerabah Malang Kini Diekspor ke Eropa',
                        'date' => '8 Maret 2026',
                        'img'  => 'https://images.unsplash.com/photo-1565193566173-7a0ee3dbe261?w=400&auto=format&fit=crop&q=80',
                    ],
                    [
                        'tag'  => 'Kuliner',
                        'title'=> 'Kopi Arabika Malang: Cita Rasa Dunia dari Lereng Semeru',
                        'date' => '8 Maret 2026',
                        'img'  => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=400&auto=format&fit=crop&q=80',
                    ],
                    [
                        'tag'  => 'Fashion',
                        'title'=> 'Batik Malangan Tampil di Panggung Mode Internasional',
                        'date' => '8 Maret 2026',
                        'img'  => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400&auto=format&fit=crop&q=80',
                    ],
                    [
                        'tag'  => 'Wisata',
                        'title'=> 'Wisata Edukasi UMKM Malang yang Wajib Dikunjungi',
                        'date' => '7 Maret 2026',
                        'img'  => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&auto=format&fit=crop&q=80',
                    ],
                    [
                        'tag'  => 'Tips',
                        'title'=> '5 Tips Memilih Produk Lokal Berkualitas dari Malang',
                        'date' => '6 Maret 2026',
                        'img'  => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=400&auto=format&fit=crop&q=80',
                    ],
                ];
            @endphp

            {{-- Section Header --}}
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                    <span class="inline-block w-1 h-8 bg-gray-400 rounded-full"></span>
                    Info Terbaru Hari Ini
                </h2>
                <a href="{{ route('blog') }}"
                class="text-xs font-bold text-gray-500 uppercase tracking-widest hover:text-red-600 transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>

            {{-- 3-Column Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Col 1: Featured Large Card --}}
                <div class="relative overflow-hidden h-[500px] cursor-pointer group card-hover">
                    <img src="{{ $blogs[0]['img'] }}" alt="{{ $blogs[0]['title'] }}"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <span class="inline-block bg-gray-400 text-gray-900 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-3">
                            {{ $blogs[0]['tag'] }}
                        </span>
                        <h3 class="text-white font-bold text-base leading-snug mb-3">{{ $blogs[0]['title'] }}</h3>
                        <div class="flex items-center gap-4 text-gray-300 text-xs">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $blogs[0]['date'] }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                {{ $blogs[0]['comments'] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Col 2: 3 Small Horizontal Cards --}}
                <div class="flex flex-col gap-4 h-[500px]">
                    @foreach(array_slice($blogs, 1, 3) as $b)
                    <a href="{{ route('blog') }}" class="flex items-center gap-4 bg-white rounded-sm p-4 shadow-sm hover:shadow-md transition-shadow group cursor-pointer border border-gray-100 flex-1">
                        <div class="w-24 h-24 overflow-hidden shrink-0">
                            <img src="{{ $b['img'] }}" alt="{{ $b['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="inline-block bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wide px-2.5 py-0.5 rounded-full mb-1.5">
                                {{ $b['tag'] }}
                            </span>
                            <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-2 mb-1.5">{{ $b['title'] }}</h3>
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $b['date'] }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Col 3: 2 Tall Cards --}}
                <div class="flex flex-col gap-4 h-[500px]">
                    @foreach(array_slice($blogs, 4, 2) as $b)
                    <a href="{{ route('blog') }}" class="relative overflow-hidden flex-1 cursor-pointer group card-hover block">
                        <img src="{{ $b['img'] }}" alt="{{ $b['title'] }}"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <span class="inline-block bg-gray-400 text-gray-900 text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full mb-2">
                                {{ $b['tag'] }}
                            </span>
                            <h3 class="text-white font-bold text-sm leading-snug">{{ $b['title'] }}</h3>
                        </div>
                    </a>
                    @endforeach
                </div>

            </div>
        </section>
    
        

        
        
        
        
        
    @elseif ($shortcode->latestnews_style == 'Style 2')
    
        

    @endif


@endif