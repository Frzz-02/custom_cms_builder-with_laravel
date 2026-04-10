@php
    $navbarMenuItems = collect($navbarItems ?? []);

    $sidebarMenuItems = collect($sidebarItems ?? []);

    $resolveMenuUrl = function ($item) {
        $raw = trim((string) ($item->menu_url ?? ''));

        if ($raw === '' || $raw === '#') {
            return '#';
        }

        if (str_starts_with($raw, '#')) {
            return $raw;
        }

        if (preg_match('/^(https?:|mailto:|tel:)/i', $raw) === 1) {
            return $raw;
        }

        if (str_starts_with($raw, '/')) {
            return url($raw);
        }

        return url('/' . ltrim($raw, '/'));
    };

    $isSearchMenu = function ($item) {
        $slug = strtolower(trim((string) ($item->menu_slug ?? '')));
        $label = strtoupper(trim((string) ($item->menu_label ?? '')));

        return $slug === 'search' || $label === 'SEARCH';
    };

    $isMenuActive = function ($item) {
        $url = (string) ($item->menu_url ?? '');
        $slug = trim((string) ($item->menu_slug ?? ''));

        if ($url === '' || $url === '#') {
            return false;
        }

        if ($url === '/' || $slug === 'home') {
            return request()->routeIs('home') || request()->is('/');
        }

        $path = ltrim((string) (parse_url($url, PHP_URL_PATH) ?: $url), '/');

        if ($path !== '' && (request()->is($path) || request()->is($path . '/*'))) {
            return true;
        }

        return $slug !== '' && (request()->is($slug) || request()->is($slug . '/*'));
    };

    $navbarNonButtonItems = $navbarMenuItems->filter(fn ($item) => !($item->is_button ?? false))->values();
    $sidebarNonButtonItems = $sidebarMenuItems->filter(fn ($item) => !($item->is_button ?? false))->values();

    $searchMenuItem = $navbarNonButtonItems->first($isSearchMenu);
    $style1TopItems = $navbarNonButtonItems;
    $style1SidebarItems = $sidebarNonButtonItems;

    $primaryButtonItem = $navbarMenuItems->first(fn ($item) => (bool) ($item->is_button ?? false));

    $style2TopItems = $navbarNonButtonItems->reject($isSearchMenu)->take(4)->values();

    $style3AllItems = $navbarNonButtonItems
        ->reject($isSearchMenu)
        ->values();

    $style3LeftItems = $style3AllItems->take(3);
    $style3RightItems = $style3AllItems->slice(3, 3);
@endphp

