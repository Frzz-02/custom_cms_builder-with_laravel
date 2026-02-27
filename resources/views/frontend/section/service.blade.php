@if ($shortcode->type == 'service')
    @if ($shortcode->service_style == 'Style 1')

        <!-- Keunggulan Kami - Minimalist Slider -->
        <section class="py-24 bg-[#e8e4df] relative overflow-hidden" data-reveal>
            <!-- Batik Pattern Background -->
            <div class="absolute inset-0" style="background-image: url('{{ asset('images/batik-bg.jpeg') }}'); background-repeat: no-repeat; background-size: cover; background-position: center; opacity: 1;"></div>

            <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24 relative z-10">

                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl text-gray-900 italic">Kenapa Harus Mitra Jogja?</h2>
                </div>

                <div x-data="{ activeSlide: 0, totalSlides: 3 }" class="relative">
                    <!-- Navigation Arrow Left -->
                    <button x-on:click="activeSlide = (activeSlide - 1 + totalSlides) % totalSlides"
                            class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-8 z-10 text-gray-400 hover:text-red-600 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>

                    <!-- Content Container -->
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-700 ease-in-out"
                            :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">

                            <!-- Slide 1 - Produk Lengkap -->
                            <div class="min-w-full">
                                <div class="text-center">
                                    <!-- Image -->
                                    <div class="mb-10">
                                        <img src="{{ asset('images/keunggulan/proses-cepat.jpg') }}"
                                            alt="Produk Lengkap"
                                            class="w-full max-w-md mx-auto aspect-[4/3] object-cover"
                                            onerror="this.src='https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&q=80'">
                                    </div>

                                    <!-- Text Content -->
                                    <p class="text-xs tracking-[0.2em] text-gray-500 uppercase mb-3">BY MITRAJOGJA</p>
                                    <h3 class="text-3xl md:text-4xl text-gray-900 mb-6">
                                        Produk Lengkap & Terpercaya
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed max-w-xl mx-auto text-sm md:text-base">
                                        Menyediakan lebih dari 10.000+ item produk dari berbagai kategori. Mulai dari alat tulis kantor, perlengkapan kebersihan, alat kesehatan, furniture, hingga IT hardware & software. Semua produk original dengan garansi resmi.
                                    </p>
                                </div>
                            </div>

                            <!-- Slide 2 - Harga Kompetitif -->
                            <div class="min-w-full">
                                <div class="text-center">
                                    <!-- Image -->
                                    <div class="mb-10">
                                        <img src="{{ asset('images/keunggulan/kualitas-premium.jpg') }}"
                                            alt="Harga Kompetitif"
                                            class="w-full max-w-md mx-auto aspect-[4/3] object-cover"
                                            onerror="this.src='https://images.unsplash.com/photo-1567427017947-545c5f8d16ad?w=600&q=80'">
                                    </div>

                                    <!-- Text Content -->
                                    <p class="text-xs tracking-[0.2em] text-gray-500 uppercase mb-3">BY MITRAJOGJA</p>
                                    <h3 class="text-3xl md:text-4xl text-gray-900 mb-6">
                                        Harga Kompetitif & Terbaik
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed max-w-xl mx-auto text-sm md:text-base">
                                        Dapatkan harga terbaik untuk pembelian dalam jumlah besar. Sistem harga bertingkat yang menguntungkan untuk bisnis Anda. Kami berkomitmen memberikan value terbaik dengan kualitas produk yang tidak perlu diragukan lagi.
                                    </p>
                                </div>
                            </div>

                            <!-- Slide 3 - Pelayanan Profesional -->
                            <div class="min-w-full">
                                <div class="text-center">
                                    <!-- Image -->
                                    <div class="mb-10">
                                        <img src="{{ asset('images/keunggulan/pelayanan.jpg') }}"
                                            alt="Pelayanan Terbaik"
                                            class="w-full max-w-md mx-auto aspect-[4/3] object-cover"
                                            onerror="this.src='https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600&q=80'">
                                    </div>

                                    <!-- Text Content -->
                                    <p class="text-xs tracking-[0.2em] text-gray-500 uppercase mb-3">BY MITRAJOGJA</p>
                                    <h3 class="text-3xl md:text-4xl text-gray-900 mb-6">
                                        Layanan Profesional & Responsif
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed max-w-xl mx-auto text-sm md:text-base">
                                        Tim customer service kami siap membantu kebutuhan bisnis Anda dengan responsif. Sistem pemesanan mudah, pengiriman cepat ke seluruh Indonesia, dan after-sales service yang memuaskan. Kepuasan Anda adalah prioritas kami.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Arrow Right -->
                    <button x-on:click="activeSlide = (activeSlide + 1) % totalSlides"
                            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-8 z-10 text-gray-400 hover:text-red-600 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
        
    @elseif ($shortcode->service_style == 'Style 2')
        
    @endif
@endif