@if ($shortcode->type == 'testimonials')
    @php
        $rawTestimoniIds = $shortcode->section_testimoni_id ?? [];

        if (is_array($rawTestimoniIds)) {
            $testimoniIds = $rawTestimoniIds;
        } elseif ($rawTestimoniIds instanceof \Illuminate\Support\Collection) {
            $testimoniIds = $rawTestimoniIds->all();
        } elseif (is_string($rawTestimoniIds)) {
            $decodedIds = json_decode($rawTestimoniIds, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedIds)) {
                $testimoniIds = $decodedIds;
            } else {
                $testimoniIds = array_map('trim', explode(',', $rawTestimoniIds));
            }
        } elseif (is_numeric($rawTestimoniIds)) {
            $testimoniIds = [(int) $rawTestimoniIds];
        } else {
            $testimoniIds = [];
        }

        $testimoniIds = array_values(array_filter($testimoniIds, static function ($id) {
            return is_numeric($id) && (int) $id > 0;
        }));

        $dbTestimonials = collect();
        if (!empty($testimoniIds)) {
            $rawTestimonials = \App\Models\SectionTestimonial::whereIn('id', $testimoniIds)
                ->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(status)'), ['active', 'aktif'])
                ->get()
                ->keyBy('id');

            $dbTestimonials = collect($testimoniIds)
                ->map(static function ($id) use ($rawTestimonials) {
                    return $rawTestimonials->get((int) $id);
                })
                ->filter()
                ->values();
        }

        if ($dbTestimonials->count() < 3) {
            $additionalTestimonials = \App\Models\SectionTestimonial::whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(status)'), ['active', 'aktif'])
                ->when($dbTestimonials->isNotEmpty(), function ($query) use ($dbTestimonials) {
                    $query->whereNotIn('id', $dbTestimonials->pluck('id')->all());
                })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $dbTestimonials = $dbTestimonials
                ->concat($additionalTestimonials)
                ->unique('id')
                ->values();
        }

        if ($dbTestimonials->isEmpty()) {
            $dbTestimonials = collect([
                (object) [
                    'name' => 'Sir Didik Wenger',
                    'position' => 'Purchasing Manager Tech Corp',
                    'content' => 'MitraJogja sangat membantu untuk kebutuhan procurement kantor. Katalog lengkap, harga kompetitif, dan pengiriman cepat. Partner B2B yang sangat profesional dan terpercaya!',
                    'image' => null,
                    'star' => 5,
                    'created_at' => now(),
                ],
                (object) [
                    'name' => 'Sarah Wijaya',
                    'position' => 'Admin Rumah Sakit',
                    'content' => 'Sudah 6 bulan jadi pelanggan untuk supply alat kesehatan dan kebersihan. Produk original, harga bersaing, dan CS sangat responsif. Highly recommended!',
                    'image' => null,
                    'star' => 5,
                    'created_at' => now(),
                ],
                (object) [
                    'name' => 'Budi Santoso',
                    'position' => 'Owner Toko Peralatan',
                    'content' => 'Sistem grosir yang fleksibel dan harga sangat kompetitif. Katalog produknya lengkap dari ATK sampai furniture. Perfect untuk reseller seperti kami!',
                    'image' => null,
                    'star' => 5,
                    'created_at' => now(),
                ],
                (object) [
                    'name' => 'Dewi Lestari',
                    'position' => 'Office Manager',
                    'content' => 'One-stop solution untuk semua kebutuhan kantor! Dari ATK, furniture, sampai cleaning supplies semua ada. Proses pemesanan mudah dan pengiriman tepat waktu!',
                    'image' => null,
                    'star' => 5,
                    'created_at' => now(),
                ],
            ]);
        }

        $borders = ['border-violet-400', 'border-violet-300', 'border-sky-400', 'border-teal-300', 'border-amber-400', 'border-pink-400'];

        $testimonialsStyle1Data = $dbTestimonials->map(function ($t, $i) use ($borders) {
            return [
                'name'    => $t->name ?? 'Pelanggan',
                'role'    => $t->position ?? '',
                'text'    => $t->content ?? '',
                'product' => $t->position ?? '',
                'avatar'  => $t->image ? asset('storage/' . $t->image) : 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&q=80',
                'star'    => (int) ($t->star ?? 5),
                'border'  => $borders[$i % count($borders)],
            ];
        })->values()->toArray();

        $testimonialsStyle2Data = $dbTestimonials->map(function ($t) {
            return [
                'name'   => $t->name ?? 'Pelanggan',
                'date'   => $t->created_at ? \Illuminate\Support\Carbon::parse($t->created_at)->format('d M Y') : '-',
                'rating' => (int) ($t->star ?? 5),
                'title'  => $t->position ?: 'Testimoni Pelanggan',
                'text'   => $t->content ?? '',
                'image'  => $t->image ? asset('storage/' . $t->image) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&auto=format&fit=crop&q=80',
            ];
        })->values()->toArray();

        $testimonialsStyle3Data = $dbTestimonials->map(function ($t) {
            $name = $t->name ?? 'Pelanggan';
            $initials = collect(explode(' ', trim((string) $name)))
                ->filter()
                ->map(static fn ($word) => mb_substr($word, 0, 1))
                ->take(2)
                ->implode('');

            return [
                'name' => $name,
                'position' => $t->position ?? 'Client',
                'location' => 'Indonesia',
                'company' => $t->position ?? 'Client',
                'initials' => strtoupper($initials ?: 'CL'),
                'avatar' => $t->image ? asset('storage/' . $t->image) : 'https://i.pravatar.cc/120?img=11',
                'quote' => $t->content ?? '',
            ];
        })->values()->toArray();
    @endphp

    @if ($shortcode->testimonials_style == '1')
        <!-- Testimonials Section -->
        <section id="testimoni" class="py-20 bg-gradient-to-b from-slate-100 to-slate-200 relative overflow-hidden" data-reveal>
            <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24 relative z-10"
                x-data="{
                    currentTestimonial: 0,
                    testimonials: {{ Js::from($testimonialsStyle1Data) }},
                    init() {
                        if (!Array.isArray(this.testimonials) || this.testimonials.length === 0) {
                            this.testimonials = [{ name: '', role: '', text: '', product: '', avatar: '', star: 5, border: 'border-sky-400' }];
                        }

                        if (this.currentTestimonial >= this.testimonials.length) {
                            this.currentTestimonial = 0;
                        }
                    },
                    activeTestimonial() {
                        return this.testimonials[this.currentTestimonial] ?? { name: '', role: '', text: '', product: '' };
                    },
                    getPosition(index) {
                        const diff = index - this.currentTestimonial;
                        const total = this.testimonials.length;
                        let pos = diff;
                        if (diff > total / 2) pos = diff - total;
                        if (diff < -total / 2) pos = diff + total;
                        return pos;
                    },
                    selectTestimonial(index) {
                        this.currentTestimonial = index;
                    }
                }">

                <div class="text-center mb-10">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900">
                        {{ $shortcode->testimonials_title ?? 'Kata Mereka Tentang' }}
                    </h2>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900">
                        {{ $shortcode->testimonials_subtitle ?? 'Layanan Kami?' }}
                    </h2>
                </div>

                <!-- Avatar Carousel - Horizontal sliding -->
                <div class="relative h-32 md:h-36 lg:h-40 mb-8 overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <template x-for="(testimonial, index) in testimonials" :key="index">
                            <button x-on:click="selectTestimonial(index)"
                                    class="absolute rounded-full overflow-hidden shadow-lg transition-all duration-500 ease-out cursor-pointer"
                                    :class="[
                                        testimonial.border,
                                        currentTestimonial === index
                                            ? 'w-20 h-20 md:w-24 md:h-24 lg:w-28 lg:h-28 border-3 ring-3 ring-sky-400/50 z-30'
                                            : Math.abs(getPosition(index)) === 1
                                                ? 'w-14 h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 border-2 z-20 opacity-80 hover:opacity-100'
                                                : 'w-10 h-10 md:w-12 md:h-12 lg:w-14 lg:h-14 border-2 z-10 opacity-50 hover:opacity-70'
                                    ]"
                                    :style="{
                                        transform: 'translateX(' + (getPosition(index) * (window.innerWidth < 768 ? 70 : window.innerWidth < 1024 ? 110 : 140)) + 'px) scale(' + (currentTestimonial === index ? 1 : Math.abs(getPosition(index)) === 1 ? 0.85 : 0.7) + ')',
                                    }">
                                <img :src="testimonial.avatar" :alt="testimonial.name" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Testimonial Card with Slider -->
                <div class="max-w-4xl mx-auto">
                    <!-- Name & Role -->
                    <div class="text-center mb-4">
                        <p class="text-sky-600 font-semibold text-base md:text-lg" x-text="'— ' + activeTestimonial().name"></p>
                        <p class="text-sm md:text-base text-gray-500" x-text="activeTestimonial().role"></p>
                    </div>

                    <!-- Testimonial Card -->
                    <div class="relative">
                        <!-- Arrow Left -->
                        <button x-on:click="currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length"
                                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-2 md:-translate-x-12 z-10 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:shadow-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        <!-- Arrow Right -->
                        <button x-on:click="currentTestimonial = (currentTestimonial + 1) % testimonials.length"
                                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 md:translate-x-12 z-10 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:shadow-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <div class="bg-white rounded-2xl shadow-xl p-5 md:p-8 transition-all duration-300">
                            <div class="text-center">
                                <!-- Quote Icon -->
                                <svg class="w-10 h-10 md:w-12 md:h-12 text-sky-200 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                </svg>

                                <!-- Testimonial Text -->
                                <blockquote class="text-gray-700 text-base md:text-lg leading-relaxed mb-4" x-text="activeTestimonial().text"></blockquote>

                                <!-- Rating Stars -->
                                <div class="flex justify-center text-yellow-400 text-lg md:text-xl mb-3 gap-0.5">
                                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                </div>

                                <!-- Product Badge -->
                                <span class="inline-block px-4 py-1.5 bg-sky-100 text-sky-700 text-sm md:text-base font-medium rounded-full" x-text="activeTestimonial().product"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Dots -->
                    <div class="flex justify-center gap-2 mt-6">
                        <template x-for="(item, index) in testimonials" :key="index">
                            <button x-on:click="selectTestimonial(index)"
                                    :class="currentTestimonial === index ? 'bg-sky-500 w-8' : 'bg-gray-300 w-3 hover:bg-red-400'"
                                    class="h-3 rounded-full transition-all duration-300"></button>
                        </template>
                    </div>

                    <!-- CTA Button -->
                    <div class="text-center mt-8">
                        <a href="{{ url('/testimoni') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition-colors">
                            Lihat Semua Testimoni
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        

    
    @elseif ($shortcode->testimonials_style == '2')
        @php
            $testimonialsStyle2Max = max(0, count($testimonialsStyle2Data) - 2);
        @endphp

        <section class="w-full px-8 md:px-16 py-16 bg-white"
                x-data="{
                    current: 0,
                    max: {{ $testimonialsStyle2Max }},
                    prev() { if (this.current > 0) this.current-- },
                    next() { if (this.current < this.max) this.current++ }
                }">

            <h2 class="text-center text-3xl md:text-4xl font-extrabold text-gray-900 mb-10 reveal">
                {{ $shortcode->testimonials_title ?? 'Pelanggan Bahagia Kami' }}
            </h2>

            @if (!empty($shortcode->testimonials_subtitle))
                <p class="text-center text-base md:text-lg text-gray-500 -mt-6 mb-10 reveal">
                    {{ $shortcode->testimonials_subtitle }}
                </p>
            @endif

            <div class="relative">
                <button @click="prev()"
                        :class="current === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:shadow-md hover:border-gray-400'"
                        class="absolute -left-5 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <div class="overflow-hidden">
                    <div class="flex gap-5 transition-transform duration-500 ease-in-out"
                        :style="`transform: translateX(calc(-${current} * (50% + 10px)))`">

                        @foreach($testimonialsStyle2Data as $t)
                        <div class="w-1/2 shrink-0 bg-white border border-gray-200 p-6 shadow-sm flex flex-col gap-4">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $t['image'] }}" alt="{{ $t['name'] }}"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-100">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ $t['name'] }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $t['date'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-0.5 shrink-0">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 {{ $i <= $t['rating'] ? 'text-yellow-400' : 'text-gray-200' }}"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-2">{{ $t['title'] }}</p>
                                <p class="text-sm text-gray-500 leading-relaxed">{{ $t['text'] }}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
                <button @click="next()"
                        :class="current >= max ? 'opacity-30 cursor-not-allowed' : 'hover:shadow-md hover:border-gray-400'"
                        class="absolute -right-5 top-1/2 -translate-y-1/2 z-10 w-10 h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

            </div>

            <div class="flex justify-center gap-2 mt-8">
                @for($d = 0; $d <= $testimonialsStyle2Max; $d++)
                <button @click="current = {{ $d }}"
                        :class="current === {{ $d }} ? 'bg-gray-900 w-5' : 'bg-gray-300 w-2'"
                        class="h-2 rounded-full transition-all duration-300"></button>
                @endfor
            </div>

        </section>


    @elseif ($shortcode->testimonials_style == '3')

        @once
            <link rel="stylesheet" href="{{ asset('assets/style/section/testimonials/style2.css') }}">
            <script defer src="{{ asset('assets/js/section/testimonials/style2.js') }}"></script>
        @endonce

        <section class="testimonials-style-2-instance py-20 bg-white max-md:py-14" id="reviews" data-testimonials-style2>
            <div class="ts2-container">
                <div class="ts2-reveal flex items-start justify-between mb-10 flex-wrap gap-5 max-md:mb-8">
                    <div>
                        <p class="text-[11px] font-bold tracking-[0.12em] uppercase text-[#999] mb-[10px]">Our Reviews</p>
                        <h2 class="text-[clamp(2rem,4vw,3rem)] font-extrabold tracking-[-0.04em] leading-[1.1] text-[#111] max-md:text-[clamp(1.6rem,6vw,2.2rem)]">{{ $shortcode->testimonials_title ?? 'What Our Clients Say' }}</h2>
                        @if (!empty($shortcode->testimonials_subtitle))
                            <p class="text-sm text-[#777] mt-2">{{ $shortcode->testimonials_subtitle }}</p>
                        @endif
                    </div>
                    <div class="flex gap-[10px] items-center pt-2 shrink-0">
                        <button class="ts2-prev w-[50px] h-[50px] rounded-full bg-[#888] border-none cursor-pointer flex items-center justify-center text-white text-[20px] transition-[background,transform] duration-200 shrink-0 hover:bg-[rgba(192,57,43,0.65)] hover:scale-[1.05]" aria-label="Sebelumnya">&#8592;</button>
                        <button class="ts2-next w-[50px] h-[50px] rounded-full bg-[#888] border-none cursor-pointer flex items-center justify-center text-white text-[20px] transition-[background,transform] duration-200 shrink-0 hover:bg-[rgba(192,57,43,0.65)] hover:scale-[1.05]" aria-label="Berikutnya">&#8594;</button>
                    </div>
                </div>

                <div class="ts2-wrap overflow-hidden cursor-grab active:cursor-grabbing select-none">
                    <div class="ts2-track flex gap-6 transition-transform duration-500 ease-[cubic-bezier(.4,0,.2,1)] will-change-transform">
                        @foreach($testimonialsStyle3Data as $testimonial)
                        <div class="ts2-card bg-[#f5f5f7] rounded-[20px] p-8 shrink-0 flex flex-col justify-between box-border min-h-[400px] max-md:p-6 max-md:min-h-0">
                            <div>
                                <div class="flex items-center justify-between gap-3 mb-7">
                                    <img class="w-[60px] h-[60px] rounded-full object-cover shrink-0 block" src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}">
                                    <div class="flex items-center gap-2 border-[1.5px] border-[#ddd] rounded-[980px] py-[7px] pl-[10px] pr-4 text-[12px] font-bold text-[#333] bg-white whitespace-nowrap">
                                        <span class="w-6 h-6 rounded-full bg-[#111] text-white text-[11px] font-extrabold flex items-center justify-center shrink-0 uppercase">{{ $testimonial['initials'] }}</span>
                                        {{ $testimonial['company'] }}
                                    </div>
                                </div>
                                <span class="text-[44px] text-[#4361ee] leading-[1] font-[Georgia,serif] mb-4 block">&#10077;</span>
                                <p class="text-[clamp(16px,1.6vw,20px)] font-bold leading-[1.5] text-[#111] mb-8 max-md:text-[15px]">{{ $testimonial['quote'] }}</p>
                            </div>
                            <div class="border-l-[3px] border-[#cdcdcd] pl-[14px] mt-auto">
                                <div class="text-[14px] font-bold text-[#111]">{{ $testimonial['name'] }}</div>
                                <div class="text-[12px] text-[#999] mt-[3px] leading-[1.4]">{{ $testimonial['position'] }}<br>{{ $testimonial['location'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="ts2-dots flex justify-center gap-2 mt-7"></div>
            </div>
        </section>

    @endif
@endif 