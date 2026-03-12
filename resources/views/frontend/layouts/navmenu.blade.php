
{{-- style 1 --}}
@if ($page->header_style = 'header style 1')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/style/section/hero/style1.css') }}">
    @endpush
    <nav x-data="{ sidebarOpen: false, searchOpen: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
        :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-lg border-transparent' : 'bg-white border-gray-200'"
        class="fixed w-full top-0 z-[9999] border-b transition-all duration-300"
        id="main-navbar">
        <div class="w-full max-w-[1920px] mx-auto px-3 sm:px-10 lg:px-16 xl:px-24">
            <div class="flex justify-between items-center h-14 sm:h-20">

                <!-- Left Side - Hamburger & Lanyard Shop Button -->
                <div class="flex items-center space-x-4">
                    <!-- Hamburger Menu Button -->
                    <button type="button" @click="sidebarOpen = true" class="border border-gray-300 p-2 sm:p-3 hover:bg-red-50 hover:border-red-600 transition-colors focus:outline-none">
                        <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Lanyard Shop Button - Hidden on Mobile -->
                    <a href="#" class="hidden md:inline-block border border-gray-900 px-6 py-3 text-sm font-medium tracking-wider hover:bg-red-600 hover:border-red-600 hover:text-white transition-colors">
                        MITRA SHOP
                    </a>
                </div>

                <!-- Center - Logo -->
                <div class="absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0 flex-shrink-0">
                    <a href="#" class="flex items-center group">
                        <img src="{{ asset('assets/images/logo/mitjogja1.png') }}"
                            alt="MitraJogja Logo"
                            class="h-8 sm:h-12 md:h-16 w-auto object-contain">
                    </a>
                </div>

                <!-- Right Side - Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#"
                    class="text-sm font-medium tracking-wider text-gray-700 hover:text-red-600 transition-colors {{ request()->routeIs('home') ? 'text-gray-900 font-semibold' : '' }}">
                        HOME
                    </a>
                    <button @click="searchOpen = !searchOpen" class="flex items-center text-sm font-medium tracking-wider text-gray-700 hover:text-red-600 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span x-text="searchOpen ? 'CLOSE' : 'SEARCH'"></span>
                    </button>
                    <a href="#"
                    class="text-sm font-medium tracking-wider text-gray-700 hover:text-red-600 transition-colors {{ request()->routeIs('kontak') ? 'text-gray-900 font-semibold' : '' }}">
                        CONTACT
                    </a>
                </div>

                <!-- Mobile Right Menu -->
                <div class="flex md:hidden items-center space-x-4">
                    <button @click="searchOpen = !searchOpen" class="text-gray-700 hover:text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Search Popup -->
        <div x-show="searchOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="absolute top-full left-0 right-0 bg-white border-b border-gray-200 shadow-lg py-5 sm:py-12">
            <div class="max-w-2xl mx-auto px-4">
                <form action="#" method="GET" class="flex items-center border-b-2 border-gray-300 focus-within:border-gray-900 transition-colors">
                    <input type="text"
                        name="search"
                        placeholder="Cari produk..."
                        class="flex-1 py-2 sm:py-4 text-base sm:text-xl outline-none bg-transparent placeholder-gray-400"
                        x-ref="searchInput"
                        @keydown.escape="searchOpen = false"
                        x-init="$watch('searchOpen', value => { if(value) setTimeout(() => $refs.searchInput.focus(), 100) })">
                    <button type="submit" class="text-sm font-medium tracking-wider text-gray-600 hover:text-gray-900 px-4">
                        CARI
                    </button>
                </form>
                <p class="mt-4 text-sm text-gray-500 text-center">Tekan Enter untuk mencari atau Escape untuk menutup</p>
            </div>
        </div>

        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen"
            x-cloak
            data-sidebar-overlay
            @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            style="position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.3);z-index:2147483640;">
        </div>

        <!-- Sidebar -->
        <div x-show="sidebarOpen"
            x-cloak
            data-sidebar
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            style="position:fixed;top:0;left:0;width:320px;height:100%;background:#f3f4f6;z-index:2147483645;overflow-y:auto;">

            <!-- Sidebar Header -->
            <div class="p-6 border-b border-gray-200 bg-white">
                <div class="flex items-center space-x-4">
                    <!-- Close Button -->
                    <button type="button" @click="sidebarOpen = false" class="border border-gray-300 p-3 hover:bg-gray-50 transition-colors focus:outline-none">
                        <svg class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Lanyard Shop Button -->
                    <a href="#" class="border border-gray-900 px-6 py-3 text-sm font-medium tracking-wider hover:bg-gray-900 hover:text-white transition-colors">
                        Mitracom Shop
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="p-6 space-y-1">
                <a href="#" class="block py-3 text-gray-700 hover:text-gray-900 transition-colors text-base tracking-wider {{ request()->routeIs('home') ? 'text-gray-900 font-semibold' : '' }}">
                    HOME
                </a>
                <a href="#" class="block py-3 text-gray-700 hover:text-gray-900 transition-colors text-base tracking-wider {{ request()->routeIs('produk.index') ? 'text-gray-900 font-semibold' : '' }}">
                    PRODUK
                </a>
                <a href="#" class="block py-3 text-gray-700 hover:text-gray-900 transition-colors text-base tracking-wider {{ request()->routeIs('testimoni') ? 'text-gray-900 font-semibold' : '' }}">
                    TESTIMONI
                </a>
                <a href="#" class="block py-3 text-gray-700 hover:text-gray-900 transition-colors text-base tracking-wider {{ request()->routeIs('portfolio') ? 'text-gray-900 font-semibold' : '' }}">
                    PORTOFOLIO
                </a>
                <a href="#" class="block py-3 text-gray-700 hover:text-gray-900 transition-colors text-base tracking-wider {{ request()->routeIs('blog') ? 'text-gray-900 font-semibold' : '' }}">
                    BLOG
                </a>
                <a href="#" class="block py-3 text-gray-700 hover:text-gray-900 transition-colors text-base tracking-wider {{ request()->routeIs('kontak') ? 'text-gray-900 font-semibold' : '' }}">
                    KONTAK
                </a>
            </div>
        </div>
    </nav>
    

    


