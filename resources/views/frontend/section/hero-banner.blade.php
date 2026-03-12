
@if ($shortcode->type == 'hero-banner')
@php
    $heroSection = $shortcode->hero;
    // Build panels array for Style 1 (up to 6 panels)
    $heroPanels = [];
    if ($heroSection) {
        $panelSuffixes = ['', '_2', '_3', '_4', '_5', '_6'];
        foreach ($panelSuffixes as $idx => $suffix) {
            $imgField = 'image' . $suffix;
            $titleField = 'title' . $suffix;
            $descField = 'description' . $suffix;
            $urlField = 'action_url' . $suffix;
            $labelField = 'action_label' . $suffix;
            if ($heroSection->$titleField || $heroSection->$imgField) {
                $heroPanels[] = [
                    'image'        => $heroSection->$imgField ? asset('storage/' . $heroSection->$imgField) : null,
                    'title'        => $heroSection->$titleField ?? '',
                    'description'  => $heroSection->$descField ?? '',
                    'action_url'   => $heroSection->$urlField ?? '#',
                    'action_label' => $heroSection->$labelField ?? 'READ MORE',
                    'num'          => $idx + 1,
                ];
            }
        }
    }
    // Build slides for Style 2 backgrounds
    $heroSlides = [];
    if ($heroSection) {
        $bgFields = ['image_background', 'image_background_2', 'image_background_3'];
        foreach ($bgFields as $bgField) {
            if ($heroSection->$bgField) {
                $heroSlides[] = asset('storage/' . $heroSection->$bgField);
            }
        }
        // Fall back to regular images if no backgrounds defined
        if (empty($heroSlides)) {
            foreach (['image', 'image_2', 'image_3', 'image_4'] as $imgF) {
                if ($heroSection->$imgF) {
                    $heroSlides[] = asset('storage/' . $heroSection->$imgF);
                }
            }
        }
    }
    if (empty($heroSlides)) {
        $heroSlides = [
            'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1568992687947-868a62a9f521?w=1600&auto=format&fit=crop&q=80',
        ];
    }
@endphp

{{-- Wrapper to properly isolate each hero section --}}
<div style="position: relative; isolation: isolate; clear: both; display: block; width: 100%;">
@if ($shortcode->hero_style == '1')

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/style/section/hero/style1.css') }}">
    @endpush
    
    <section class="relative pt-20 bg-white w-full" id="hero-style-1" style="position: relative; isolation: isolate; display: block; width: 100%;">
        <div class="min-h-[calc(100vh-80px)] md:h-[calc(100vh-80px)] flex flex-col md:flex-row"
        x-data="{ activePanel: null }"
        @click.away="activePanel = null">
        @forelse($heroPanels as $panel)
        <div class="panel-item group" style="position: relative; overflow: hidden; cursor: pointer;"
        :class="{ 'active': activePanel === {{ $panel['num'] }} }"
                    @click="activePanel = (activePanel === {{ $panel['num'] }}) ? null : {{ $panel['num'] }}">
                    @if($panel['image'])
                    <img src="{{ $panel['image'] }}"
                        alt="{{ $panel['title'] }}"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;"
                        onerror="this.src='https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=800&q=80'">
                    @endif
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-500"></div>

                    <!-- Content Overlay Card -->
                    <div class="content-card absolute bottom-0 right-0 left-0 bg-white/60 backdrop-blur-md p-4 md:p-6 lg:p-8">
                        <span class="inline-block px-3 py-1.5 border border-gray-300 text-[10px] font-medium tracking-[0.15em] text-gray-600 mb-3 md:mb-4">KATEGORI</span>
                        <h2 class="text-lg md:text-xl lg:text-2xl text-gray-900 mb-2 md:mb-3 leading-tight">
                            {{ $panel['title'] }}
                        </h2>
                        @if($panel['description'])
                        <p class="hidden md:block text-gray-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-5" style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-clamp: 3;">
                            {{ $panel['description'] }}
                        </p>
                        @endif
                        <a href="{{ $panel['action_url'] }}" @click.stop
                        class="inline-block text-xs font-medium tracking-[0.15em] text-gray-600/70 border-b border-gray-400/50 pb-1 hover:text-red-600 hover:border-red-600 transition-colors">
                            {{ strtoupper($panel['action_label']) ?: 'READ MORE' }}
                        </a>
                    </div>
                </div>
                @empty
                {{-- Fallback: show a single generic panel --}}
                <div class="panel-item group flex-1 flex items-center justify-center bg-gray-100">
                    <p class="text-gray-400 text-sm">Belum ada konten hero</p>
                </div>
                @endforelse
            </div>
        </section>
        
        
        
        
        
        
        
        
        
