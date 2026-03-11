<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow">
    <meta name="title"       content="@yield('title', config('app.name'))">
    <meta name="description" content="@yield('description', 'Kami sedang mempersiapkan sesuatu yang luar biasa.')">

    <meta property="og:type"        content="website">
    <meta property="og:title"       content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', '')">

    <title>@yield('title', 'Coming Soon — ' . config('app.name'))</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/apex favicon.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- Tailwind & App Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'DM Sans', sans-serif; }

        /* Page fade-in */
        body { opacity: 0; transition: opacity 0.5s ease; }
        body.ready { opacity: 1; }

        /* Animated gradient background */
        .bg-animated {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #0c1445 65%, #0f172a 100%);
            background-size: 400% 400%;
            animation: gradientShift 14s ease infinite;
        }
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating particle dots */
        .particle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            animation: floatUp linear infinite;
        }
        @keyframes floatUp {
            0%   { transform: translateY(110vh) scale(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-120px) scale(1); opacity: 0; }
        }

        /* Countdown flip pulse */
        .cd-pulse {
            animation: countPulse 0.18s ease-out;
        }
        @keyframes countPulse {
            0%   { transform: scale(1.2); opacity: 0.6; }
            100% { transform: scale(1);   opacity: 1; }
        }

        /* Staggered slide-up reveal */
        .slide-up {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .slide-up.visible { opacity: 1; transform: translateY(0); }
    </style>

    @stack('styles')
</head>

<body class="bg-animated min-h-screen flex items-center justify-center overflow-hidden relative">

    <!-- Floating Particles (injected by JS) -->
    <div id="particles-container" class="absolute inset-0 pointer-events-none overflow-hidden"></div>

    <!-- Glowing orbs -->
    <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Content -->
    <div class="relative z-10 w-full text-center px-6 max-w-3xl mx-auto py-10">

        {{-- Child view can completely override via @section('content'),
             or add extra content below the default hero via @section('extra_content') --}}
        @hasSection('content')
            @yield('content')
        @else
            <!-- Brand / Logo -->
            <div class="slide-up mb-8">
                <p class="text-xs tracking-[0.45em] text-indigo-300 uppercase mb-3">Coming Soon</p>
                <h1 class="text-5xl sm:text-7xl font-bold text-white tracking-tight leading-none">
                    {{ config('app.name') }}
                </h1>
                <div class="w-16 h-px bg-indigo-400 mx-auto mt-6"></div>
            </div>

            <!-- Tagline -->
            <p class="slide-up text-lg sm:text-xl text-gray-300 leading-relaxed mb-12"
               data-delay="150">
                Kami sedang mempersiapkan sesuatu yang luar biasa.<br class="hidden sm:block">
                Nantikan peluncurannya!
            </p>

            <!-- Countdown -->
            <div class="slide-up mb-12" data-delay="300">
                <div id="countdown" class="flex justify-center gap-3 sm:gap-8">
                    <div class="text-center">
                        <div id="cd-days"    class="text-5xl sm:text-7xl font-bold text-white tabular-nums leading-none">00</div>
                        <p class="text-xs tracking-[0.25em] text-gray-500 uppercase mt-2">Hari</p>
                    </div>
                    <span class="text-4xl sm:text-6xl font-bold text-indigo-500 self-start pt-0.5">:</span>
                    <div class="text-center">
                        <div id="cd-hours"   class="text-5xl sm:text-7xl font-bold text-white tabular-nums leading-none">00</div>
                        <p class="text-xs tracking-[0.25em] text-gray-500 uppercase mt-2">Jam</p>
                    </div>
                    <span class="text-4xl sm:text-6xl font-bold text-indigo-500 self-start pt-0.5">:</span>
                    <div class="text-center">
                        <div id="cd-minutes" class="text-5xl sm:text-7xl font-bold text-white tabular-nums leading-none">00</div>
                        <p class="text-xs tracking-[0.25em] text-gray-500 uppercase mt-2">Menit</p>
                    </div>
                    <span class="text-4xl sm:text-6xl font-bold text-indigo-500 self-start pt-0.5">:</span>
                    <div class="text-center">
                        <div id="cd-seconds" class="text-5xl sm:text-7xl font-bold text-white tabular-nums leading-none">00</div>
                        <p class="text-xs tracking-[0.25em] text-gray-500 uppercase mt-2">Detik</p>
                    </div>
                </div>
            </div>

            <!-- Email notify form -->
            <div class="slide-up" data-delay="450">
                <p class="text-sm text-gray-500 mb-4">Beritahu saya saat website live</p>
                <form class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto"
                      onsubmit="handleNotify(event)">
                    <input type="email"
                           placeholder="email@anda.com"
                           class="w-full sm:flex-1 bg-white/10 border border-white/20 text-white placeholder-gray-600 px-5 py-3 text-sm focus:outline-none focus:border-indigo-400 transition-colors backdrop-blur-sm"
                           required>
                    <button type="submit"
                            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold tracking-wider px-8 py-3 transition-colors">
                        NOTIFY ME
                    </button>
                </form>
                <p id="notify-msg" class="mt-3 text-sm text-green-400 hidden">
                    ✓ Terima kasih! Kami akan menghubungi Anda.
                </p>
            </div>
        @endif

        @yield('extra_content')
    </div>

    <!-- Alpine.js (for child views that may need it) -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Pure JS: Page reveal + Particles + Countdown -->
    <script>
    // ── Page reveal ────────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('ready');

        // Staggered slide-up
        var slides = document.querySelectorAll('.slide-up');
        slides.forEach(function (el, i) {
            setTimeout(function () {
                el.classList.add('visible');
            }, 120 + i * 150);
        });

        // ── Floating particles ───────────────────────────────────────────────
        var container = document.getElementById('particles-container');
        if (container) {
            for (var i = 0; i < 28; i++) {
                (function () {
                    var p   = document.createElement('div');
                    p.className = 'particle';
                    var sz  = Math.random() * 7 + 3;
                    p.style.width    = sz + 'px';
                    p.style.height   = sz + 'px';
                    p.style.left     = Math.random() * 100 + '%';
                    p.style.animationDuration  = (Math.random() * 18 + 10) + 's';
                    p.style.animationDelay     = (Math.random() * 14) + 's';
                    container.appendChild(p);
                })();
            }
        }
    });

    // ── Countdown Timer ────────────────────────────────────────────────────────
    (function () {
        var launchDate = new Date('@yield("launch_date", "2026-09-01T00:00:00")').getTime();
        if (isNaN(launchDate)) { launchDate = new Date('2026-09-01T00:00:00').getTime(); }

        function pad(n) { return String(n).padStart(2, '0'); }

        function pulse(id, val) {
            var el = document.getElementById(id);
            if (!el) return;
            var fmt = pad(val);
            if (el.textContent !== fmt) {
                el.textContent = fmt;
                el.classList.remove('cd-pulse');
                void el.offsetWidth;
                el.classList.add('cd-pulse');
            }
        }

        function tick() {
            var diff = launchDate - Date.now();
            if (diff < 0) diff = 0;
            pulse('cd-days',    Math.floor(diff / 86400000));
            pulse('cd-hours',   Math.floor((diff % 86400000) / 3600000));
            pulse('cd-minutes', Math.floor((diff % 3600000) / 60000));
            pulse('cd-seconds', Math.floor((diff % 60000) / 1000));
        }

        tick();
        setInterval(tick, 1000);
    })();

    // ── Notify form ────────────────────────────────────────────────────────────
    function handleNotify(e) {
        e.preventDefault();
        var msg = document.getElementById('notify-msg');
        if (msg) { msg.classList.remove('hidden'); e.target.reset(); }
    }
    </script>

    @stack('scripts')
</body>

</html>
