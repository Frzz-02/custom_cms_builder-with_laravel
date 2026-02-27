
@if ($shortcode->type == 'recentproduct')
    <!-- Produk Pilihan Section -->
    <section class="py-20 bg-white">
        <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24">
            <!-- Header -->
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl text-gray-900 italic">Produk Pilihan Untuk Kebutuhan Anda</h2>
            </div>

            <!-- Products Slider -->
            <div class="relative" x-data="{
                scrollContainer: null,
                scrollLeft() {
                    this.scrollContainer.scrollBy({ left: -320, behavior: 'smooth' })
                },
                scrollRight() {
                    this.scrollContainer.scrollBy({ left: 320, behavior: 'smooth' })
                }
            }" x-init="scrollContainer = $refs.slider">

                <!-- Arrow Left -->
                <button @click="scrollLeft()" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <!-- Arrow Right -->
                <button @click="scrollRight()" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Products Container -->
                <div x-ref="slider" class="flex gap-4 overflow-x-auto scrollbar-hide scroll-smooth pb-4" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <!-- Product 1: ATK -->
                    <div class="group flex-shrink-0 w-[280px] card-lift" data-reveal data-reveal-delay="1">
                        <div class="bg-[#f5f5f3] aspect-square relative overflow-hidden img-zoom">
                            <img src="{{ asset('images/hero/alattuliskantor.jpg') }}" alt="Alat Tulis Kantor"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500">
                        </div>
                        <div class="pt-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-gray-900 font-medium text-sm">Alat Tulis Kantor</h3>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="text-yellow-500">★★★★★</span>
                                    <span class="text-gray-500">21 Reviews</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs text-gray-500">Minimum order 10 pcs</p>
                                <span class="text-sm font-medium text-gray-900">Rp.5.000<span class="text-xs text-gray-400">/pcs</span></span>
                            </div>
                            <a href="{{ route('produk.index') }}" class="inline-block px-4 py-2 border border-gray-400 text-gray-700 text-xs hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-colors">
                                Lihat Produk
                            </a>
                        </div>
                    </div>

                    <!-- Product 2: Alat Kebersihan -->
                    <div class="group flex-shrink-0 w-[280px] card-lift" data-reveal data-reveal-delay="2">
                        <div class="bg-[#f5f5f3] aspect-square relative overflow-hidden img-zoom">
                            <img src="{{ asset('images/hero/alatkebersihan.jpg') }}" alt="Alat Kebersihan"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500">
                        </div>
                        <div class="pt-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-gray-900 font-medium text-sm">Alat Kebersihan</h3>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="text-yellow-500">★★★★★</span>
                                    <span class="text-gray-500">32 Reviews</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs text-gray-500">Minimum order 5 pcs</p>
                                <span class="text-sm font-medium text-gray-900">Rp.15.000<span class="text-xs text-gray-400">/pcs</span></span>
                            </div>
                            <a href="{{ route('produk.index') }}" class="inline-block px-4 py-2 border border-gray-400 text-gray-700 text-xs hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-colors">
                                Lihat Produk
                            </a>
                        </div>
                    </div>

                    <!-- Product 3: Alat Kesehatan -->
                    <div class="group flex-shrink-0 w-[280px] card-lift" data-reveal data-reveal-delay="3">
                        <div class="bg-[#f5f5f3] aspect-square relative overflow-hidden img-zoom">
                            <img src="{{ asset('images/hero/alatkesehatan.jpg') }}" alt="Alat Kesehatan"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500">
                        </div>
                        <div class="pt-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-gray-900 font-medium text-sm">Alat Kesehatan</h3>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="text-yellow-500">★★★★★</span>
                                    <span class="text-gray-500">45 Reviews</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs text-gray-500">Minimum order 12 pcs</p>
                                <span class="text-sm font-medium text-gray-900">Rp.2.000<span class="text-xs text-gray-400">/pcs</span></span>
                            </div>
                            <a href="{{ route('produk.index') }}" class="inline-block px-4 py-2 border border-gray-400 text-gray-700 text-xs hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-colors">
                                Lihat Produk
                            </a>
                        </div>
                    </div>

                    <!-- Product 4: Home Appliances -->
                    <div class="group flex-shrink-0 w-[280px] card-lift" data-reveal data-reveal-delay="4">
                        <div class="bg-[#f5f5f3] aspect-square relative overflow-hidden img-zoom">
                            <img src="{{ asset('images/hero/homeappliances.jpg') }}" alt="Home Appliances"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500">
                        </div>
                        <div class="pt-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-gray-900 font-medium text-sm">Home Appliances</h3>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="text-yellow-500">★★★★★</span>
                                    <span class="text-gray-500">23 Reviews</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs text-gray-500">Minimum order 1 pcs</p>
                                <span class="text-sm font-medium text-gray-900">Rp.200.000<span class="text-xs text-gray-400">/pcs</span></span>
                            </div>
                            <a href="{{ route('produk.index') }}" class="inline-block px-4 py-2 border border-gray-400 text-gray-700 text-xs hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-colors">
                                Lihat Produk
                            </a>
                        </div>
                    </div>

                    <!-- Product 5: Furniture -->
                    <div class="group flex-shrink-0 w-[280px] card-lift">
                        <div class="bg-[#f5f5f3] aspect-square relative overflow-hidden img-zoom">
                            <img src="{{ asset('images/hero/furniturekantor.jpg') }}" alt="Furniture Kantor"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500">
                        </div>
                        <div class="pt-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-gray-900 font-medium text-sm">Furniture Kantor</h3>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="text-yellow-500">★★★★★</span>
                                    <span class="text-gray-500">11 Reviews</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs text-gray-500">Minimum order 1 pcs</p>
                                <span class="text-sm font-medium text-gray-900">Rp.800.000<span class="text-xs text-gray-400">/pcs</span></span>
                            </div>
                            <a href="{{ route('produk.index') }}" class="inline-block px-4 py-2 border border-gray-400 text-gray-700 text-xs hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-colors">
                                Lihat Produk
                            </a>
                        </div>
                    </div>

                    <!-- Product 6: IT Hardware -->
                    <div class="group flex-shrink-0 w-[280px] card-lift">
                        <div class="bg-[#f5f5f3] aspect-square relative overflow-hidden img-zoom">
                            <img src="{{ asset('images/hero/it.jpg') }}" alt="IT Hardware & Software"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500">
                        </div>
                        <div class="pt-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-gray-900 font-medium text-sm">IT Hardware & Software</h3>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="text-yellow-500">★★★★★</span>
                                    <span class="text-gray-500">37 Reviews</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs text-gray-500">Minimum order 1 pcs</p>
                                <span class="text-sm font-medium text-gray-900">Rp.150.000<span class="text-xs text-gray-400">/pcs</span></span>
                            </div>
                            <a href="{{ route('produk.index') }}" class="inline-block px-4 py-2 border border-gray-400 text-gray-700 text-xs hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-colors">
                                Lihat Produk
                            </a>
                        </div>
                    </div>

                    <!-- Product 7: Lanyard / ID Card -->
                    <div class="group flex-shrink-0 w-[280px] card-lift">
                        <div class="bg-[#f5f5f3] aspect-square relative overflow-hidden img-zoom">
                            <img src="{{ asset('images/hero/idcard.png') }}" alt="Lanyard & ID Card"
                                class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500">
                        </div>
                        <div class="pt-4">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-gray-900 font-medium text-sm">Lanyard & ID Card</h3>
                                <div class="flex items-center gap-1 text-xs">
                                    <span class="text-yellow-500">★★★★★</span>
                                    <span class="text-gray-500">22 Reviews</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-xs text-gray-500">Minimum order 10 pcs</p>
                                <span class="text-sm font-medium text-gray-900">Rp.3.000<span class="text-xs text-gray-400">/pcs</span></span>
                            </div>
                            <a href="{{ route('produk.index') }}" class="inline-block px-4 py-2 border border-gray-400 text-gray-700 text-xs hover:bg-gray-900 hover:text-white hover:border-gray-900 transition-colors">
                                Lihat Produk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