@elseif ($shortcode->hero_style == '2')

        @push('styles')
            <link rel="stylesheet" href="{{ asset('assets/style/section/hero/style2.css') }}">
        @endpush
        
        {{-- Negative margin to compensate for main padding --}}
        <section class="relative w-full min-h-screen overflow-hidden -mt-14 sm:-mt-20" id="hero-style-2" 
                 style="position: relative; isolation: isolate; display: block; width: 100%;"
            x-data="{
                current: 0,
                slides: {{ Js::from($heroSlides) }},
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
                    {{ $heroSection?->action_label_3 ?? 'Platform Pengadaan TKDN Terpercaya' }}
                </div>

                {{-- Heading --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight tracking-tight max-w-4xl mb-6 reveal">
                    {!! $heroSection?->title
                        ? nl2br(e($heroSection->title))
                        : 'Solusi Pengadaan<br><span class="relative inline-block"><span class="relative z-10">Barang &amp; Jasa</span><span class="absolute -bottom-1 left-0 w-full h-2 bg-red-500 -z-0 opacity-70 rounded-sm"></span></span><br>Berstandar TKDN untuk Instansi' !!}
                </h1>

                {{-- Subtext --}}
                <p class="text-white/70 text-base md:text-lg leading-relaxed max-w-xl mb-10 reveal" 
                   style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-clamp: 3;">
                    {{ $heroSection?->description ?? 'Kami menghubungkan instansi pemerintah dan swasta dengan mitra penyedia barang & jasa TKDN terverifikasi, sesuai regulasi pengadaan nasional.' }}
                </p>

                {{-- CTAs --}}
                <div class="flex items-center gap-4 mb-10 reveal">
                    <a href="{{ $heroSection?->action_url ?? '#' }}"
                    class="inline-flex items-center bg-white text-gray-900 text-sm font-bold px-7 py-3.5 rounded-full hover:bg-red-600 hover:text-white transition-colors shadow-xl">
                        {{ $heroSection?->action_label ?? 'Konsultasi Gratis' }}
                    </a>
                    <a href="{{ $heroSection?->action_url_2 ?? route('produk') }}"
                    class="inline-flex items-center gap-2 text-white text-sm font-semibold border border-white/40 px-7 py-3.5 rounded-full hover:bg-white/10 transition-colors backdrop-blur-sm">
                        <span>{{ $heroSection?->action_label_2 ?? 'Lihat Katalog' }}</span>
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
        
        
        
        
        
        
        
        
    
    @elseif($shortcode->hero_style == '3')
    
        @push('styles')
            <link rel="stylesheet" href="{{ asset('assets/style/section/hero/style3.css') }}">
        @endpush

        {{-- Hero Style 3: Minimalist Split Screen --}}
        <section class="relative w-full min-h-screen flex flex-col md:flex-row" id="hero-style-3" 
                 style="position: relative; isolation: isolate; display: block; width: 100%;">
            
            {{-- Left Side: Content --}}
            <div class="w-full md:w-1/2 bg-gray-900 flex items-center justify-center px-8 md:px-16 py-24 md:py-0">
                <div class="max-w-lg">
                    <span class="inline-block text-xs font-bold tracking-[0.2em] text-gray-400 uppercase mb-4">
                        {{ $heroSection?->action_label_3 ?? 'Produk Berkualitas' }}
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                        {{ $heroSection?->title ?? 'Solusi Lengkap untuk Kebutuhan Anda' }}
                    </h1>
                    <p class="text-gray-300 text-base md:text-lg leading-relaxed mb-8">
                        {{ $heroSection?->description ?? 'Kami menyediakan berbagai produk berkualitas tinggi dengan standar TKDN untuk memenuhi kebutuhan instansi dan perusahaan Anda.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ $heroSection?->action_url ?? '#' }}" 
                           class="inline-flex items-center justify-center bg-red-600 text-white text-sm font-bold px-8 py-4 rounded-lg hover:bg-red-700 transition-colors">
                            {{ $heroSection?->action_label ?? 'Mulai Sekarang' }}
                        </a>
                        <a href="{{ $heroSection?->action_url_2 ?? '#' }}" 
                           class="inline-flex items-center justify-center bg-transparent border-2 border-white text-white text-sm font-bold px-8 py-4 rounded-lg hover:bg-white hover:text-gray-900 transition-colors">
                            {{ $heroSection?->action_label_2 ?? 'Pelajari Lebih Lanjut' }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Side: Image Grid --}}
            <div class="w-full md:w-1/2 grid grid-cols-2 gap-0">
                @if($heroSection && $heroSection->image)
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $heroSection->image) }}" 
                             alt="Hero Image 1" 
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="relative overflow-hidden bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80" 
                             alt="Hero Image 1" 
                             class="w-full h-full object-cover">
                    </div>
                @endif

                @if($heroSection && $heroSection->image_2)
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $heroSection->image_2) }}" 
                             alt="Hero Image 2" 
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="relative overflow-hidden bg-gray-300">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&q=80" 
                             alt="Hero Image 2" 
                             class="w-full h-full object-cover">
                    </div>
                @endif

                @if($heroSection && $heroSection->image_3)
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . $heroSection->image_3) }}" 
                             alt="Hero Image 3" 
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="relative overflow-hidden bg-gray-400">
                        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800&q=80" 
                             alt="Hero Image 3" 
                             class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="relative overflow-hidden bg-red-600 flex items-center justify-center p-8">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-white mb-2">500+</div>
                        <div class="text-sm text-white/90">Klien Terpercaya</div>
                    </div>
                </div>
            </div>

        </section>
    
    @endif
</div>{{-- End hero-section-wrapper --}}
@endif

@push('scripts')
<script>
// Reveal on scroll animation
document.addEventListener('DOMContentLoaded', function() {
    const reveals = document.querySelectorAll('.reveal');
    
    if (reveals.length === 0) return;
    
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    reveals.forEach(reveal => {
        revealObserver.observe(reveal);
    });
});
</script>
@endpush