<!DOCTYPE html>
<html lang="id">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>404 - Halaman Tidak Ditemukan | {{ $settings->site_title ?? 'ApexWorks' }}</title>
    <meta name="description" content="Halaman yang Anda cari tidak ditemukan.">
    <link rel="icon" type="image/png" href="{{ asset('storage/' . ($settings->favicon ?? 'favicon.png')) }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Fade In Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .fade-in-delay-1 { animation-delay: 0.2s; opacity: 0; }
        .fade-in-delay-2 { animation-delay: 0.4s; opacity: 0; }
        .fade-in-delay-3 { animation-delay: 0.6s; opacity: 0; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4 overflow-hidden">

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>

    <div class="relative z-10 text-center max-w-2xl mx-auto">
        <!-- 404 Number -->
        <div class="fade-in mb-8">
            <h1 class="text-9xl md:text-[200px] font-bold text-gray-900 leading-none tracking-tighter">
                404
            </h1>
        </div>

        <!-- Icon -->
        <div class="fade-in fade-in-delay-1 mb-8 flex justify-center">
            <div class="animate-float">
                <svg class="w-32 h-32 md:w-40 md:h-40 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Message -->
        <div class="fade-in fade-in-delay-2 mb-8 space-y-4">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                Oops! Halaman Tidak Ditemukan
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-md mx-auto">
                Halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau tidak pernah ada.
            </p>
        </div>

        <!-- Actions -->
        <div class="fade-in fade-in-delay-3 flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="/" 
               class="inline-flex items-center justify-center px-8 py-4 bg-gray-900 text-white font-medium tracking-wider hover:bg-gray-800 transition-colors duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                KEMBALI KE BERANDA
            </a>
            <button onclick="window.history.back()" 
                    class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-medium tracking-wider hover:border-gray-900 hover:text-gray-900 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                HALAMAN SEBELUMNYA
            </button>
        </div>

        <!-- Quick Links -->
        <div class="fade-in fade-in-delay-3 mt-12 pt-8 border-t border-gray-200">
            <p class="text-sm text-gray-500 mb-4">Atau kunjungi halaman populer lainnya:</p>
            <div class="flex flex-wrap justify-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Beranda</a>
                <span class="text-gray-300">•</span>
                <a href="#about" class="text-gray-600 hover:text-gray-900 transition-colors">Tentang Kami</a>
                <span class="text-gray-300">•</span>
                <a href="{{ route('products') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Produk</a>
                <span class="text-gray-300">•</span>
                <a href="#contact" class="text-gray-600 hover:text-gray-900 transition-colors">Kontak</a>
            </div>
        </div>
    </div>

    <!-- WhatsApp Button -->
    @if(isset($whatsappButton) && $whatsappButton->status == 'active')
    <script>
    (function() {
        var waBtn = document.createElement('a');
        waBtn.href = 'https://api.whatsapp.com/send/?phone={{ $whatsappButton->phone_number }}&text={{ urlencode($whatsappButton->message ?? 'Halo') }}&type=phone_number&app_absent=0';
        waBtn.target = '_blank';
        waBtn.rel = 'noopener noreferrer';
        waBtn.setAttribute('aria-label', 'Chat WhatsApp');
        waBtn.innerHTML = '<svg viewBox="0 0 24 24" style="width:28px;height:28px;fill:white;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';
        
        var position = '{{ $whatsappButton->position ?? "right" }}' === 'left' ? 'left' : 'right';
        var offsetX = '{{ $whatsappButton->offset_x ?? 20 }}';
        var offsetY = '{{ $whatsappButton->offset_y ?? 20 }}';
        
        waBtn.style.cssText = 'position:fixed;bottom:' + offsetY + 'px;' + position + ':' + offsetX + 'px;z-index:9999;width:56px;height:56px;background-color:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,0.15);text-decoration:none;transition:all 0.2s ease;';

        waBtn.onmouseover = function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 6px 20px rgba(37,211,102,0.4)';
        };
        waBtn.onmouseout = function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        };

        document.documentElement.appendChild(waBtn);
    })();
    </script>
    @endif

