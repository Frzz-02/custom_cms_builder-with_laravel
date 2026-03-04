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
    
        <section class="w-full px-8 md:px-16 py-16 bg-gray-50/60">

            {{-- Top: Image + Why Choose Us --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-8">

                {{-- Left: Modern Image Block --}}
                <div class="relative flex items-center justify-center py-8 px-6 reveal from-left">

                    {{-- Decorative background blob --}}
                    <div class="absolute w-72 h-72 rounded-full bg-gray-100 opacity-60 -z-0 top-4 left-4"></div>

                    {{-- Main Image --}}
                    <div class="relative z-10 overflow-hidden shadow-2xl w-full max-w-sm mx-auto aspect-[4/5]">
                        <img
                            src="{{ asset('images/cs.jpg') }}"
                            alt="Tim CS Mitra Malang"
                            class="w-full h-full object-cover object-center">
                    </div>

                    {{-- Floating badge: years --}}
                    <div class="absolute top-6 -right-2 md:right-4 z-20 bg-white rounded-sm shadow-lg px-4 py-3 flex items-center gap-3 float-badge">
                        <div class="w-9 h-9 bg-gray-400 rounded-xl flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-extrabold text-gray-900 leading-none">5+</p>
                            <p class="text-xs text-gray-500 mt-0.5">Tahun Berpengalaman</p>
                        </div>
                    </div>

                    {{-- Floating badge: customers --}}
                    <div class="absolute -bottom-2 left-2 md:left-6 z-20 bg-gray-900 rounded-sm shadow-lg px-4 py-3 flex items-center gap-3 float-badge-slow">
                        <div class="flex -space-x-2 shrink-0">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=64&auto=format&fit=crop&q=80" class="w-7 h-7 rounded-full border-2 border-gray-900 object-cover">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=64&auto=format&fit=crop&q=80" class="w-7 h-7 rounded-full border-2 border-gray-900 object-cover">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=64&auto=format&fit=crop&q=80" class="w-7 h-7 rounded-full border-2 border-gray-900 object-cover">
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-white leading-none">500+</p>
                            <p class="text-xs text-gray-400 mt-0.5">Instansi Terlayani</p>
                        </div>
                    </div>

                </div>

                {{-- Right: Why Choose Us --}}
                <div class="flex flex-col justify-center reveal from-right">
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-5 leading-tight">
                        Mitra Terpercaya<br>Pengadaan TKDN
                    </h2>
                    <p class="text-gray-500 text-base leading-relaxed mb-8 max-w-md">
                        Kami hadir sebagai platform yang menghubungkan instansi pemerintah &amp; swasta dengan penyedia barang dan jasa lokal yang telah terverifikasi TKDN, terdaftar e-Katalog LKPP, dan siap mendukung kebutuhan pengadaan Anda.
                    </p>

                    {{-- Accordion --}}
                    <div class="divide-y divide-gray-200 border-y border-gray-200" x-data="{ open: 2 }">

                        {{-- Item 1 --}}
                        <div class="py-5">
                            <button @click="open = open === 1 ? null : 1"
                                    class="w-full flex items-center justify-between text-left group">
                                <span class="text-base font-bold text-gray-900 group-hover:text-gray-600 transition-colors">
                                    Produk Bersertifikat TKDN
                                </span>
                                <span class="text-2xl font-light text-gray-400 leading-none ml-4 shrink-0"
                                    x-text="open === 1 ? '−' : '+'">+</span>
                            </button>
                            <div x-show="open === 1" x-transition class="mt-2 text-sm text-gray-500 leading-relaxed pr-8">
                                Seluruh produk yang kami sediakan telah memiliki sertifikasi TKDN resmi dari Kementerian Perindustrian, memastikan kepatuhan penuh terhadap regulasi pengadaan pemerintah.
                            </div>
                        </div>

                        {{-- Item 2 --}}
                        <div class="py-5">
                            <button @click="open = open === 2 ? null : 2"
                                    class="w-full flex items-center justify-between text-left group">
                                <span class="text-base font-bold text-gray-900 group-hover:text-gray-600 transition-colors">
                                    Terdaftar di e-Katalog LKPP
                                </span>
                                <span class="text-2xl font-light text-gray-400 leading-none ml-4 shrink-0"
                                    x-text="open === 2 ? '−' : '+'">−</span>
                            </button>
                            <div x-show="open === 2" x-transition class="mt-2 text-sm text-gray-500 leading-relaxed pr-8">
                                Semua mitra kami terdaftar resmi di e-Katalog LKPP, sehingga proses pengadaan instansi menjadi lebih mudah, transparan, dan sesuai dengan ketentuan Perpres Pengadaan Barang/Jasa Pemerintah.
                            </div>
                        </div>

                        {{-- Item 3 --}}
                        <div class="py-5">
                            <button @click="open = open === 3 ? null : 3"
                                    class="w-full flex items-center justify-between text-left group">
                                <span class="text-base font-bold text-gray-900 group-hover:text-gray-600 transition-colors">
                                    6 Kategori Pengadaan Lengkap
                                </span>
                                <span class="text-2xl font-light text-gray-400 leading-none ml-4 shrink-0"
                                    x-text="open === 3 ? '−' : '+'">+</span>
                            </button>
                            <div x-show="open === 3" x-transition class="mt-2 text-sm text-gray-500 leading-relaxed pr-8">
                                Kami menyediakan 6 kategori kebutuhan instansi: Alat Tulis &amp; Kantor, Alat Kebersihan, Alat Kesehatan, Home Appliances, Furniture, serta IT Hardware &amp; Software — semua dalam satu platform.
                            </div>
                        </div>

                        {{-- Item 4 --}}
                        <div class="py-5">
                            <button @click="open = open === 4 ? null : 4"
                                    class="w-full flex items-center justify-between text-left group">
                                <span class="text-base font-bold text-gray-900 group-hover:text-gray-600 transition-colors">
                                    Mitra Penyedia Terverifikasi
                                </span>
                                <span class="text-2xl font-light text-gray-400 leading-none ml-4 shrink-0"
                                    x-text="open === 4 ? '−' : '+'">+</span>
                            </button>
                            <div x-show="open === 4" x-transition class="mt-2 text-sm text-gray-500 leading-relaxed pr-8">
                                Setiap mitra penyedia kami telah melalui proses verifikasi legalitas, kemampuan produksi, dan kepatuhan TKDN, sehingga instansi dapat berbelanja dengan aman dan akuntabel.
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Bottom: 3 Feature Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                {{-- Card 1: 100% Authentic --}}
                <div class="bg-amber-50 p-6 flex flex-col gap-3 reveal delay-1">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Produk Bersertifikat TKDN</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Seluruh produk telah memiliki sertifikat TKDN resmi dari Kemenperin, siap untuk proses pengadaan pemerintah.</p>
                    </div>
                    <a href="#" class="mt-auto inline-flex items-center justify-center border border-gray-300 text-xs font-semibold text-gray-700 px-4 py-2 rounded-full hover:border-red-600 hover:text-red-600 transition-colors w-fit">
                        Lihat Detail
                    </a>
                </div>

                {{-- Card 2: Free Return --}}
                <div class="bg-white border border-gray-100 p-6 flex flex-col gap-3 shadow-sm reveal delay-2">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 15v1a3 3 0 01-6 0v-1m6-8V5a3 3 0 00-6 0v2M5 10h14M5 10l2-2m-2 2l2 2m10-2l-2-2m2 2l-2 2"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Terdaftar e-Katalog LKPP</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Mitra kami terdaftar resmi di e-Katalog LKPP, mempermudah proses pembelian langsung oleh instansi pemerintah.</p>
                    </div>
                    <a href="#" class="mt-auto inline-flex items-center justify-center border border-gray-300 text-xs font-semibold text-gray-700 px-4 py-2 rounded-full hover:border-red-600 hover:text-red-600 transition-colors w-fit">
                        Lihat Detail
                    </a>
                </div>

                {{-- Card 3: Safe Payments --}}
                <div class="bg-white border border-gray-100 p-6 flex flex-col gap-3 shadow-sm reveal delay-3">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 mb-1">Sesuai Perpres Pengadaan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">Seluruh proses pengadaan kami mengikuti ketentuan Perpres No. 16/2018 dan perubahannya untuk keamanan dan akuntabilitas.</p>
                    </div>
                    <a href="#" class="mt-auto inline-flex items-center justify-center border border-gray-300 text-xs font-semibold text-gray-700 px-4 py-2 rounded-full hover:border-red-600 hover:text-red-600 transition-colors w-fit">
                        Lihat Detail
                    </a>
                </div>

            </div>

        </section>
    




    @elseif ($shortcode->service_style == 'Style 3')

        
    
    
    
    @endif
@endif