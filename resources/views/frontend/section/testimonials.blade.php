@if ($shortcode->type == 'testimonials')
    @if ($shortcode->testimonials_style == 'Style 1')
        <!-- Testimonials Section -->
        <section id="testimoni" class="py-20 bg-gradient-to-b from-slate-100 to-slate-200 relative overflow-hidden" data-reveal>
            <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24 relative z-10"
                x-data="{
                    currentTestimonial: 2,
                    testimonials: [
                        {
                            name: 'Sir Didik Wenger',
                            role: 'Purchasing Manager Tech Corp',
                            text: 'MitraJogja sangat membantu untuk kebutuhan procurement kantor. Katalog lengkap, harga kompetitif, dan pengiriman cepat. Partner B2B yang sangat profesional dan terpercaya!',
                            product: 'IT Hardware',
                            avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&q=80',
                            border: 'border-violet-400'
                        },
                        {
                            name: 'Sarah Wijaya',
                            role: 'Admin Rumah Sakit',
                            text: 'Sudah 6 bulan jadi pelanggan untuk supply alat kesehatan dan kebersihan. Produk original, harga bersaing, dan CS sangat responsif. Highly recommended!',
                            product: 'Alat Kesehatan',
                            avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&q=80',
                            border: 'border-violet-300'
                        },
                        {
                            name: 'Budi Santoso',
                            role: 'Owner Toko Peralatan',
                            text: 'Sistem grosir yang fleksibel dan harga sangat kompetitif. Katalog produknya lengkap dari ATK sampai furniture. Perfect untuk reseller seperti kami!',
                            product: 'Alat Tulis Kantor',
                            avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&q=80',
                            border: 'border-sky-400'
                        },
                        {
                            name: 'Dewi Lestari',
                            role: 'Office Manager',
                            text: 'One-stop solution untuk semua kebutuhan kantor! Dari ATK, furniture, sampai cleaning supplies semua ada. Proses pemesanan mudah dan pengiriman tepat waktu!',
                            product: 'Furniture Kantor',
                            avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&q=80',
                            border: 'border-teal-300'
                        },
                        {
                            name: 'Ahmad Rizki',
                            role: 'Business Owner',
                            text: 'Pelayanan ramah dan profesional. Tim sales sangat membantu untuk konsultasi produk. Harga bulk order sangat menarik. Top service!',
                            product: 'Home Appliances',
                            avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&q=80',
                            border: 'border-amber-400'
                        }
                    ],
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
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900">Kata Mereka Tentang</h2>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900">Layanan Kami?</h2>
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
                        <p class="text-sky-600 font-semibold text-base md:text-lg" x-text="'— ' + testimonials[currentTestimonial].name"></p>
                        <p class="text-sm md:text-base text-gray-500" x-text="testimonials[currentTestimonial].role"></p>
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
                                <blockquote class="text-gray-700 text-base md:text-lg leading-relaxed mb-4" x-text="testimonials[currentTestimonial].text"></blockquote>

                                <!-- Rating Stars -->
                                <div class="flex justify-center text-yellow-400 text-lg md:text-xl mb-3 gap-0.5">
                                    <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                </div>

                                <!-- Product Badge -->
                                <span class="inline-block px-4 py-1.5 bg-sky-100 text-sky-700 text-sm md:text-base font-medium rounded-full" x-text="testimonials[currentTestimonial].product"></span>
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
                        <a href="{{ route('testimoni') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-red-600 transition-colors">
                            Lihat Semua Testimoni
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        

    @elseif ($shortcode->testimonials_style == 'Style 2')
        
    @endif
@endif