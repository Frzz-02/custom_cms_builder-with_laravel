
@if ($shortcode->type == 'hero banner')
    @if ($shortcode->hero_style == 'Style 1')
    
        <section class="pt-20 bg-white">
            <div class="min-h-[calc(100vh-80px)] md:h-[calc(100vh-80px)] flex flex-col md:flex-row"
                x-data="{ activePanel: null }"
                @click.away="activePanel = null">
                <!-- Panel 1 - Alat Tulis Kantor -->
                <div class="panel-item group"
                    :class="{ 'active': activePanel === 1 }"
                    @click="activePanel = (activePanel === 1) ? null : 1">
                    <img src="{{ asset('images/hero/alattuliskantor.jpg') }}"
                        alt="Alat Tulis Kantor"
                        onerror="this.src='https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=800&q=80'">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-500"></div>

                    <!-- Content Overlay Card -->
                    <div class="content-card absolute bottom-0 right-0 left-0 bg-white/60 backdrop-blur-md p-4 md:p-6 lg:p-8">
                        <span class="inline-block px-3 py-1.5 border border-gray-300 text-[10px] font-medium tracking-[0.15em] text-gray-600 mb-3 md:mb-4">KATEGORI: STATIONERY</span>
                        <h2 class="text-lg md:text-xl lg:text-2xl text-gray-900 mb-2 md:mb-3 leading-tight">
                            Alat Tulis Kantor
                        </h2>
                        <p class="hidden md:block text-gray-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">
                            Lengkapi kebutuhan alat tulis kantor Anda dengan produk berkualitas dari brand ternama. Harga kompetitif untuk kebutuhan bisnis.
                        </p>
                        <a href="{{ route('produk.index') }}" @click.stop
                        class="inline-block text-xs font-medium tracking-[0.15em] text-gray-600/70 border-b border-gray-400/50 pb-1 hover:text-red-600 hover:border-red-600 transition-colors">
                            READ MORE
                        </a>
                    </div>
                </div>

                <!-- Panel 2 - Alat Kebersihan -->
                <div class="panel-item group"
                    :class="{ 'active': activePanel === 2 }"
                    @click="activePanel = (activePanel === 2) ? null : 2">
                    <img src="{{ asset('images/hero/alatkebersihan.jpg') }}"
                        alt="Alat Kebersihan"
                        onerror="this.src='https://images.unsplash.com/photo-1563453392212-326f5e854473?w=800&q=80'">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-500"></div>

                    <!-- Content Overlay Card -->
                    <div class="content-card absolute bottom-0 right-0 left-0 bg-white/60 backdrop-blur-md p-4 md:p-6 lg:p-8">
                        <span class="inline-block px-3 py-1.5 border border-gray-300 text-[10px] font-medium tracking-[0.15em] text-gray-600 mb-3 md:mb-4">KATEGORI: CLEANING</span>
                        <h2 class="text-lg md:text-xl lg:text-2xl text-gray-900 mb-2 md:mb-3 leading-tight">
                            Alat Kebersihan
                        </h2>
                        <p class="hidden md:block text-gray-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">
                            Perlengkapan kebersihan profesional untuk kantor, hotel, dan rumah sakit. Produk ramah lingkungan dengan harga terjangkau.
                        </p>
                        <a href="https://wa.me/6281316509191?text=Halo%20MitraJogja,%20saya%20ingin%20konsultasi%20alat%20kebersihan" @click.stop
                        class="inline-block text-xs font-medium tracking-[0.15em] text-gray-600/70 border-b border-gray-400/50 pb-1 hover:text-red-600 hover:border-red-600 transition-colors">
                            READ MORE
                        </a>
                    </div>
                </div>

                <!-- Panel 3 - Alat Kesehatan -->
                <div class="panel-item group"
                    :class="{ 'active': activePanel === 3 }"
                    @click="activePanel = (activePanel === 3) ? null : 3">
                    <img src="{{ asset('images/hero/alatkesehatan.jpg') }}"
                        alt="Alat Kesehatan"
                        onerror="this.src='https://images.unsplash.com/photo-1584362917165-526a968579e8?w=800&q=80'">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-500"></div>

                    <!-- Content Overlay Card -->
                    <div class="content-card absolute bottom-0 right-0 left-0 bg-white/60 backdrop-blur-md p-4 md:p-6 lg:p-8">
                        <span class="inline-block px-3 py-1.5 border border-gray-300 text-[10px] font-medium tracking-[0.15em] text-gray-600 mb-3 md:mb-4">KATEGORI: HEALTHCARE</span>
                        <h2 class="text-lg md:text-xl lg:text-2xl text-gray-900 mb-2 md:mb-3 leading-tight">
                            Alat Kesehatan
                        </h2>
                        <p class="hidden md:block text-gray-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">
                            Peralatan medis dan kesehatan berkualitas untuk klinik, apotek, dan rumah sakit. Bersertifikat dan terpercaya.
                        </p>
                        <a href="https://wa.me/6281316509191?text=Halo%20MitraJogja,%20saya%20butuh%20alat%20kesehatan" @click.stop
                        class="inline-block text-xs font-medium tracking-[0.15em] text-gray-600/70 border-b border-gray-400/50 pb-1 hover:text-red-600 hover:border-red-600 transition-colors">
                            READ MORE
                        </a>
                    </div>
                </div>

                <!-- Panel 4 - Home Appliances -->
                <div class="panel-item group"
                    :class="{ 'active': activePanel === 4 }"
                    @click="activePanel = (activePanel === 4) ? null : 4">
                    <img src="{{ asset('images/hero/homeappliances.jpg') }}"
                        alt="Home Appliances"
                        onerror="this.src='https://images.unsplash.com/photo-1556911220-bff31c812dba?w=800&q=80'">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-500"></div>

                    <!-- Content Overlay Card -->
                    <div class="content-card absolute bottom-0 right-0 left-0 bg-white/60 backdrop-blur-md p-4 md:p-6 lg:p-8">
                        <span class="inline-block px-3 py-1.5 border border-gray-300 text-[10px] font-medium tracking-[0.15em] text-gray-600 mb-3 md:mb-4">KATEGORI: APPLIANCES</span>
                        <h2 class="text-lg md:text-xl lg:text-2xl text-gray-900 mb-2 md:mb-3 leading-tight">
                            Home Appliances
                        </h2>
                        <p class="hidden md:block text-gray-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">
                            Peralatan rumah tangga modern dari brand terpercaya. Garansi resmi dengan layanan purna jual terbaik.
                        </p>
                        <a href="{{ route('produk.index') }}" @click.stop
                        class="inline-block text-xs font-medium tracking-[0.15em] text-gray-600/70 border-b border-gray-400/50 pb-1 hover:text-red-600 hover:border-red-600 transition-colors">
                            READ MORE
                        </a>
                    </div>
                </div>

                <!-- Panel 5 - Furniture -->
                <div class="panel-item group"
                    :class="{ 'active': activePanel === 5 }"
                    @click="activePanel = (activePanel === 5) ? null : 5">
                    <img src="{{ asset('images/hero/furniturekantor.jpg') }}"
                        alt="Furniture"
                        onerror="this.src='https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800&q=80'">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-500"></div>

                    <!-- Content Overlay Card -->
                    <div class="content-card absolute bottom-0 right-0 left-0 bg-white/60 backdrop-blur-md p-4 md:p-6 lg:p-8">
                        <span class="inline-block px-3 py-1.5 border border-gray-300 text-[10px] font-medium tracking-[0.15em] text-gray-600 mb-3 md:mb-4">KATEGORI: FURNITURE</span>
                        <h2 class="text-lg md:text-xl lg:text-2xl text-gray-900 mb-2 md:mb-3 leading-tight">
                            Furniture Kantor & Rumah
                        </h2>
                        <p class="hidden md:block text-gray-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">
                            Furnitur berkualitas untuk kantor, rumah, dan hotel. Desain modern dengan material premium dan harga bersaing.
                        </p>
                        <a href="{{ route('portfolio') }}" @click.stop
                        class="inline-block text-xs font-medium tracking-[0.15em] text-gray-600/70 border-b border-gray-400/50 pb-1 hover:text-red-600 hover:border-red-600 transition-colors">
                            READ MORE
                        </a>
                    </div>
                </div>
                <!-- Panel 6 - IT Hardware & Software -->
                <div class="panel-item group"
                    :class="{ 'active': activePanel === 6 }"
                    @click="activePanel = (activePanel === 6) ? null : 6">
                    <img src="{{ asset('images/hero/it.jpg') }}"
                        alt="IT Hardware Software"
                        onerror="this.src='https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&q=80'">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-500"></div>

                    <!-- Content Overlay Card -->
                    <div class="content-card absolute bottom-0 right-0 left-0 bg-white/60 backdrop-blur-md p-4 md:p-6 lg:p-8">
                        <span class="inline-block px-3 py-1.5 border border-gray-300 text-[10px] font-medium tracking-[0.15em] text-gray-600 mb-3 md:mb-4">KATEGORI: TECHNOLOGY</span>
                        <h2 class="text-lg md:text-xl lg:text-2xl text-gray-900 mb-2 md:mb-3 leading-tight">
                            IT Hardware & Software
                        </h2>
                        <p class="hidden md:block text-gray-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">
                            Solusi teknologi lengkap untuk bisnis Anda. Komputer, printer, networking, hingga software lisensi resmi.
                        </p>
                        <a href="{{ route('portfolio') }}" @click.stop
                        class="inline-block text-xs font-medium tracking-[0.15em] text-gray-600/70 border-b border-gray-400/50 pb-1 hover:text-red-600 hover:border-red-600 transition-colors">
                            READ MORE
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        
        
        
        
        
        
        
        
    @elseif ($shortcode->hero_style == 'Style 2')
    
        <section class="relative w-full min-h-screen overflow-hidden"
            x-data="{
                current: 0,
                slides: [
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1600&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1600&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1568992687947-868a62a9f521?w=1600&auto=format&fit=crop&q=80'
                ],
                init() {
                    setInterval(() => { this.current = (this.current + 1) % this.slides.length }, 5000)
                }
            }">

            {{-- Slide Backgrounds --}}
            <template x-for="(slide, i) in slides" :key="i">
                <div class="absolute inset-0 bg-center bg-cover transition-opacity duration-1000"
                    :style="`background-image: url('${slide}')`"
                    :class="current === i ? 'opacity-100' : 'opacity-0'">
                </div>
            </template>

            {{-- Dark Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70 z-10"></div>

            {{-- Content --}}
            <div class="relative z-20 flex flex-col items-center justify-center min-h-screen text-center px-8 md:px-16 py-24">

                {{-- Badge Label --}}
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-full mb-6 reveal">
                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    Platform Pengadaan TKDN Terpercaya
                </div>

                {{-- Heading --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight max-w-4xl mb-6 reveal">
                    Solusi Pengadaan
                    <span class="relative inline-block">
                        <span class="relative z-10">Barang &amp; Jasa</span>
                        <span class="absolute -bottom-1 left-0 w-full h-2 bg-red-500 -z-0 opacity-70 rounded-sm"></span>
                    </span>
                    <br>Berstandar TKDN untuk Instansi
                </h1>

                {{-- Subtext --}}
                <p class="text-white/70 text-base md:text-lg leading-relaxed max-w-xl mb-10 reveal">
                    Kami menghubungkan instansi pemerintah dan swasta dengan mitra penyedia barang &amp; jasa TKDN terverifikasi, sesuai regulasi pengadaan nasional.
                </p>

                {{-- CTAs --}}
                <div class="flex items-center gap-4 mb-10 reveal">
                    <a href="#"
                    class="inline-flex items-center bg-white text-gray-900 text-sm font-bold px-7 py-3.5 rounded-full hover:bg-red-600 hover:text-white transition-colors shadow-xl">
                        Konsultasi Gratis
                    </a>
                    <a href="{{ route('produk') }}"
                    class="inline-flex items-center gap-2 text-white text-sm font-semibold border border-white/40 px-7 py-3.5 rounded-full hover:bg-white/10 transition-colors backdrop-blur-sm">
                        <span>Lihat Katalog</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                {{-- Stats Row --}}
                <div class="flex items-center gap-8 reveal">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <img class="w-8 h-8 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=64&auto=format&fit=crop&q=80" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=64&auto=format&fit=crop&q=80" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=64&auto=format&fit=crop&q=80" alt="">
                        </div>
                        <div class="text-left">
                            <p class="text-white font-extrabold text-sm leading-none">500+</p>
                            <p class="text-white/60 text-xs mt-0.5">Instansi Terlayani</p>
                        </div>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div class="text-left">
                        <p class="text-white font-extrabold text-sm leading-none">6 Kategori</p>
                        <p class="text-white/60 text-xs mt-0.5">Produk Pengadaan</p>
                    </div>
                    <div class="w-px h-8 bg-white/20"></div>
                    <div class="text-left">
                        <p class="text-white font-extrabold text-sm leading-none">100% TKDN</p>
                        <p class="text-white/60 text-xs mt-0.5">Bersertifikat Resmi</p>
                    </div>
                </div>

                {{-- Slide Dots --}}
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                    <template x-for="(s, i) in slides" :key="i">
                        <button @click="current = i"
                                :class="current === i ? 'bg-white w-6' : 'bg-white/40 w-2'"
                                class="h-2 rounded-full transition-all duration-300">
                        </button>
                    </template>
                </div>

            </div>

        </section>
        
        
        
        
        
        
        
        
    
    @elseif($shortcode->hero_style == 'Style 3')
    
        
    
    @endif
@endif