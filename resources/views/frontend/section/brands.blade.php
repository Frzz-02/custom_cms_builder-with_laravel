@if ($shortcode->type == 'brands')
@php
    $rawBrandIds = $shortcode->section_brand_id ?? [];
    // $sectionBrands = !empty($brandIds)
    //     ? \App\Models\SectionBrand::whereIn('id', $brandIds)->where('status', 'active')->get()
    //     : collect();



        if (is_array($rawBrandIds)) {
            $brandIds = $rawBrandIds;
        } elseif ($rawBrandIds instanceof \Illuminate\Support\Collection) {
            $brandIds = $rawBrandIds->all();
        } elseif (is_string($rawBrandIds)) {
            $decodedIds = json_decode($rawBrandIds, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedIds)) {
                $brandIds = $decodedIds;
            } else {
                $brandIds = array_map('trim', explode(',', $rawBrandIds));
            }
        } elseif (is_numeric($rawBrandIds)) {
            $brandIds = [(int) $rawBrandIds];
        } else {
            $brandIds = [];
        }

        $brandIds = array_values(array_filter($brandIds, static function ($id) {
            return is_numeric($id) && (int) $id > 0;
        }));

        $dbBrands = collect();
        if (!empty($brandIds)) {
            $rawBrands = \App\Models\SectionBrand::whereIn('id', $brandIds)
                ->whereIn(\Illuminate\Support\Facades\DB::raw('LOWER(status)'), ['active', 'aktif'])
                ->get()
                ->keyBy('id');

            $dbBrands = collect($brandIds)
                ->map(static function ($id) use ($rawBrands) {
                    return $rawBrands->get((int) $id);
                })
                ->filter()
                ->values();
        }
        
        
        $brandData = $dbBrands->map(function ($t, $i) {
            return [
                'name'    => $t->name,
                'logo'    => $t->logo,
                'url'    => $t->url,
            ];
        })->values()->toArray();
        // dd($brandData[0]->logo);
        
@endphp

        <style>
            @keyframes scroll {
                0% {
                    transform: translateX(0);
                }
                100% {
                    transform: translateX(-50%);
                }
            }
            .animate-scroll {
                animation: scroll 30s linear infinite;
            }
            .animate-scroll:hover {
                animation-play-state: paused;
            }
        </style>




        <!-- Sponsor Section - Infinite Scroll -->
        <section class="py-12 bg-white border-y border-gray-100 overflow-hidden">
            <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24">
                <p data-reveal class="text-center text-sm text-gray-500 mb-8 tracking-wider uppercase">Dipercaya oleh berbagai perusahaan & institusi</p>
            </div>

            <!-- Infinite Scroll Container -->
            <div class="relative">
                <div class="flex animate-scroll">
                    <!-- First Set of Sponsors -->
                    <div class="flex items-center gap-16 px-8">
                        @forelse($brandData as $brand)
                            <div class="flex-shrink-0 w-32 h-16 flex items-center justify-center grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                                <img src="{{ asset('storage/' . $brand['logo']) }}" alt="{{ $brand['name'] }}" class="max-h-10 w-auto object-contain">
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-gray-400 py-8">Belum ada brand partner</div>
                        @endforelse
                    </div>
                    <!-- Duplicate Set for Seamless Loop -->
                    <div class="flex items-center gap-16 px-8">
                        @forelse($brandData as $brand)
                            <div class="flex-shrink-0 w-32 h-16 flex items-center justify-center grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100">
                                <img src="{{ asset('storage/' . $brand['logo']) }}" alt="{{ $brand['name'] }}" class="max-h-10 w-auto object-contain">
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-gray-400 py-8">Belum ada brand partner</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>














    {{-- <!-- Solusi Mitra Jogja Section - Mediterranean Style -->
    <section class="py-20 bg-white relative" data-reveal>
        <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <!-- Left Content -->
                <div class="max-w-xl">
                    <p class="text-gray-500 text-sm tracking-wide mb-4">Solusi Mitra Jogja</p>
                    <h2 class="text-4xl md:text-5xl font-light text-gray-900 leading-tight mb-6">
                        Partner Terpercaya<br>Untuk Bisnis Anda
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Kami hadir sebagai mitra terpercaya untuk memenuhi kebutuhan bisnis Anda. Dari alat tulis kantor, perlengkapan kebersihan, hingga teknologi IT — semua tersedia dengan harga kompetitif dan layanan profesional.
                    </p>
                    <a href="#produk" class="text-gray-900 text-sm font-medium hover:text-red-600 transition-colors mb-8 inline-block">
                        Read more
                    </a>
                    <div class="mt-6">
                        <a href="https://wa.me/6281316509191?text=Halo%20MitraJogja,%20saya%20ingin%20konsultasi"
                        target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center px-8 py-4 bg-[#e8e4df] hover:bg-red-600 hover:text-white text-gray-900 font-semibold text-sm tracking-wide transition-colors">
                            HUBUNGI KAMI
                            <svg class="w-4 h-4 ml-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Brands Grid -->
                <div>
                    <h3 class="text-center text-xl tracking-[0.3em] text-gray-400 font-light mb-12">BRAND PARTNER</h3>
                    <div class="grid grid-cols-3 gap-6">
                        @forelse($brandData as $brand)
                        <div class="flex items-center justify-center p-4 border border-gray-200 rounded-lg hover:border-gray-400 transition-colors">
                            @if($brand['url'])
                            <a href="{{ $brand['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $brand['name'] }}">
                                <img src="{{ asset('storage/' . $brand['logo']) }}"
                                    alt="{{ $brand['name'] }}"
                                    class="max-h-12 w-auto object-contain grayscale hover:grayscale-0 transition-all">
                            </a>
                            @else
                            <img src="{{ asset('storage/' . $brand['logo']) }}"
                                alt="{{ $brand['name'] }}"
                                class="max-h-12 w-auto object-contain grayscale hover:grayscale-0 transition-all">
                            @endif
                        </div>
                        @empty
                        <div class="col-span-3 text-center text-gray-400 py-8">Belum ada brand partner</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    
@endif

