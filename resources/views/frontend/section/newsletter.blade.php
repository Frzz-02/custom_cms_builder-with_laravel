@if ($shortcode->type == 'newsletter')

    <section class="w-full px-8 md:px-16 py-10 bg-white reveal">

        <div class="relative overflow-hidden bg-gray-900 px-10 md:px-16 py-14 flex flex-col md:flex-row items-center justify-between gap-10">

            {{-- Decorative Blobs --}}
            <div class="absolute -top-16 -left-16 w-64 h-64 rounded-full bg-gray-400 opacity-10 pointer-events-none blur-2xl"></div>
            <div class="absolute -bottom-16 -right-16 w-64 h-64 rounded-full bg-gray-400 opacity-10 pointer-events-none blur-2xl"></div>

            {{-- Left: Text --}}
            <div class="relative z-10 max-w-lg">
                <span class="inline-block bg-gray-400/20 text-gray-400 text-xs font-bold tracking-widest uppercase px-3 py-1 rounded-full mb-4">
                    Newsletter
                </span>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white leading-tight mb-3">
                    Ingin Tahu Lebih Banyak<br>
                    tentang Kebutuhan <span class="text-gray-400">TKDN</span> Kami?
                </h2>
                <p class="text-gray-400 text-sm leading-relaxed max-w-md">
                    Dapatkan informasi terbaru seputar produk lokal unggulan, promo eksklusif, dan update TKDN langsung di kotak masuk Anda. Subscribe sekarang dan jadilah yang pertama tahu!
                </p>
            </div>

            {{-- Right: Subscribe Form --}}
            <div class="relative z-10 w-full md:w-auto flex-shrink-0 md:min-w-[380px]"
                x-data="{ email: '', sent: false }">
                <div x-show="!sent">
                    <p class="text-gray-400 text-xs mb-3">Masukkan email Anda untuk mulai berlangganan</p>
                    <div class="flex items-center bg-white/10 border border-white/20 rounded-full px-2 py-2 gap-2 focus-within:border-gray-400 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 ml-2 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input
                            type="email"
                            x-model="email"
                            placeholder="email@contoh.com"
                            class="flex-1 bg-transparent text-sm text-white placeholder-gray-500 outline-none py-1 min-w-0">
                        <button
                            @click="if(email) sent = true"
                            class="bg-gray-400 hover:bg-red-300 text-gray-900 text-sm font-bold px-5 py-2.5 rounded-full transition-colors shrink-0">
                            Subscribe
                        </button>
                    </div>
                    <p class="text-gray-500 text-[11px] mt-3">
                        Kami menghargai privasi Anda. Berhenti berlangganan kapan saja.
                    </p>
                </div>
                {{-- Success State --}}
                <div x-show="sent" x-transition class="flex flex-col items-center justify-center text-center py-6 gap-3">
                    <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-white font-bold text-base">Terima kasih telah subscribe!</p>
                    <p class="text-gray-400 text-sm">Kami akan segera mengirimkan info terbaru ke email Anda.</p>
                </div>
            </div>

        </div>

    </section>
    
@endif