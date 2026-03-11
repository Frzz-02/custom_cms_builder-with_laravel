<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="title"       content="404 — Halaman Tidak Ditemukan">
    <meta name="description" content="Halaman yang kamu cari tidak dapat ditemukan.">

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
