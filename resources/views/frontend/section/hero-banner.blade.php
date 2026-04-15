
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
                        $heroSlides[] = asset($heroSection->$imgF);
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
    {{-- <div style="position: relative; isolation: isolate; clear: both; display: block; width: 100%;"> --}}
    @if ($shortcode->hero_style == '1')

        @once
            @push('styles')
                <link rel="stylesheet" href="{{ asset('assets/style/section/hero/style1.css') }}">
            @endpush
        @endonce
        
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
                            <p class="panel-description hidden md:block text-gray-500 text-xs md:text-sm leading-relaxed mb-4 md:mb-5">
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

    
        <section class="relative w-full min-h-screen overflow-hidden" id="hero-style-2" 
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
        @php
            $heroStyle3 = [
                'title_line_1' => $heroSection?->title ?: 'Solusi Peralatan Kantor Premium',
                'title_line_2' => $heroSection?->title_2 ?: 'Terlengkap & Terpercaya',
                'subtitle' => $shortcode->subtitle ?: '10',
                'description' => $heroSection?->description ?: 'Dari sistem konferensi hingga furnitur kantor, kami menghadirkan solusi terpadu bersertifikasi TKDN untuk instansi & korporasi Indonesia.',
                'primary' => [
                    'label' => $heroSection?->action_label ?: 'Lihat Produk',
                    'url' => $heroSection?->action_url ?: '#products',
                ],
                'secondary' => [
                    'label' => $heroSection?->action_label_2 ?: 'Mari Berkolaborasi',
                    'url' => $heroSection?->action_url_2 ?: 'https://wa.me/6281252141397',
                ],
                'slides' => array_values(array_filter([
                    $heroSection?->image ? asset('storage/' . $heroSection->image) : null,
                    $heroSection?->image_2 ? asset('storage/' . $heroSection->image_2) : null,
                    $heroSection?->image_3 ? asset('storage/' . $heroSection->image_3) : null,
                ])),
            ];

            if (empty($heroStyle3['slides'])) {
                $heroStyle3['slides'] = [
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?w=900&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=900&auto=format&fit=crop&q=80',
                    'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=900&auto=format&fit=crop&q=80',
                ];
            }

            $titleLine1Words = preg_split('/\s+/', trim((string) $heroStyle3['title_line_1'])) ?: [];
            $forbiddenLineEndWords = ['di', 'ke', 'dari', 'pada', 'dengan', 'oleh', 'dan', 'untuk'];

            $titleLine1FirstPart = implode(' ', array_slice($titleLine1Words, 0, 2));
            $titleLine1SecondPart = implode(' ', array_slice($titleLine1Words, 2));

            if (count($titleLine1Words) > 2) {
                $line1Parts = explode(' ', $titleLine1FirstPart);
                $line1EndWord = strtolower((string) end($line1Parts));

                if (in_array($line1EndWord, $forbiddenLineEndWords, true)) {
                    $titleLine1FirstPart = implode(' ', array_slice($titleLine1Words, 0, 1));
                    $titleLine1SecondPart = implode(' ', array_slice($titleLine1Words, 1));
                }

                $heroStyle3TitleLine1Display = trim($titleLine1FirstPart) . '<br>' . trim($titleLine1SecondPart);
            } else {
                $heroStyle3TitleLine1Display = e($heroStyle3['title_line_1']);
            }
        @endphp

        @once
            @push('styles')
                <link rel="stylesheet" href="{{ asset('assets/style/section/hero/style3.css') }}">
            @endpush

            @push('scripts')
                <script src="{{ asset('assets/js/section/hero/style3.js') }}"></script>
            @endpush
        @endonce

        <section class="hero-style-3-instance relative overflow-hidden bg-white" data-hero-style3 style="position: relative; isolation: isolate; display: block; width: 100%;">
            <div class="hb3-shell min-h-screen pt-[70px] overflow-hidden relative flex items-center max-md:pt-[90px] max-md:min-h-0 max-[480px]:pt-[90px]">
                <div class="container">
                    <div class="relative w-full py-8 pb-14 max-md:py-2 max-md:pb-4 max-md:flex max-md:flex-col max-md:items-center max-md:gap-0">
                        <div class="text-center relative z-[2]">
                            <h1 class="text-[clamp(2.6rem,6vw,5.2rem)] font-black tracking-[-0.04em] leading-[1.02] text-[#111] max-[900px]:text-[clamp(2rem,7vw,3.2rem)] max-md:text-[clamp(2rem,8vw,2.8rem)] max-[480px]:text-[clamp(1.8rem,9vw,2.4rem)]">
                                {!! $heroStyle3TitleLine1Display !!}
                            </h1>
                        </div>

                        <div class="relative max-w-[900px] mx-auto -my-4 flex items-center justify-center max-[900px]:flex-col max-[900px]:gap-0 max-md:max-w-full">
                            <div class="absolute z-[4] top-[18px] left-0 max-[900px]:hidden"><span class="inline-block leading-[1] text-[#e63946] select-none hb3-spin text-[2.8rem]">✦</span></div>
                            <div class="absolute z-[4] top-[18px] right-0 max-[900px]:hidden"><span class="inline-block leading-[1] text-[#e63946] select-none hb3-spin text-[1.2rem]">✦</span></div>
                            <div class="absolute z-[4] bottom-[20px] left-[20px] max-[900px]:hidden"><span class="inline-block leading-[1] text-[#e63946] select-none hb3-spin text-[1.2rem]">✦</span></div>

                            <div class="absolute left-0 top-1/2 -translate-y-1/2 max-w-[210px] z-[3] max-[900px]:static max-[900px]:translate-y-0 max-[900px]:max-w-full max-[900px]:text-center max-[900px]:px-4 max-[900px]:mt-2 max-md:order-2 max-md:mt-1 max-md:px-3 max-md:max-w-full max-md:text-center">
                                <p class="text-[13px] text-[#777] leading-[1.7] break-words [overflow-wrap:anywhere] max-md:text-[12px] max-md:text-[#666] max-md:leading-[1.4]">{{ $heroStyle3['description'] }}</p>
                            </div>

                            <div class="flex justify-center items-center max-md:order-1">
                                <div class="relative w-[360px] shrink-0 flex flex-col items-center gap-[14px] max-[900px]:w-[180px] max-md:w-[180px] max-[480px]:w-[160px]">
                                    <div class="w-[360px] h-[360px] relative overflow-hidden bg-transparent max-[900px]:w-[180px] max-[900px]:h-[180px] max-md:w-[180px] max-md:h-[180px] max-[480px]:w-[160px] max-[480px]:h-[160px]">
                                        @foreach($heroStyle3['slides'] as $slideIndex => $slide)
                                            <div class="hb3-slide {{ $slideIndex === 0 ? 'active' : '' }}">
                                                <img src="{{ $slide }}" alt="Hero Slide {{ $slideIndex + 1 }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="absolute right-0 top-1/2 -translate-y-1/2 text-right z-[3] max-[900px]:hidden">
                                <div class="inline-flex flex-col items-end">
                                    <span class="text-[#fbbf24] text-[14px] tracking-[3px] mb-[2px]">★★★★★</span>
                                    <strong class="text-[2.2rem] font-black text-[#111] leading-[1] tracking-[-0.04em] block">{{ $heroStyle3['subtitle'] }} Tahun</strong>
                                    <small class="text-[12px] text-[#999] mt-[2px]">Pengalaman</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center relative z-[2] max-[900px]:hidden">
                            <h1 class="text-[clamp(2.6rem,6vw,5.2rem)] font-black tracking-[-0.04em] leading-[1.02] text-[#111]">
                                {!! nl2br(e($heroStyle3['title_line_2'])) !!}
                            </h1>
                        </div>

                        <div class="flex justify-center items-center gap-3 mt-10 flex-wrap max-[900px]:mt-5 max-md:mt-[10px] max-md:gap-2 max-md:w-full max-md:flex-col max-md:items-stretch max-md:order-3">
                            <a href="{{ $heroStyle3['primary']['url'] }}" class="inline-flex items-center gap-2 bg-[#e63946] text-white text-[14px] font-bold py-[14px] px-7 rounded-[980px] transition-[transform,box-shadow] duration-200 shadow-[0_4px_24px_rgba(230,57,70,0.28)] hover:-translate-y-[2px] hover:shadow-[0_8px_36px_rgba(230,57,70,0.38)] hover:bg-[#c1121f] max-md:w-full max-md:justify-center max-md:py-3 max-md:px-5 max-[480px]:py-[13px] max-[480px]:px-[18px]">
                                {{ $heroStyle3['primary']['label'] }}
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>

                            <a href="{{ $heroStyle3['secondary']['url'] }}" class="inline-flex items-center gap-2 bg-white border-[1.5px] border-[rgba(0,0,0,0.12)] text-[#333] text-[14px] font-semibold py-[14px] px-7 rounded-[980px] transition-[background,border-color,transform] duration-200 shadow-[0_2px_12px_rgba(0,0,0,0.06)] hover:bg-[#f8f8f8] hover:border-[rgba(0,0,0,0.18)] hover:-translate-y-[1px] max-md:w-full max-md:justify-center max-md:py-3 max-md:px-5 max-[480px]:py-[13px] max-[480px]:px-[18px]" target="{{ str_contains($heroStyle3['secondary']['url'], 'http') ? '_blank' : '_self' }}">
                                {{ $heroStyle3['secondary']['label'] }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- </div>End hero-section-wrapper --}}
@endif





@once
    @push('scripts')
        <script>
            // Reveal on scroll animation
            document.addEventListener('DOMContentLoaded', function() {
                const reveals = document.querySelectorAll('#hero-style-2 .reveal');
                
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
@endonce