{{-- style 1 --}}
@if (in_array($page->header_style, ['header style 1', 'header style s1']))

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
                    @if ($style1SidebarItems->isNotEmpty())
                        <button type="button" @click="sidebarOpen = true" class="border border-gray-300 p-2 sm:p-3 hover:bg-red-50 hover:border-red-600 transition-colors focus:outline-none">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    @endif

                    <!-- Lanyard Shop Button - Hidden on Mobile -->
                    @if ($primaryButtonItem)
                        <a href="{{ $resolveMenuUrl($primaryButtonItem) }}"
                            @if ($primaryButtonItem->open_new_tab || $primaryButtonItem->is_external) target="_blank" rel="noopener noreferrer" @endif
                            class="hidden md:inline-block border border-gray-900 px-6 py-3 text-sm font-medium tracking-wider hover:bg-red-600 hover:border-red-600 hover:text-white transition-colors">
                            {{ $primaryButtonItem->menu_label }}
                        </a>
                    @endif
                </div>

                <!-- Center - Logo -->
                <div class="absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0 flex-shrink-0">
                    <a href="#" class="flex items-center group">
                        <img src="{{ asset('storage/' . $settings->site_logo ?? '') }}"
                            alt="MitraJogja Logo"
                            class="h-8 sm:h-12 md:h-16 w-auto object-contain">
                    </a>
                </div>

                <!-- Right Side - Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    @foreach ($style1TopItems as $menu)
                        @if ($isSearchMenu($menu))
                            <button @click="searchOpen = !searchOpen" class="flex items-center text-sm font-medium tracking-wider text-gray-700 hover:text-red-600 transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span x-text="searchOpen ? 'CLOSE' : {{ \Illuminate\Support\Js::from(strtoupper($menu->menu_label)) }}"></span>
                            </button>
                        @else
                            <a href="{{ $resolveMenuUrl($menu) }}"
                                @if ($menu->open_new_tab || $menu->is_external) target="_blank" rel="noopener noreferrer" @endif
                                class="text-sm font-medium tracking-wider text-gray-700 hover:text-red-600 transition-colors {{ $isMenuActive($menu) ? 'text-gray-900 font-semibold' : '' }}">
                                {{ strtoupper($menu->menu_label) }}
                            </a>
                        @endif
                    @endforeach
                </div>

                <!-- Mobile Right Menu -->
                @if ($searchMenuItem)
                    <div class="flex md:hidden items-center space-x-4">
                        <button @click="searchOpen = !searchOpen" class="text-gray-700 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </div>
                @endif
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

        @if ($style1SidebarItems->isNotEmpty())
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
                    @if ($primaryButtonItem)
                        <a href="{{ $resolveMenuUrl($primaryButtonItem) }}"
                            @if ($primaryButtonItem->open_new_tab || $primaryButtonItem->is_external) target="_blank" rel="noopener noreferrer" @endif
                            class="border border-gray-900 px-6 py-3 text-sm font-medium tracking-wider hover:bg-gray-900 hover:text-white transition-colors">
                            {{ $primaryButtonItem->menu_label }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="p-6 space-y-1">
                @foreach ($style1SidebarItems as $menu)
                    <a href="{{ $resolveMenuUrl($menu) }}"
                        @if ($menu->open_new_tab || $menu->is_external) target="_blank" rel="noopener noreferrer" @endif
                        class="block py-3 text-gray-700 hover:text-gray-900 transition-colors text-base tracking-wider {{ $isMenuActive($menu) ? 'text-gray-900 font-semibold' : '' }}">
                        {{ strtoupper($menu->menu_label) }}
                    </a>
                @endforeach
            </div>
            </div>
        @endif
    </nav>
    

    


{{-- style 2 --}}
@elseif (in_array($page->header_style, ['header style 2', 'header style s2']))

    @php
        $style2SearchItem = $searchMenuItem;
        $style2CtaItem = $primaryButtonItem;
    @endphp

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/style/section/navmenu/style2.css') }}">
    @endpush

    <nav x-data="{
            scrolled: false,
            isHome: {{ (request()->routeIs('home') || request()->routeIs('mitramalang')) ? 'true' : 'false' }},
            init() {
                this.scrolled = window.scrollY > 60;
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 60;
                }, { passive: true });
            }
        }"
        :class="(!isHome || scrolled)
            ? 'bg-white/95 border border-gray-100 shadow-[0_10px_30px_rgba(15,23,42,0.08)] py-2 mt-2'
            : 'bg-white/75 backdrop-blur-lg border border-white/70 shadow-[0_8px_24px_rgba(15,23,42,0.08)] py-2 mt-3'"
        class="fixed top-0 left-3 right-3 md:left-8 md:right-8 lg:left-16 lg:right-16 z-50 px-3 md:px-5 rounded-4xl flex items-center justify-between transition-all duration-300">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('storage/' . $settings->site_logo ?? '') }}" alt="Mitra Malang"
                class="h-10 md:h-11 w-auto object-contain transition-all duration-300">
        </a>

        {{-- Nav Links (Desktop) --}}
        <ul class="hidden md:flex items-center gap-8">
            @foreach ($style2TopItems as $menu)
                @php $isActiveMenu = $isMenuActive($menu); @endphp
                <li>
                    <a href="{{ $resolveMenuUrl($menu) }}"
                        @if ($menu->open_new_tab || $menu->is_external) target="_blank" rel="noopener noreferrer" @endif
                        :class="'{{ $isActiveMenu ? 'text-gray-900' : 'text-gray-600 hover:text-red-600' }}'"
                        class="nav-link text-sm font-medium transition-colors {{ $isActiveMenu ? 'active' : '' }}">
                        {{ $menu->menu_label }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Right Actions --}}
        <div class="flex items-center gap-4">
                {{-- Search --}}
                @if ($style2SearchItem)
                    <button
                        :class="'text-gray-600 hover:text-red-600'"
                        class="p-2 transition-colors" aria-label="Cari">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </button>
                @endif

                {{-- CTA --}}
                @if ($style2CtaItem)
                    <a href="{{ $resolveMenuUrl($style2CtaItem) }}"
                    @if ($style2CtaItem->open_new_tab || $style2CtaItem->is_external) target="_blank" rel="noopener noreferrer" @endif
                    :class="(!isHome || scrolled)
                        ? 'bg-gray-900 text-white hover:bg-red-600 shadow-sm'
                        : 'bg-red-600 text-white hover:bg-red-700 shadow-[0_8px_20px_rgba(220,38,38,0.25)]'"
                    class="hidden md:inline-flex items-center text-sm font-semibold px-5 py-2.5 rounded-full transition-all duration-300">
                        {{ $style2CtaItem->menu_label }}
                    </a>
                @endif

                {{-- Mobile Hamburger --}}
                <button id="mobile-menu-btn"
                    :class="'text-gray-600 hover:text-red-600'"
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
    <div id="mobile-menu" class="hidden md:hidden fixed left-3 right-3 top-[86px] z-40 bg-white/95 backdrop-blur-md border border-gray-100 rounded-2xl shadow-[0_12px_28px_rgba(15,23,42,0.12)] px-6 py-4">
        <ul class="flex flex-col gap-4">
            @foreach ($style2TopItems as $menu)
                <li>
                    <a href="{{ $resolveMenuUrl($menu) }}"
                        @if ($menu->open_new_tab || $menu->is_external) target="_blank" rel="noopener noreferrer" @endif
                        class="text-sm font-medium text-gray-700 hover:text-red-600">
                        {{ $menu->menu_label }}
                    </a>
                </li>
            @endforeach
            @if ($style2CtaItem)
                <li>
                    <a href="{{ $resolveMenuUrl($style2CtaItem) }}"
                        @if ($style2CtaItem->open_new_tab || $style2CtaItem->is_external) target="_blank" rel="noopener noreferrer" @endif
                        class="inline-flex bg-gray-900 text-white text-sm font-semibold px-5 py-2.5 rounded-full w-fit">
                        {{ $style2CtaItem->menu_label }}
                    </a>
                </li>
            @endif
        </ul>
    </div>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => menu.classList.toggle('hidden'));
    </script>







