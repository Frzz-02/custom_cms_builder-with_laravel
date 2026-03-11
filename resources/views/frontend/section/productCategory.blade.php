@if ($shortcode->type == 'product category')
    @if ($shortcode->product_category_style == 'style 1')

        <section class="w-full px-8 md:px-16 py-10 bg-white">

            {{-- Product Cards Slider --}}
            <div class="relative"
                x-data="{
                    current: 0,
                    total: 6,
                    visible: 3,
                    get max() { return this.total - this.visible },
                    prev() { if (this.current > 0) this.current-- },
                    next() { if (this.current < this.max) this.current++ }
                }"
                x-init="visible = window.innerWidth < 768 ? 2 : 3">

                {{-- Prev Arrow --}}
                <button @click="prev()"
                        :class="current === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-red-100'"
                        class="absolute -left-5 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-gray-200 shadow-sm flex items-center justify-center transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- Track --}}
                <div class="overflow-hidden">
                    <div class="flex gap-4 transition-transform duration-500 ease-in-out"
                        :style="`transform: translateX(calc(-${current} * (100% / ${visible} + ${16/visible}px)))`">

                        {{-- Card 1 – ATK --}}
                        <a href="{{ route('produk') }}"
                        class="card-hover relative overflow-hidden h-60 md:h-72 cursor-pointer block shrink-0 flex-none"
                        :style="`width: calc(100% / ${visible} - ${(visible-1)*16/visible}px)`"
                        style="background: linear-gradient(135deg, #F5C842 0%, #F5A623 100%);">
                            <img src="{{ asset('images/alattuliskantor.jpg') }}"
                                alt="ATK" class="absolute inset-0 w-full h-full object-contain mix-blend-multiply opacity-80">
                            <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/70 to-transparent">
                                <span class="inline-block bg-white/20 backdrop-blur-sm text-white text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full mb-1.5">Kategori</span>
                                <p class="text-white font-bold text-base leading-snug">Alat Tulis &amp; Kantor</p>
                            </div>
                        </a>

                        {{-- Card 2 – Alat Kebersihan --}}
                        <a href="{{ route('produk') }}"
                        class="card-hover relative overflow-hidden h-60 md:h-72 cursor-pointer block shrink-0 flex-none"
                        :style="`width: calc(100% / ${visible} - ${(visible-1)*16/visible}px)`"
                        style="background: linear-gradient(135deg, #4FC3F7 0%, #0288D1 100%);">
                            <img src="{{ asset('images/alatkebersihan.jpg') }}"
                                alt="Alat Kebersihan" class="absolute inset-0 w-full h-full object-contain mix-blend-multiply opacity-75">
                            <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/70 to-transparent">
                                <span class="inline-block bg-white/20 backdrop-blur-sm text-white text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full mb-1.5">Kategori</span>
                                <p class="text-white font-bold text-base leading-snug">Alat Kebersihan</p>
                            </div>
                        </a>

                        {{-- Card 3 – Alat Kesehatan --}}
                        <a href="{{ route('produk') }}"
                        class="card-hover relative overflow-hidden h-60 md:h-72 cursor-pointer block shrink-0 flex-none"
                        :style="`width: calc(100% / ${visible} - ${(visible-1)*16/visible}px)`"
                        style="background: linear-gradient(135deg, #81C784 0%, #2E7D32 100%);">
                            <img src="{{ asset('images/alatkesehatan.jpg') }}"
                                alt="Alat Kesehatan" class="absolute inset-0 w-full h-full object-contain mix-blend-multiply opacity-75">
                            <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/70 to-transparent">
                                <span class="inline-block bg-white/20 backdrop-blur-sm text-white text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full mb-1.5">Kategori</span>
                                <p class="text-white font-bold text-base leading-snug">Alat Kesehatan</p>
                            </div>
                        </a>

                        {{-- Card 4 – Home Appliances --}}
                        <a href="{{ route('produk') }}"
                        class="card-hover relative overflow-hidden h-60 md:h-72 cursor-pointer block shrink-0 flex-none"
                        :style="`width: calc(100% / ${visible} - ${(visible-1)*16/visible}px)`"
                        style="background: linear-gradient(135deg, #CE93D8 0%, #7B1FA2 100%);">
                            <img src="{{ asset('images/homeappliances.jpg') }}"
                                alt="Home Appliances" class="absolute inset-0 w-full h-full object-contain mix-blend-multiply opacity-75">
                            <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/70 to-transparent">
                                <span class="inline-block bg-white/20 backdrop-blur-sm text-white text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full mb-1.5">Kategori</span>
                                <p class="text-white font-bold text-base leading-snug">Home Appliances</p>
                            </div>
                        </a>

                        {{-- Card 5 – Furniture --}}
                        <a href="{{ route('produk') }}"
                        class="card-hover relative overflow-hidden h-60 md:h-72 cursor-pointer block shrink-0 flex-none"
                        :style="`width: calc(100% / ${visible} - ${(visible-1)*16/visible}px)`"
                        style="background: linear-gradient(135deg, #BCAAA4 0%, #5D4037 100%);">
                            <img src="{{ asset('images/meja.jpg') }}"
                                alt="Furniture" class="absolute inset-0 w-full h-full object-contain mix-blend-multiply opacity-75">
                            <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/70 to-transparent">
                                <span class="inline-block bg-white/20 backdrop-blur-sm text-white text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full mb-1.5">Kategori</span>
                                <p class="text-white font-bold text-base leading-snug">Furniture</p>
                            </div>
                        </a>

                        {{-- Card 6 – IT Hardware & Software --}}
                        <a href="{{ route('produk') }}"
                        class="card-hover relative overflow-hidden h-60 md:h-72 cursor-pointer block shrink-0 flex-none"
                        :style="`width: calc(100% / ${visible} - ${(visible-1)*16/visible}px)`"
                        style="background: linear-gradient(135deg, #78909C 0%, #263238 100%);">
                            <img src="{{ asset('images/pc.jpg') }}"
                                alt="IT Hardware & Software" class="absolute inset-0 w-full h-full object-contain mix-blend-multiply opacity-75">
                            <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/70 to-transparent">
                                <span class="inline-block bg-white/20 backdrop-blur-sm text-white text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full mb-1.5">Kategori</span>
                                <p class="text-white font-bold text-base leading-snug">IT Hardware &amp; Software</p>
                            </div>
                        </a>

                    </div>
                </div>

                {{-- Next Arrow --}}
                <button @click="next()"
                        :class="current >= max ? 'opacity-30 cursor-not-allowed' : 'hover:bg-red-100'"
                        class="absolute -right-5 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full bg-white border border-gray-200 shadow-sm flex items-center justify-center transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- Dot Indicators --}}
                <div class="flex justify-center gap-2 mt-6">
                    @for($d = 0; $d < 4; $d++)
                    <button @click="current = {{ $d }}"
                            :class="current === {{ $d }} ? 'bg-gray-900 w-5' : 'bg-gray-300 w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    @endfor
                </div>

            </div>

            {{-- Featured Bar --}}
            <div class="flex items-center justify-between mt-6 pb-2 border-t border-gray-100 pt-5">
                <p class="text-sm text-gray-400 font-medium">Kategori Produk</p>
                <a href="{{ route('produk') }}"
                class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center hover:border-gray-400 hover:bg-red-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

        </section>

        
        
        
        
        
    @elseif($shortcode->product_category_style == 'style 2')
    
        <!-- kategori -->
        <section class="py-20 bg-[#f8f8f8] max-md:py-14" id="categories">
            <div class="container">
                <div class="reveal text-center mb-12 max-md:mb-8">
                    <div class="inline-block bg-[rgba(230,57,70,0.07)] text-[#e63946] text-[11px] font-bold tracking-[0.08em] uppercase py-[5px] px-[14px] rounded-[980px] mb-3">Kategori</div>
                    <h2 class="text-[clamp(1.8rem,3vw,2.6rem)] font-extrabold tracking-[-0.03em] text-[#111] mb-[10px] max-md:text-[clamp(1.5rem,6vw,2rem)]">Temukan sesuai kebutuhan.</h2>
                    <p class="text-[15px] text-[#888] max-w-[520px] mx-auto leading-[1.6]">Pilih dari berbagai kategori produk kantor yang lengkap dan terpercaya.</p>
                </div>

                <div class="grid grid-cols-3 gap-4 max-[900px]:grid-cols-2 max-md:gap-3 max-[500px]:grid-cols-1">
                    <div class="group reveal reveal-d1 rounded-[24px] overflow-hidden min-h-[320px] flex flex-col relative cursor-pointer transition-[transform,box-shadow] duration-[350ms] ease-[cubic-bezier(.4,0,.2,1)] shadow-[0_4px_20px_rgba(0,0,0,0.10)] bg-gradient-to-br from-[#e63946] to-[#c1121f] text-white hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_24px_56px_rgba(0,0,0,0.18)] max-md:min-h-[220px] max-md:rounded-[18px] max-[480px]:min-h-[200px]">
                        <div class="absolute inset-0 z-[1]">
                            <img class="w-full h-full object-contain object-bottom px-4 pt-6 pb-0 drop-shadow-[0_-4px_24px_rgba(0,0,0,0.15)] transition-transform duration-500 ease-[cubic-bezier(.4,0,.2,1)] group-hover:scale-[1.08] group-hover:-translate-y-[6px]" src="{{ asset('img/kategori/atk-removebg-preview.png') }}" alt="ATK">
                        </div>
                        <div class="relative z-[2] mt-auto px-[22px] pb-[22px] pt-20 bg-gradient-to-t from-[rgba(0,0,0,0.55)] to-transparent">
                            <div class="text-[10px] font-bold tracking-[0.1em] uppercase opacity-85 mb-1">Perlengkapan Kantor</div>
                            <div class="text-[clamp(1.1rem,1.8vw,1.4rem)] font-extrabold tracking-[-0.02em] leading-[1.2] mb-3 max-md:text-[1rem]">Alat Tulis<br>Kantor</div>
                            <a href="/peralatan-kantor" class="inline-flex items-center gap-[6px] bg-[rgba(255,255,255,0.22)] backdrop-blur-[8px] border border-[rgba(255,255,255,0.35)] text-white text-[11px] font-semibold py-[6px] px-[14px] rounded-[980px] w-fit transition-colors duration-200 hover:bg-[rgba(255,255,255,0.42)]">Browse ›</a>
                        </div>
                    </div>

                    <div class="group reveal reveal-d2 rounded-[24px] overflow-hidden min-h-[320px] flex flex-col relative cursor-pointer transition-[transform,box-shadow] duration-[350ms] ease-[cubic-bezier(.4,0,.2,1)] shadow-[0_4px_20px_rgba(0,0,0,0.10)] bg-gradient-to-br from-[#ffbe0b] to-[#fb5607] text-white hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_24px_56px_rgba(0,0,0,0.18)] max-md:min-h-[220px] max-md:rounded-[18px] max-[480px]:min-h-[200px]">
                        <div class="absolute inset-0 z-[1]">
                            <img class="w-full h-full object-contain object-bottom px-4 pt-6 pb-0 drop-shadow-[0_-4px_24px_rgba(0,0,0,0.15)] transition-transform duration-500 ease-[cubic-bezier(.4,0,.2,1)] group-hover:scale-[1.08] group-hover:-translate-y-[6px]" src="{{ asset('img/kategori/Alat_Kebersihan-removebg-preview.png') }}" alt="Kebersihan">
                        </div>
                        <div class="relative z-[2] mt-auto px-[22px] pb-[22px] pt-20 bg-gradient-to-t from-[rgba(0,0,0,0.55)] to-transparent">
                            <div class="text-[10px] font-bold tracking-[0.1em] uppercase opacity-85 mb-1">Kebersihan</div>
                            <div class="text-[clamp(1.1rem,1.8vw,1.4rem)] font-extrabold tracking-[-0.02em] leading-[1.2] mb-3 max-md:text-[1rem]">Alat<br>Kebersihan</div>
                            <a href="/peralatan-kantor" class="inline-flex items-center gap-[6px] bg-[rgba(255,255,255,0.22)] backdrop-blur-[8px] border border-[rgba(255,255,255,0.35)] text-white text-[11px] font-semibold py-[6px] px-[14px] rounded-[980px] w-fit transition-colors duration-200 hover:bg-[rgba(255,255,255,0.42)]">Browse ›</a>
                        </div>
                    </div>

                    <div class="group reveal reveal-d3 rounded-[24px] overflow-hidden min-h-[320px] flex flex-col relative cursor-pointer transition-[transform,box-shadow] duration-[350ms] ease-[cubic-bezier(.4,0,.2,1)] shadow-[0_4px_20px_rgba(0,0,0,0.10)] bg-gradient-to-br from-[#3a86ff] to-[#0043ce] text-white hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_24px_56px_rgba(0,0,0,0.18)] max-md:min-h-[220px] max-md:rounded-[18px] max-[480px]:min-h-[200px]">
                        <div class="absolute inset-0 z-[1]">
                            <img class="w-full h-full object-contain object-bottom px-4 pt-6 pb-0 drop-shadow-[0_-4px_24px_rgba(0,0,0,0.15)] transition-transform duration-500 ease-[cubic-bezier(.4,0,.2,1)] group-hover:scale-[1.08] group-hover:-translate-y-[6px]" src="{{ asset('img/kategori/Alat_Kesehatan-removebg-preview.png') }}" alt="Kesehatan">
                        </div>
                        <div class="relative z-[2] mt-auto px-[22px] pb-[22px] pt-20 bg-gradient-to-t from-[rgba(0,0,0,0.55)] to-transparent">
                            <div class="text-[10px] font-bold tracking-[0.1em] uppercase opacity-85 mb-1">Kesehatan</div>
                            <div class="text-[clamp(1.1rem,1.8vw,1.4rem)] font-extrabold tracking-[-0.02em] leading-[1.2] mb-3 max-md:text-[1rem]">Alat<br>Kesehatan</div>
                            <a href="/peralatan-kantor" class="inline-flex items-center gap-[6px] bg-[rgba(255,255,255,0.22)] backdrop-blur-[8px] border border-[rgba(255,255,255,0.35)] text-white text-[11px] font-semibold py-[6px] px-[14px] rounded-[980px] w-fit transition-colors duration-200 hover:bg-[rgba(255,255,255,0.42)]">Browse ›</a>
                        </div>
                    </div>

                    <div class="group reveal reveal-d4 rounded-[24px] overflow-hidden min-h-[320px] flex flex-col relative cursor-pointer transition-[transform,box-shadow] duration-[350ms] ease-[cubic-bezier(.4,0,.2,1)] shadow-[0_4px_20px_rgba(0,0,0,0.10)] bg-gradient-to-br from-[#4cc9f0] to-[#4361ee] text-white hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_24px_56px_rgba(0,0,0,0.18)] max-md:min-h-[220px] max-md:rounded-[18px] max-[480px]:min-h-[200px]">
                        <div class="absolute inset-0 z-[1]">
                            <img class="w-full h-full object-contain object-bottom px-4 pt-6 pb-0 drop-shadow-[0_-4px_24px_rgba(0,0,0,0.15)] transition-transform duration-500 ease-[cubic-bezier(.4,0,.2,1)] group-hover:scale-[1.08] group-hover:-translate-y-[6px]" src="{{ asset('img/kategori/Home_-removebg-preview.png') }}" alt="Home Appliances">
                        </div>
                        <div class="relative z-[2] mt-auto px-[22px] pb-[22px] pt-20 bg-gradient-to-t from-[rgba(0,0,0,0.55)] to-transparent">
                            <div class="text-[10px] font-bold tracking-[0.1em] uppercase opacity-85 mb-1">Peralatan Rumah</div>
                            <div class="text-[clamp(1.1rem,1.8vw,1.4rem)] font-extrabold tracking-[-0.02em] leading-[1.2] mb-3 max-md:text-[1rem]">Home<br>Appliances</div>
                            <a href="/peralatan-kantor" class="inline-flex items-center gap-[6px] bg-[rgba(255,255,255,0.22)] backdrop-blur-[8px] border border-[rgba(255,255,255,0.35)] text-white text-[11px] font-semibold py-[6px] px-[14px] rounded-[980px] w-fit transition-colors duration-200 hover:bg-[rgba(255,255,255,0.42)]">Browse ›</a>
                        </div>
                    </div>

                    <div class="group reveal reveal-d5 rounded-[24px] overflow-hidden min-h-[320px] flex flex-col relative cursor-pointer transition-[transform,box-shadow] duration-[350ms] ease-[cubic-bezier(.4,0,.2,1)] shadow-[0_4px_20px_rgba(0,0,0,0.10)] bg-gradient-to-br from-[#2b2d42] to-[#1a1a2e] text-white hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_24px_56px_rgba(0,0,0,0.18)] max-md:min-h-[220px] max-md:rounded-[18px] max-[480px]:min-h-[200px]">
                        <div class="absolute inset-0 z-[1]">
                            <img class="w-full h-full object-contain object-bottom px-4 pt-6 pb-0 drop-shadow-[0_-4px_24px_rgba(0,0,0,0.15)] transition-transform duration-500 ease-[cubic-bezier(.4,0,.2,1)] group-hover:scale-[1.08] group-hover:-translate-y-[6px]" src="{{ asset('img/kategori/roombooking-removebg-preview.png') }}" alt="Furniture">
                        </div>
                        <div class="relative z-[2] mt-auto px-[22px] pb-[22px] pt-20 bg-gradient-to-t from-[rgba(0,0,0,0.55)] to-transparent">
                            <div class="text-[10px] font-bold tracking-[0.1em] uppercase opacity-85 mb-1">Interior Kantor</div>
                            <div class="text-[clamp(1.1rem,1.8vw,1.4rem)] font-extrabold tracking-[-0.02em] leading-[1.2] mb-3 max-md:text-[1rem]">Furniture<br>Kantor</div>
                            <a href="/peralatan-kantor" class="inline-flex items-center gap-[6px] bg-[rgba(255,255,255,0.22)] backdrop-blur-[8px] border border-[rgba(255,255,255,0.35)] text-white text-[11px] font-semibold py-[6px] px-[14px] rounded-[980px] w-fit transition-colors duration-200 hover:bg-[rgba(255,255,255,0.42)]">Browse ›</a>
                        </div>
                    </div>

                    <div class="group reveal reveal-d6 rounded-[24px] overflow-hidden min-h-[320px] flex flex-col relative cursor-pointer transition-[transform,box-shadow] duration-[350ms] ease-[cubic-bezier(.4,0,.2,1)] shadow-[0_4px_20px_rgba(0,0,0,0.10)] bg-gradient-to-br from-[#7b2d8b] to-[#560bad] text-white hover:-translate-y-2 hover:scale-[1.01] hover:shadow-[0_24px_56px_rgba(0,0,0,0.18)] max-md:min-h-[220px] max-md:rounded-[18px] max-[480px]:min-h-[200px]">
                        <div class="absolute inset-0 z-[1]">
                            <img class="w-full h-full object-contain object-bottom px-4 pt-6 pb-0 drop-shadow-[0_-4px_24px_rgba(0,0,0,0.15)] transition-transform duration-500 ease-[cubic-bezier(.4,0,.2,1)] group-hover:scale-[1.08] group-hover:-translate-y-[6px]" src="{{ asset('img/kategori/IT_Hardware-removebg-preview.png') }}" alt="IT Hardware">
                        </div>
                        <div class="relative z-[2] mt-auto px-[22px] pb-[22px] pt-20 bg-gradient-to-t from-[rgba(0,0,0,0.55)] to-transparent">
                            <div class="text-[10px] font-bold tracking-[0.1em] uppercase opacity-85 mb-1">Teknologi</div>
                            <div class="text-[clamp(1.1rem,1.8vw,1.4rem)] font-extrabold tracking-[-0.02em] leading-[1.2] mb-3 max-md:text-[1rem]">IT Hardware<br>&amp; Software</div>
                            <a href="/peralatan-kantor" class="inline-flex items-center gap-[6px] bg-[rgba(255,255,255,0.22)] backdrop-blur-[8px] border border-[rgba(255,255,255,0.35)] text-white text-[11px] font-semibold py-[6px] px-[14px] rounded-[980px] w-fit transition-colors duration-200 hover:bg-[rgba(255,255,255,0.42)]">Browse ›</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        
        
        
        
        
    
    @endif
@endif