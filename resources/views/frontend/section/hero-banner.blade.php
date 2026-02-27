
@if ()
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
@endif