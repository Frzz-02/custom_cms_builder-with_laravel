@if ($shortcode->type == 'latestnews')
    @if ($shortcode->latestnews_style == 'Style 1')

        <!-- Blog Slider Section - Auto Animate -->
        <section class="py-16 bg-gray-50">
            <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24 mb-10">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-medium tracking-[0.3em] text-gray-400 mb-2 block">BLOG & ARTIKEL</span>
                        <h2 class="text-3xl md:text-4xl font-light text-gray-900">
                            {{ $shortcode->latestnews_title ?? 'Inspirasi & Tips' }}
                        </h2>
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

                    @forelse($blogs as $blog)
                    <!-- Blog Card -->
                    <a href="{{ route('blog.show', $blog->slug) }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="{{ asset('storage/' . $blog->image) }}"
                                    alt="{{ $blog->meta_title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                                @if($blog->category)
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded uppercase">
                                    {{ $blog->category->name }}
                                </span>
                                @endif
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">{{ $blog->meta_title }}</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($blog->publish_date)->format('d M Y') }}
                                    </span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="flex-shrink-0 w-72">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm p-8 text-center">
                            <p class="text-gray-500">Belum ada artikel</p>
                        </div>
                    </div>
                    @endforelse

                    @if($blogs->count() > 0)
                    <!-- Duplicate cards for seamless loop -->
                    @foreach($blogs as $blog)
                    <a href="{{ route('blog.show', $blog->slug) }}" class="flex-shrink-0 w-72 group cursor-pointer">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-shadow">
                            <div class="aspect-[4/3] overflow-hidden relative">
                                <img src="{{ asset('storage/' . $blog->image) }}"
                                    alt="{{ $blog->meta_title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                                @if($blog->category)
                                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-medium tracking-wider text-gray-600 rounded uppercase">
                                    {{ $blog->category->name }}
                                </span>
                                @endif
                            </div>
                            <div class="p-5">
                                <h4 class="font-light text-gray-900 mb-2 line-clamp-2">{{ $blog->meta_title }}</h4>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($blog->publish_date)->format('d M Y') }}
                                    </span>
                                    <span class="text-xs text-gray-500 group-hover:text-red-600 transition-colors">Read →</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- Navigation Dots -->
            @if($blogs->count() > 0)
            <div class="flex justify-center gap-2 mt-8">
                @for($i = 0; $i < min(5, $blogs->count()); $i++)
                <span class="w-2 h-2 rounded-full {{ $i == 2 ? 'w-8 bg-gray-900' : 'bg-gray-300' }}"></span>
                @endfor
            </div>
            @endif
        </section>
      
    @elseif ($shortcode->latestnews_style == 'Style 2')

        <section class="w-full px-8 md:px-16 py-16 bg-gray-50/60 reveal">
            {{-- Section Header --}}
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 flex items-center gap-3">
                    <span class="inline-block w-1 h-8 bg-gray-400 rounded-full"></span>
                    {{ $shortcode->latestnews_title ?? 'Info Terbaru Hari Ini' }}
                </h2>
                <a href="{{ route('blog') }}"
                class="text-xs font-bold text-gray-500 uppercase tracking-widest hover:text-red-600 transition-colors">
                    Lihat Semua &rarr;
                </a>
            </div>

            @if($blogs->count() >= 1)
            {{-- 3-Column Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Col 1: Featured Large Card --}}
                @if($blogs->count() >= 1)
                <a href="{{ route('blog.show', $blogs[0]->slug) }}" class="relative overflow-hidden h-[500px] cursor-pointer group card-hover">
                    <img src="{{ asset('storage/' . $blogs[0]->image) }}" alt="{{ $blogs[0]->meta_title }}"
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        @if($blogs[0]->category)
                        <span class="inline-block bg-gray-400 text-gray-900 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full mb-3">
                            {{ $blogs[0]->category->name }}
                        </span>
                        @endif
                        <h3 class="text-white font-bold text-base leading-snug mb-3">{{ $blogs[0]->meta_title }}</h3>
                        <div class="flex items-center gap-4 text-gray-300 text-xs">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($blogs[0]->publish_date)->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </a>
                @endif

                {{-- Col 2: 3 Small Horizontal Cards --}}
                <div class="flex flex-col gap-4 h-[500px]">
                    @foreach($blogs->skip(1)->take(3) as $blog)
                    <a href="{{ route('blog.show', $blog->slug) }}" class="flex items-center gap-4 bg-white rounded-sm p-4 shadow-sm hover:shadow-md transition-shadow group cursor-pointer border border-gray-100 flex-1">
                        <div class="w-24 h-24 overflow-hidden shrink-0">
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->meta_title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="flex-1 min-w-0">
                            @if($blog->category)
                            <span class="inline-block bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wide px-2.5 py-0.5 rounded-full mb-1.5">
                                {{ $blog->category->name }}
                            </span>
                            @endif
                            <h3 class="text-sm font-bold text-gray-900 leading-snug line-clamp-2 mb-1.5">{{ $blog->meta_title }}</h3>
                            <p class="text-xs text-gray-400 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($blog->publish_date)->format('d M Y') }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Col 3: 2 Tall Cards --}}
                <div class="flex flex-col gap-4 h-[500px]">
                    @foreach($blogs->skip(4)->take(2) as $blog)
                    <a href="{{ route('blog.show', $blog->slug) }}" class="relative overflow-hidden flex-1 cursor-pointer group card-hover block">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->meta_title }}"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            @if($blog->category)
                            <span class="inline-block bg-gray-400 text-gray-900 text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full mb-2">
                                {{ $blog->category->name }}
                            </span>
                            @endif
                            <h3 class="text-white font-bold text-sm leading-snug">{{ $blog->meta_title }}</h3>
                        </div>
                    </a>
                    @endforeach
                </div>

            </div>
            @else
            <div class="text-center py-16">
                <p class="text-gray-500">Belum ada artikel tersedia</p>
            </div>
            @endif
        </section>
        
    @elseif ($shortcode->latestnews_style == 'Style 3')
    
        <!-- blog -->
        <section class="py-24 bg-[#f8f8f8] max-md:py-14" id="blog">
            <div class="container">
                <div class="reveal flex items-end justify-between gap-6 mb-12 flex-wrap max-md:flex-col max-md:items-start max-md:gap-4 max-md:mb-8">
                    <div>
                        <p class="text-[11px] font-bold tracking-[0.12em] uppercase text-[#999] mb-[10px]">Insight &amp; Tips</p>
                        <h2 class="text-[clamp(1.8rem,3.2vw,2.4rem)] font-extrabold tracking-[-0.04em] text-[#111] leading-[1.15]">
                            {{ $shortcode->latestnews_title ?? 'Artikel Terbaru' }}
                        </h2>
                    </div>
                    <a href="{{ route('blog') }}" target="_blank" class="inline-flex items-center gap-2 bg-[#888] text-white text-[13px] font-bold py-3 px-[22px] rounded-[980px] whitespace-nowrap shrink-0 self-end tracking-[0.01em] transition-[background,transform] duration-200 hover:bg-[rgba(192,57,43,0.65)] hover:-translate-y-[2px] [&:hover_svg]:translate-x-[3px]">
                        Lihat Semua
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-200"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                @if($blogs->count() >= 1)
                <div class="grid grid-cols-[1.1fr_0.9fr] gap-7 items-stretch max-[900px]:grid-cols-1">

                    {{-- artikel utama --}}
                    <a href="{{ route('blog.show', $blogs[0]->slug) }}" target="_blank" class="group reveal flex flex-col bg-white rounded-[20px] overflow-hidden transition-[box-shadow,transform] duration-300 text-inherit hover:shadow-[0_16px_56px_rgba(0,0,0,0.10)] hover:-translate-y-1">
                        <div class="w-full aspect-[16/10] overflow-hidden relative shrink-0">
                            <img src="{{ asset('storage/' . $blogs[0]->image) }}" 
                                 alt="{{ $blogs[0]->meta_title }}" 
                                 class="w-full h-full object-cover block transition-transform duration-500 ease-[cubic-bezier(.4,0,.2,1)] group-hover:scale-[1.04]"
                                 loading="lazy">
                            @if($blogs[0]->category)
                            <span class="absolute top-[14px] left-[14px] bg-[#111] text-white text-[10px] font-bold tracking-[0.08em] uppercase py-[5px] px-3 rounded-[980px] pointer-events-none">
                                {{ $blogs[0]->category->name }}
                            </span>
                            @endif
                        </div>
                        <div class="p-7 pb-6 flex flex-col flex-1">
                            <h3 class="text-[clamp(17px,1.8vw,21px)] font-extrabold tracking-[-0.03em] text-[#111] leading-[1.35] mb-[10px]">
                                {{ $blogs[0]->meta_title }}
                            </h3>
                            <p class="text-[13px] text-[#888] leading-[1.7] mb-6 line-clamp-2 flex-1">
                                {{ $blogs[0]->meta_description }}
                            </p>
                            <div class="flex items-center justify-between gap-[10px] pt-4 border-t border-[#f0f0f0]">
                                <div class="flex items-center gap-2">
                                    <img class="w-[30px] h-[30px] rounded-full object-cover shrink-0" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode($blogs[0]->author) }}&background=random" 
                                         alt="{{ $blogs[0]->author }}">
                                    <span class="text-[12px] font-semibold text-[#555]">{{ $blogs[0]->author }}</span>
                                </div>
                                <span class="text-[11px] text-[#bbb] font-medium">
                                    {{ \Carbon\Carbon::parse($blogs[0]->publish_date)->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </a>

                    {{-- daftar artikel --}}
                    <div class="reveal reveal-d2 flex flex-col gap-3 h-full">
                        @foreach($blogs->skip(1)->take(5) as $blog)
                        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="group flex flex-1 gap-4 items-center p-4 bg-white rounded-[14px] cursor-pointer transition-[box-shadow,transform] duration-[250ms] text-inherit hover:shadow-[0_8px_32px_rgba(0,0,0,0.08)] hover:-translate-y-[2px] max-[480px]:flex-col max-[480px]:items-start">
                            <div class="w-[100px] h-[72px] rounded-[10px] overflow-hidden shrink-0 max-md:w-[80px] max-md:h-[60px] max-[480px]:w-full max-[480px]:h-[160px] max-[480px]:rounded-[10px]">
                                <img src="{{ asset('storage/' . $blog->image) }}" 
                                     alt="{{ $blog->meta_title }}" 
                                     class="w-full h-full object-cover block transition-transform duration-[400ms] ease-[cubic-bezier(.4,0,.2,1)] group-hover:scale-[1.08]"
                                     loading="lazy">
                            </div>
                            <div class="flex-1 flex flex-col gap-2">
                                @if($blog->category)
                                <span class="text-[10px] font-bold tracking-[0.08em] uppercase text-[#e63946]">
                                    {{ $blog->category->name }}
                                </span>
                                @endif
                                <p class="text-[13px] font-bold text-[#111] leading-[1.45] tracking-[-0.01em] line-clamp-2">
                                    {{ $blog->meta_title }}
                                </p>
                                <span class="text-[11px] text-[#bbb] font-medium">
                                    {{ $blog->author }} &middot; {{ \Carbon\Carbon::parse($blog->publish_date)->format('d M Y') }}
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="text-center py-16">
                    <p class="text-gray-500">Belum ada artikel tersedia</p>
                </div>
                @endif
            </div>
        </section>

    @endif

@endif
      
    