{{-- style 3 --}}
@elseif (in_array($page->header_style, ['header style 3', 'header style s3']))


    @once
        <link rel="stylesheet" href="{{ asset('assets/style/section/navmenu/style3.css') }}">
        <script defer src="{{ asset('assets/js/section/navmenu/style3.js') }}"></script>
        <style>
            .navmenu-style-3-instance .navbar-left-links,
            .navmenu-style-3-instance .navbar-right-links { display: flex; gap: 2px; align-items: center; list-style: none; margin: 0; padding: 0; }
            .navmenu-style-3-instance .navbar-left-links { flex: 1; }
            .navmenu-style-3-instance .navbar-right-links { flex: 1; justify-content: flex-end; }
            .navmenu-style-3-instance .navbar-left-links li a,
            .navmenu-style-3-instance .navbar-right-links li a { display: block; padding: 7px 14px; font-size: 13px; font-weight: 500; color: #555; border-radius: 999px; white-space: nowrap; text-decoration: none; }
            .navmenu-style-3-instance .nav-mobile-menu { display: none; }
            .navmenu-style-3-instance .nav-mobile-menu.open { display: flex; }
            .navmenu-style-3-instance .city-item { position: relative; }
            .navmenu-style-3-instance .city-card {
                position: absolute; top: calc(100% + 10px); left: 0; min-width: 250px; background: #fff; border: 1px solid #eceff1;
                border-radius: 14px; box-shadow: 0 14px 34px rgba(0, 0, 0, 0.12); opacity: 0; visibility: hidden; transform: translateY(8px);
                pointer-events: none; transition: opacity .18s ease, transform .18s ease, visibility .18s ease; z-index: 20;
            }
            .navmenu-style-3-instance .city-item:last-child .city-card { left: auto; right: 0; }
            .navmenu-style-3-instance .city-item.open .city-card { opacity: 1; visibility: visible; transform: translateY(0); pointer-events: auto; }
        </style>
    @endonce
    
    
    
    <!-- navbar -->
    <div class="navmenu-style-3-instance" data-navmenu-style3>
        <div class="fixed inset-x-0 top-0 z-[9999] pt-[18px] px-6 flex flex-col items-center pointer-events-none gap-2">
            <nav class="nm3-navbar pointer-events-auto flex items-center bg-[rgba(255,255,255,0.88)] backdrop-saturate-[200%] backdrop-blur-[24px] border border-[rgba(0,0,0,0.08)] rounded-[980px] p-[6px] h-[52px] max-w-[860px] w-full gap-1 transition-shadow duration-300 shadow-[0_4px_24px_rgba(0,0,0,0.08)]">
            <ul class="navbar-left-links">
                @foreach ($style3LeftItems as $menu)
                    <li>
                        <a href="{{ $resolveMenuUrl($menu) }}"
                            @if ($menu->open_new_tab || $menu->is_external) target="_blank" rel="noopener noreferrer" @endif
                            class="{{ $isMenuActive($menu) ? 'active' : '' }}">
                            {{ $menu->menu_label }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <a href="/" class="px-4 shrink-0 flex items-center">
                <img src="{{ asset('storage/' . $settings->site_logo ?? '') }}" alt="MitraOke" class="h-[52px] w-auto block object-contain max-[480px]:h-[38px]">
            </a>

            <ul class="navbar-right-links">
                @foreach ($style3RightItems as $menu)
                    <li>
                        <a href="{{ $resolveMenuUrl($menu) }}"
                            @if ($menu->open_new_tab || $menu->is_external) target="_blank" rel="noopener noreferrer" @endif
                            class="{{ $isMenuActive($menu) ? 'active' : '' }}">
                            {{ $menu->menu_label }}
                        </a>
                    </li>
                @endforeach
            </ul>

            @if ($primaryButtonItem)
                <a href="{{ $resolveMenuUrl($primaryButtonItem) }}" class="inline-flex items-center bg-[#e63946] text-white text-[12px] font-bold py-2 px-5 rounded-[980px] transition-[background,transform] duration-200 whitespace-nowrap shrink-0 ml-1 hover:bg-[rgba(193,18,31,0.65)] hover:scale-[1.03]" @if ($primaryButtonItem->open_new_tab || $primaryButtonItem->is_external) target="_blank" rel="noopener noreferrer" @endif>{{ $primaryButtonItem->menu_label }}</a>
            @endif

            <button class="nav-hamburger nm3-hamburger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
            </nav>

            <!-- pilih cabang kota -->
            <div class="nm3-city-wrap flex gap-2 items-center pointer-events-auto pb-[10px]">
                <div class="city-item">
                    <button class="nm3-city-toggle inline-flex items-center gap-[5px] py-[5px] px-[10px] bg-[rgba(230,57,70,0.07)] border-[1.5px] border-[rgba(230,57,70,0.2)] rounded-[980px] cursor-pointer font-[Montserrat,sans-serif] text-[12px] font-semibold text-[#e63946] leading-none transition-[background,border-color] duration-150 whitespace-nowrap hover:bg-[rgba(230,57,70,0.12)]">
                    📍 Yogyakarta
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="city-card">
                        <div class="p-3 pb-[10px] flex items-center gap-[9px]">
                        <img src="{{ asset('img/logo/jogja.jpeg') }}" alt="Jogja" class="w-[30px] h-[30px] object-contain rounded-[4px] shrink-0 block">
                        <div>
                            <div class="text-[13px] font-bold text-[#202124] leading-[1.2]"> Yogyakarta</div>
                            <span class="text-[11px] text-[#9aa0a6] block mt-[1px]">Mitra Oke</span>
                        </div>
                        </div>
                        <div class="h-px bg-[#f1f3f4]"></div>
                        <div class="flex justify-end py-1 px-[6px] gap-0.5">
                            <button class="nm3-city-close py-[6px] px-2 bg-transparent text-[#5f6368] border-none text-[12px] font-semibold cursor-pointer rounded-[4px] font-[Montserrat,sans-serif] transition-colors duration-100 hover:bg-[#f1f3f4]">Batal</button>
                            <a href="{{ route('cabang.jogja') }}" class="py-[6px] px-2 bg-transparent text-[#1a73e8] border-none text-[12px] font-bold cursor-pointer rounded-[4px] font-[Montserrat,sans-serif] transition-colors duration-100 hover:bg-[#e8f0fe] inline-block no-underline">Kunjungi →</a>
                        </div>
                    </div>
                </div>

                <div class="city-item">
                    <button class="nm3-city-toggle inline-flex items-center gap-[5px] py-[5px] px-[10px] bg-[rgba(230,57,70,0.07)] border-[1.5px] border-[rgba(230,57,70,0.2)] rounded-[980px] cursor-pointer font-[Montserrat,sans-serif] text-[12px] font-semibold text-[#e63946] leading-none transition-[background,border-color] duration-150 whitespace-nowrap hover:bg-[rgba(230,57,70,0.12)]">
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
                            <button class="nm3-city-close py-[6px] px-2 bg-transparent text-[#5f6368] border-none text-[12px] font-semibold cursor-pointer rounded-[4px] font-[Montserrat,sans-serif] transition-colors duration-100 hover:bg-[#f1f3f4]">Batal</button>
                            <a href="{{ route('cabang.malang') }}" class="py-[6px] px-2 bg-transparent text-[#1a73e8] border-none text-[12px] font-bold cursor-pointer rounded-[4px] font-[Montserrat,sans-serif] transition-colors duration-100 hover:bg-[#e8f0fe] inline-block no-underline">Kunjungi →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- menu mobile layar penuh -->
        <div class="nav-mobile-menu nm3-mobile-menu">
            @foreach ($style3AllItems->take(6) as $menu)
                <a href="{{ $resolveMenuUrl($menu) }}"
                    @if ($menu->open_new_tab || $menu->is_external) target="_blank" rel="noopener noreferrer" @endif>
                    {{ $menu->menu_label }}
                </a>
            @endforeach
            @if ($primaryButtonItem)
                <a href="{{ $resolveMenuUrl($primaryButtonItem) }}" class="nav-mobile-cta" @if ($primaryButtonItem->open_new_tab || $primaryButtonItem->is_external) target="_blank" rel="noopener noreferrer" @endif>{{ $primaryButtonItem->menu_label }}</a>
            @endif
        </div>
    </div>





@endif

