<nav class="fixed top-0 left-0 right-0 z-50 bg-indigo-500 text-white shadow-lg">
    @php
        $logoValue = $settings->site_logo ?: $settings->favicon;
        $logoUrl = null;

        if (!blank($logoValue)) {
            if (\Illuminate\Support\Str::startsWith($logoValue, ['http://', 'https://', '//'])) {
                $logoUrl = $logoValue;
            } else {
                $path = parse_url($logoValue, PHP_URL_PATH) ?: $logoValue;
                $path = ltrim($path, '/');
                $logoUrl = \Illuminate\Support\Str::startsWith($path, 'storage/')
                    ? asset($path)
                    : asset('storage/' . $path);
            }
        }
    @endphp
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('backend.dashboard') }}" class="inline-flex items-center gap-3 group">
                    <div class="h-11 rounded-xl bg-white/35 border border-white/45 px-3 flex items-center justify-center overflow-hidden shadow-sm">
                        @if($logoUrl)
                            <img
                                src="{{ $logoUrl }}"
                                alt="{{ $settings->site_title ?? 'Site Logo' }}"
                                class="h-8 w-auto max-w-45 object-contain drop-shadow-[0_1px_1px_rgba(0,0,0,0.12)] transition-transform duration-300 group-hover:scale-[1.02]"
                                style="image-rendering: -webkit-optimize-contrast;"
                                loading="eager"
                            >
                        @else
                            <span class="text-sm font-semibold tracking-wide text-white">{{ $settings->site_title ?? 'MitraCom' }}</span>
                        @endif
                    </div>
                </a>
            </div>
            
            <div class="flex items-center gap-5">
                <div class="text-right hidden sm:block">
                    <div class="font-semibold text-sm">{{ Auth::user()->name }}</div>
                    <div class="text-xs opacity-90 capitalize">{{ Auth::user()->role->name }}</div>
                </div>
                
                <div class="relative" x-data="{ open: false }">
                    <button 
                        @click="open = !open"
                        class="flex items-center gap-2 bg-white/20 hover:bg-white/30 border border-white/30 px-4 py-2 rounded-lg text-sm transition-all duration-300"
                    >
                        <span class="hidden sm:inline">Account</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50"
                        style="display: none;"
                    >
                        <div class="px-4 py-3 border-b">
                            <p class="text-sm text-gray-900 font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
