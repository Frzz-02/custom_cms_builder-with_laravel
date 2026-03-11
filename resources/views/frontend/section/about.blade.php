@if ($shortcode->type == 'about us')
    @if ($shortcode->about_style == 'Style 1')
    @php
        $aboutSection = $shortcode->about;
        // Helper: resolve image URL based on type (url = direct, upload = from storage)
        $aboutImg = function($source, $type) {
            if (!$source) return null;
            return ($type === 'url') ? $source : asset('storage/' . $source);
        };
    @endphp
        
        <section class="py-20 bg-gray-100">
            <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24" data-reveal>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                    <!-- Left Column - Image Collage -->
                    <div class="relative">
                        <!-- Image Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Top Left Image -->
                            <div class="relative">
                                <img src="{{ $aboutSection ? $aboutImg($aboutSection->image_1_source, $aboutSection->image_1_type) : asset('images/hero/send.jpg') }}"
                                    alt="{{ $aboutSection ? ($aboutSection->image_1_alt ?? 'Image 1') : 'Proses Pengiriman' }}"
                                    class="w-full h-48 object-cover shadow-lg">
                            </div>
                            <!-- Top Right Image (Larger) -->
                            <div class="row-span-2">
                                <img src="{{ $aboutSection ? $aboutImg($aboutSection->image_2_source, $aboutSection->image_2_type) : 'https://images.unsplash.com/photo-1553877522-43269d4ea984?w=600&q=80' }}"
                                    alt="{{ $aboutSection ? ($aboutSection->image_2_alt ?? 'Image 2') : 'Mitra Bisnis Terpercaya' }}"
                                    class="w-full h-full object-cover shadow-lg" style="min-height: 400px;">
                            </div>
                            <!-- Bottom Left Image -->
                            <div class="relative">
                                <img src="{{ $aboutSection ? $aboutImg($aboutSection->image_3_source, $aboutSection->image_3_type) : asset('images/hero/print.jpg') }}"
                                    alt="{{ $aboutSection ? ($aboutSection->image_3_alt ?? 'Image 3') : 'Solusi Bisnis' }}"
                                    class="w-full h-48 object-cover shadow-lg">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Content -->
                    <div>
                        <!-- Label -->
                        <span class="text-sm font-medium text-gray-500 tracking-widest uppercase mb-4 block">
                            {{ $aboutSection ? $aboutSection->section_label : 'KEUNGGULAN KAMI' }}
                        </span>

                        <!-- Heading -->
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                            {{ $aboutSection ? $aboutSection->section_title : 'Keterangan Produk' }}
                        </h2>

                        <!-- Description -->
                        <p class="text-gray-600 leading-relaxed mb-8">
                            {{ $aboutSection ? $aboutSection->section_description : 'Kami mengutamakan kualitas dan kepuasan pelanggan. Dengan katalog produk lengkap dan mitra brand terpercaya, setiap produk yang kami distribusikan memiliki kualitas terjamin dengan harga kompetitif untuk mendukung kebutuhan bisnis Anda.' }}
                        </p>

                        <!-- Features Label -->
                        <h4 class="font-bold text-gray-900 mb-6">
                            {{ $aboutSection ? $aboutSection->benefit_title : 'Keunggulan produk kami:' }}
                        </h4>

                        <!-- Features Checklist - 2 Columns -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                @if($aboutSection)
                                    @if($aboutSection->benefit_1_enabled && $aboutSection->benefit_1_text)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $aboutSection->benefit_1_text }}</span>
                                    </div>
                                    @endif
                                    @if($aboutSection->benefit_2_enabled && $aboutSection->benefit_2_text)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $aboutSection->benefit_2_text }}</span>
                                    </div>
                                    @endif
                                    @if($aboutSection->benefit_3_enabled && $aboutSection->benefit_3_text)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $aboutSection->benefit_3_text }}</span>
                                    </div>
                                    @endif
                                @else
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                                    </svg>
                                    <span class="text-gray-700">Katalog Lengkap</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-gray-700">Pengiriman Cepat</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                    </svg>
                                    <span class="text-gray-700">Gratis Ongkir Indonesia</span>
                                </div>
                                @endif
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                @if($aboutSection)
                                    @if($aboutSection->benefit_4_enabled && $aboutSection->benefit_4_text)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $aboutSection->benefit_4_text }}</span>
                                    </div>
                                    @endif
                                    @if($aboutSection->benefit_5_enabled && $aboutSection->benefit_5_text)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $aboutSection->benefit_5_text }}</span>
                                    </div>
                                    @endif
                                    @if($aboutSection->benefit_6_enabled && $aboutSection->benefit_6_text)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="text-gray-700">{{ $aboutSection->benefit_6_text }}</span>
                                    </div>
                                    @endif
                                @else
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <span class="text-gray-700">Produk Original</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                    </svg>
                                    <span class="text-gray-700">Harga Terbaik</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                                    </svg>
                                    <span class="text-gray-700">Brand Terpercaya</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        
        
        
        
        
        
        

    @elseif ($shortcode->about_style == 'Style 2')

        


    
    
    
    
    
    
    
    
    @elseif ($shortcode->about_style == 'Style 3')

    
    
    @endif
@endif