</body>
</html>


    <title>404 — Halaman Tidak Ditemukan | {{ config('app.name') }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/apex favicon.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- Tailwind & App Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'DM Sans', sans-serif; }

        body { opacity: 0; transition: opacity 0.45s ease; }
        body.ready { opacity: 1; }

        /* Giant 404 glitch text */
        .glitch {
            position: relative;
            display: inline-block;
            color: #fff;
            font-size: clamp(6rem, 20vw, 16rem);
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.04em;
        }
        .glitch::before,
        .glitch::after {
            content: attr(data-text);
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .glitch::before {
            color: #6366f1;
            animation: glitch1 3.5s infinite linear;
            clip-path: polygon(0 0, 100% 0, 100% 35%, 0 35%);
            transform: translateX(-3px);
        }
        .glitch::after {
            color: #ec4899;
            animation: glitch2 3.5s infinite linear;
            clip-path: polygon(0 60%, 100% 60%, 100% 100%, 0 100%);
            transform: translateX(3px);
        }
        @keyframes glitch1 {
            0%,90%,100% { transform: translateX(-3px) skewX(0deg); }
            92%          { transform: translateX( 4px) skewX(-2deg); }
            94%          { transform: translateX(-4px) skewX( 2deg); }
            96%          { transform: translateX( 2px) skewX(-1deg); }
        }
        @keyframes glitch2 {
            0%,90%,100% { transform: translateX(3px) skewX(0deg); }
            92%          { transform: translateX(-4px) skewX( 2deg); }
            94%          { transform: translateX( 4px) skewX(-2deg); }
            96%          { transform: translateX(-2px) skewX( 1deg); }
        }

        /* Floating shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.12;
            animation: floatShape ease-in-out infinite alternate;
        }
        @keyframes floatShape {
            from { transform: translateY(0) rotate(0deg); }
            to   { transform: translateY(-30px) rotate(15deg); }
        }

        /* Slide-up content */
        .slide-up {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .slide-up.visible { opacity: 1; transform: translateY(0); }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-950 text-gray-100 min-h-screen flex items-center justify-center overflow-hidden relative">

    <!-- Decorative floating shapes -->
    <div class="shape w-96 h-96 bg-indigo-600 top-[-8rem] left-[-8rem]" style="animation-duration:6s;"></div>
    <div class="shape w-72 h-72 bg-pink-600 bottom-[-6rem] right-[-6rem]"  style="animation-duration:8s;animation-delay:1s;"></div>
    <div class="shape w-48 h-48 bg-purple-600 top-1/3 right-1/4"          style="animation-duration:5s;animation-delay:0.5s;"></div>

    <!-- Background grid pattern -->
    <div class="absolute inset-0 opacity-5"
         style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 60px 60px;"></div>

    <!-- Content -->
    <div class="relative z-10 text-center px-6 max-w-2xl mx-auto py-20">

        <!-- Glitch number -->
        <div class="slide-up mb-6">
            <span class="glitch" data-text="404">404</span>
        </div>

        <!-- Message -->
        <div class="slide-up mb-3" data-delay="120">
            <h1 class="text-2xl sm:text-4xl font-semibold tracking-tight text-white">
                Halaman Tidak Ditemukan
            </h1>
        </div>

        <div class="slide-up mb-10" data-delay="240">
            <p class="text-base sm:text-lg text-gray-400 leading-relaxed">
                Halaman yang kamu cari mungkin telah dipindahkan, dihapus,<br class="hidden sm:block">
                atau memang tidak pernah ada.
            </p>
        </div>

        <!-- Action buttons -->
        <div class="slide-up flex flex-col sm:flex-row items-center justify-center gap-4" data-delay="360">
            <a href="{{ route('home') }}"
               class="group inline-flex items-center gap-2 bg-white text-gray-900 text-sm font-semibold tracking-wider px-8 py-4 hover:bg-gray-100 transition-colors">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Beranda
            </a>
            <a href="javascript:history.back()"
               class="inline-flex items-center gap-2 border border-white/20 text-gray-300 text-sm font-medium tracking-wider px-8 py-4 hover:border-white/50 hover:text-white transition-colors">
                Halaman Sebelumnya
            </a>
        </div>

        <!-- Search suggestion -->
        <div class="slide-up mt-12 pt-10 border-t border-white/10" data-delay="480">
            <p class="text-sm text-gray-500 mb-4">Atau cari apa yang kamu butuhkan</p>
            <form action="{{ route('produk.index') }}" method="GET"
                  class="flex items-center border-b border-white/20 focus-within:border-white/50 transition-colors max-w-sm mx-auto">
                <input type="text" name="search"
                       placeholder="Cari produk, artikel..."
                       class="flex-1 bg-transparent text-white placeholder-gray-600 text-sm py-3 outline-none">
                <button type="submit" class="text-gray-400 hover:text-white px-3 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </form>
        </div>

        @yield('content')
    </div>

    <!-- Alpine.js (for child views) -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Pure JS: page reveal + staggered slide-up -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('ready');

        var items = document.querySelectorAll('.slide-up');
        items.forEach(function (el, i) {
            var delay = parseInt(el.getAttribute('data-delay') || (i * 120), 10);
            setTimeout(function () {
                el.classList.add('visible');
            }, 80 + delay);
        });
    });
    </script>

    @stack('scripts')
</body>

</html>