{{-- style 2 --}}
@elseif ($page->header_style = 'header style 2')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/style/section/navmenu/style2.css') }}">
    @endpush

    <nav
        x-data="{
            scrolled: false,
            isHome: {{ request()->routeIs('home') ? 'true' : 'false' }},
            init() {
                this.scrolled = window.scrollY > 60;
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 60;
                }, { passive: true });
            }
        }"
        :class="(!isHome || scrolled)
            ? 'bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm py-4'
            : 'bg-transparent border-b
            border-transparent py-5'"
        class="w-full px-8 md:px-16 flex items-center justify-between fixed top-0 left-0 right-0 z-50 transition-all duration-300">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('assets/images/logo/malangmitra.png') }}" alt="Mitra Malang"
                :class="(!isHome || scrolled) ? '' : 'brightness-0 invert'"
                class="h-12 w-auto object-contain transition-all duration-300">
        </a>

        {{-- Nav Links (Desktop) --}}
        <ul class="hidden md:flex items-center gap-8">
            <li>
                <a href="{{ route('home') }}"
                :class="(!isHome || scrolled) ? '{{ request()->routeIs('home') ? 'text-gray-900' : 'text-gray-500 hover:text-red-600' }}' : 'text-white/90 hover:text-white'"
                class="nav-link text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'active' : '' }}">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('produk') }}"
                :class="(!isHome || scrolled) ? '{{ request()->routeIs('produk') ? 'text-gray-900' : 'text-gray-500 hover:text-red-600' }}' : 'text-white/90 hover:text-white'"
                class="nav-link text-sm font-medium transition-colors {{ request()->routeIs('produk') ? 'active' : '' }}">
                    Produk
                </a>
            </li>
            <li>
                <a href="{{ route('testimonial') }}"
                :class="(!isHome || scrolled) ? '{{ request()->routeIs('testimonial') ? 'text-gray-900' : 'text-gray-500 hover:text-red-600' }}' : 'text-white/90 hover:text-white'"
                class="nav-link text-sm font-medium transition-colors {{ request()->routeIs('testimonial') ? 'active' : '' }}">
                    Testimonial
                </a>
            </li>
            <li>
                <a href="{{ route('blog') }}"
                :class="(!isHome || scrolled) ? '{{ request()->routeIs('blog') ? 'text-gray-900' : 'text-gray-500 hover:text-red-600' }}' : 'text-white/90 hover:text-white'"
                class="nav-link text-sm font-medium transition-colors {{ request()->routeIs('blog') ? 'active' : '' }}">
                    Blog
                </a>
            </li>
        </ul>

        {{-- Right Actions --}}
        <div class="flex items-center gap-4">
                {{-- Search --}}
                <button
                    :class="(!isHome || scrolled) ? 'text-gray-500 hover:text-red-600' : 'text-white/80 hover:text-white'"
                    class="p-2 transition-colors" aria-label="Cari">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </button>

                {{-- CTA --}}
                <a href="#"
                :class="(!isHome || scrolled)
                    ? 'bg-gray-900 text-white hover:bg-red-600'
                    : 'bg-white/10 backdrop-blur-sm border border-white/30 text-white hover:bg-white/20'"
                class="hidden md:inline-flex items-center text-sm font-semibold px-5 py-2.5 rounded-full transition-all duration-300">
                    Hubungi Kami
                </a>

                {{-- Mobile Hamburger --}}
                <button id="mobile-menu-btn"
                        :class="(!isHome || scrolled) ? 'text-gray-500 hover:text-red-600' : 'text-white/80 hover:text-white'"
                        class="md:hidden p-2 transition-colors"
                        aria-label="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-gray-100 px-8 py-4">
        <ul class="flex flex-col gap-4">
            <li><a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-red-600">Home</a></li>
            <li><a href="{{ route('produk') }}" class="text-sm font-medium text-gray-700 hover:text-red-600">Produk</a></li>
            <li><a href="#" class="text-sm font-medium text-gray-700 hover:text-red-600">Tentang Kami</a></li>
            <li><a href="{{ route('testimonial') }}" class="text-sm font-medium text-gray-700 hover:text-red-600">Testimonial</a></li>
            <li><a href="{{ route('blog') }}" class="text-sm font-medium text-gray-700 hover:text-red-600">Blog</a></li>
            <li><a href="#" class="inline-flex bg-gray-900 text-white text-sm font-semibold px-5 py-2.5 rounded-full w-fit">Hubungi Kami</a></li>
        </ul>
    </div>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    </script>







