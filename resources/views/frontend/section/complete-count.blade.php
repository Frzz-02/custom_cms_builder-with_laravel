@if ($shortcode->type == 'complete-counts')
@php
    $rawCountIds = $shortcode->section_completecount_id ?? [];
    $title = $shortcode->title ?? 'Solusi Mitra Jogja';
    $subtitle = $shortcode->subtitle ?? 'Partner Terpercaya Untuk Bisnis Anda';
    $description = $shortcode->content ?? 'Kami hadir sebagai mitra terpercaya untuk memenuhi kebutuhan bisnis Anda. Dari alat tulis kantor, perlengkapan kebersihan, hingga teknologi IT — semua tersedia dengan harga kompetitif dan layanan profesional.';


    if (is_array($rawCountIds)) {
        $countIds = $rawCountIds;
    } elseif ($rawCountIds instanceof \Illuminate\Support\Collection) {
        $countIds = $rawCountIds->all();
    } elseif (is_string($rawCountIds)) {
        $decodedCountIds = json_decode($rawCountIds, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedCountIds)) {
            $countIds = $decodedCountIds;
        } else {
            $countIds = array_map('trim',  explode(',', $rawCountIds));
        }
    } elseif (is_numeric($rawCountIds)) {
        $countIds = [(int) $rawCountIds];
    } else {
        $countIds = [];
    }

    $countIds = array_values(array_filter($countIds, static function ($id) {
        return is_numeric($id) && (int) $id > 0;
    }));

    $completeCounts = !empty($countIds)
        ? \App\Models\SectionCompletecount::whereIn('id', $countIds)->where('status', 'active')->get()
        : collect();
@endphp

    {{-- {{ dd($completeCounts) }} --}}

    <!-- Solusi Mitra Jogja Section - Mediterranean Style -->
    <section class="py-20 bg-white relative" data-reveal>
        <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <!-- Left Content -->
                <div class="max-w-xl">
                    <p class="text-gray-500 text-sm tracking-wide mb-4">{{ $title }}</p>
                    <h2 class="text-4xl md:text-5xl font-light text-gray-900 leading-tight mb-6">
                        {{ $subtitle }}
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        {{ $description }}
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

                <!-- Right Benefits Grid -->
                <div>
                    <h3 class="text-center text-xl tracking-[0.3em] text-gray-400 font-light mb-12">BENEFITS</h3>
                    <div class="grid grid-cols-2 gap-x-12 gap-y-8">
                        @forelse($completeCounts as $count)
                            <div class="text-center">
                                <div class="border-t border-gray-300 pt-4 mb-3">
                                    <svg class="w-6 h-6 mx-auto text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 text-sm font-semibold">{{ $count->amount ? number_format($count->amount) . '+' : '' }}</p>
                                <p class="text-gray-700 text-sm">{{ $count->title }}</p>
                            </div>
                        @empty
                            <div class="text-center">
                                <div class="border-t border-gray-300 pt-4 mb-3">
                                    <svg class="w-6 h-6 mx-auto text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 text-sm">Pengiriman Cepat</p>
                            </div>
                            <div class="text-center">
                                <div class="border-t border-gray-300 pt-4 mb-3">
                                    <svg class="w-6 h-6 mx-auto text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 text-sm">1250+ Klien Puas</p>
                            </div>
                            <div class="text-center">
                                <div class="border-t border-gray-300 pt-4 mb-3">
                                    <svg class="w-6 h-6 mx-auto text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 text-sm">Garansi Resmi</p>
                            </div>
                            <div class="text-center">
                                <div class="border-t border-gray-300 pt-4 mb-3">
                                    <svg class="w-6 h-6 mx-auto text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 text-sm">Produk Original</p>
                            </div>
                            <div class="text-center">
                                <div class="border-t border-gray-300 pt-4 mb-3">
                                    <svg class="w-6 h-6 mx-auto text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-700 text-sm">Harga Kompetitif</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endif