{{-- style 3 --}}
@elseif ($page->header_style = 'header style 3')


    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/style/section/navmenu/style3.css') }}">
    @endpush


    <!-- navbar -->
    <div class="fixed inset-x-0 top-0 z-[9999] pt-[18px] px-6 flex flex-col items-center pointer-events-none gap-2" id="navbarWrap">
        <nav class="pointer-events-auto flex items-center bg-[rgba(255,255,255,0.88)] backdrop-saturate-[200%] backdrop-blur-[24px] border border-[rgba(0,0,0,0.08)] rounded-[980px] p-[6px] h-[52px] max-w-[860px] w-full gap-1 transition-shadow duration-300 shadow-[0_4px_24px_rgba(0,0,0,0.08)]" id="navbar">
            <ul class="navbar-left-links">
                <li><a href="#hero" class="active">Home</a></li>
                <li><a href="#categories">Kategori</a></li>
                <li><a href="#products">Produk</a></li>
            </ul>

            <a href="/" class="px-4 shrink-0 flex items-center">
                <img src="{{ asset('assets/images/logo/mitraoke-removebg-preview.png') }}" alt="MitraOke" class="h-[52px] w-auto block object-contain max-[480px]:h-[38px]">
            </a>

            <ul class="navbar-right-links">
                <li><a href="#blog">Blog</a></li>
                <li><a href="#reviews">Testimoni</a></li>
                <li><a href="#about">Tentang</a></li>
            </ul>

            <a href="https://wa.me/6281252141397" class="inline-flex items-center bg-[#e63946] text-white text-[12px] font-bold py-2 px-5 rounded-[980px] transition-[background,transform] duration-200 whitespace-nowrap shrink-0 ml-1 hover:bg-[rgba(193,18,31,0.65)] hover:scale-[1.03]" target="_blank">Hubungi Kami</a>

            <button class="nav-hamburger" id="navHamburger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </nav>

        <!-- pilih cabang kota -->
        <div class="flex gap-2 items-center pointer-events-auto pb-[10px]">
            <div class="city-item" id="cityItemJogja">
                <button class="inline-flex items-center gap-[5px] py-[5px] px-[10px] bg-[rgba(230,57,70,0.07)] border-[1.5px] border-[rgba(230,57,70,0.2)] rounded-[980px] cursor-pointer font-[Montserrat,sans-serif] text-[12px] font-semibold text-[#e63946] leading-none transition-[background,border-color] duration-150 whitespace-nowrap hover:bg-[rgba(230,57,70,0.12)]" onclick="toggleCity(event,this)">
                    📍 Yogyakarta
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="city-card">
                    <div class="p-3 pb-[10px] flex items-center gap-[9px]">
                        <img src="{{ asset('img/logo/jogja.jpeg') }}" alt="Jogja" class="w-[30px] h-[30px] object-contain rounded-[4px] shrink-0 block">
                        <div>
                            <div class="text-[13px] font-bold text-[#202124] leading-[1.2]">Cabang Yogyakarta</div>
                            <span class="text-[11px] text-[#9aa0a6] block mt-[1px]">Mitra Oke</span>
                        </div>
                    </div>
                    <div class="h-px bg-[#f1f3f4]"></div>
                    <div class="flex justify-end py-1 px-[6px] gap-0.5">
                        <button class="py-[6px] px-2 bg-transparent text-[#5f6368] border-none text-[12px] font-semibold cursor-pointer rounded-[4px] font-[Montserrat,sans-serif] transition-colors duration-100 hover:bg-[#f1f3f4]" onclick="closeCity(event)">Batal</button>
                        <a href="{{ route('cabang.jogja') }}" class="py-[6px] px-2 bg-transparent text-[#1a73e8] border-none text-[12px] font-bold cursor-pointer rounded-[4px] font-[Montserrat,sans-serif] transition-colors duration-100 hover:bg-[#e8f0fe] inline-block no-underline">Kunjungi →</a>
                    </div>
                </div>
            </div>

            <div class="city-item" id="cityItemMalang">
                <button class="inline-flex items-center gap-[5px] py-[5px] px-[10px] bg-[rgba(230,57,70,0.07)] border-[1.5px] border-[rgba(230,57,70,0.2)] rounded-[980px] cursor-pointer font-[Montserrat,sans-serif] text-[12px] font-semibold text-[#e63946] leading-none transition-[background,border-color] duration-150 whitespace-nowrap hover:bg-[rgba(230,57,70,0.12)]" onclick="toggleCity(event,this)">
                    📍 Malang
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="city-card">
                    <div class="p-3 pb-[10px] flex items-center gap-[9px]">
                        <img src="{{ asset('img/logo/malang.jpeg') }}" alt="Malang" class="w-[30px] h-[30px] object-contain rounded-[4px] shrink-0 block">
                        <div>
                            <div class="text-[13px] font-bold text-[#202124] leading-[1.2]">Cabang Malang</div>
                            <span class="text-[11px] text-[#9aa0a6] block mt-[1px]">Mitra Oke</span>
                        </div>
                    </div>
                    <div class="h-px bg-[#f1f3f4]"></div>
                    <div class="flex justify-end py-1 px-[6px] gap-0.5">
                        <button class="py-[6px] px-2 bg-transparent text-[#5f6368] border-none text-[12px] font-semibold cursor-pointer rounded-[4px] font-[Montserrat,sans-serif] transition-colors duration-100 hover:bg-[#f1f3f4]" onclick="closeCity(event)">Batal</button>
                        <a href="{{ route('cabang.malang') }}" class="py-[6px] px-2 bg-transparent text-[#1a73e8] border-none text-[12px] font-bold cursor-pointer rounded-[4px] font-[Montserrat,sans-serif] transition-colors duration-100 hover:bg-[#e8f0fe] inline-block no-underline">Kunjungi →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- menu mobile layar penuh -->
    <div class="nav-mobile-menu" id="navMobileMenu">
        <a href="#hero" onclick="closeMobileMenu()">Home</a>
        <a href="#categories" onclick="closeMobileMenu()">Kategori</a>
        <a href="#products" onclick="closeMobileMenu()">Produk</a>
        <a href="#reviews" onclick="closeMobileMenu()">Testimoni</a>
        <a href="#blog" onclick="closeMobileMenu()">Blog</a>
        <a href="#about" onclick="closeMobileMenu()">Tentang</a>
        <a href="https://wa.me/6281252141397" class="nav-mobile-cta" target="_blank">Hubungi Kami</a>
    </div>





@endif







