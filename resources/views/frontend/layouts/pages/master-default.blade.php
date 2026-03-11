<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title"       content="@yield('title', config('app.name'))">
    <meta name="description" content="@yield('description', '')">
    <meta name="keywords"    content="@yield('keywords', '')">
    <meta name="theme-color" content="#4f46e5">

    <!-- Open Graph -->
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', '')">

    <!-- Twitter Card -->
    <meta property="twitter:card"        content="summary_large_image">
    <meta property="twitter:title"       content="@yield('title', config('app.name'))">
    <meta property="twitter:description" content="@yield('description', '')">

    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/apex favicon.jpeg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind & App Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        body {
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        body.page-ready { opacity: 1; }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'DM Sans', sans-serif;
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        /* Scroll reveal — add class="reveal" / "reveal-left" / "reveal-right" to elements */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .reveal-left {
            opacity: 0;
            transform: translateX(-28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }

        .reveal-right {
            opacity: 0;
            transform: translateX(28px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }

        /* Stagger helper: add data-delay="150" etc. to set per-element delay (ms) */

        /* Scroll-to-top button */
        #scroll-top {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            width: 44px;
            height: 44px;
            background: #111827;
            color: #fff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(12px);
            transition: opacity 0.3s ease, transform 0.3s ease, background 0.2s ease;
            z-index: 900;
            border-radius: 2px;
        }
        #scroll-top.show  { opacity: 1; transform: translateY(0); }
        #scroll-top:hover { background: #dc2626; }
    </style>

    @stack('styles')
</head>

<body class="bg-white text-gray-900 antialiased">

    <!-- Navigation -->
    @include('frontend.layouts.navmenu')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Scroll to Top -->
    <button id="scroll-top" aria-label="Scroll ke atas">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 15l-6-6-6 6"/>
        </svg>
    </button>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- WhatsApp Floating Button (pure JS) -->
    <script>
    (function () {
        var btn = document.createElement('a');
        btn.href   = 'https://wa.me/6281316509191?text=Halo%2C%20saya%20ingin%20konsultasi';
        btn.target = '_blank';
        btn.rel    = 'noopener noreferrer';
        btn.setAttribute('aria-label', 'Chat di WhatsApp');
        btn.innerHTML = '<svg viewBox="0 0 24 24" style="width:30px;height:30px;fill:white;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';
        btn.style.cssText = 'position:fixed;bottom:30px;right:30px;z-index:2147483647;width:56px;height:56px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(0,0,0,0.25);cursor:pointer;text-decoration:none;transition:transform 0.3s ease,box-shadow 0.3s ease;';
        btn.onmouseover = function () { this.style.transform = 'scale(1.1)'; this.style.boxShadow = '0 6px 20px rgba(0,0,0,0.35)'; };
        btn.onmouseout  = function () { this.style.transform = 'scale(1)';   this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.25)'; };
        document.documentElement.appendChild(btn);
    })();
    </script>

    <!-- Pure JS: page reveal + scroll-reveal + flash toast + scroll-to-top -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // ── Page fade-in ──────────────────────────────────────────────────────
        document.body.classList.add('page-ready');

        // ── Scroll-reveal with IntersectionObserver ──────────────────────────
        var els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
        if ('IntersectionObserver' in window && els.length) {
            var obs = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) {
                        var delay = parseInt(e.target.getAttribute('data-delay') || '0', 10);
                        setTimeout(function () { e.target.classList.add('visible'); }, delay);
                        obs.unobserve(e.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            els.forEach(function (el) { obs.observe(el); });
        } else {
            els.forEach(function (el) { el.classList.add('visible'); });
        }

        // ── Flash toast auto-dismiss ───────────────────────────────────────
        var flash = document.getElementById('js-flash');
        if (flash) {
            flash.style.cssText = 'position:fixed;top:1.25rem;right:1.25rem;z-index:9999;max-width:340px;transition:opacity 0.4s ease,transform 0.4s ease;';
            setTimeout(function () {
                flash.style.opacity = '0';
                flash.style.transform = 'translateX(20px)';
                setTimeout(function () { if (flash.parentNode) flash.parentNode.removeChild(flash); }, 420);
            }, 4000);
        }

        // ── Scroll-to-top button ──────────────────────────────────────────
        var scrollBtn = document.getElementById('scroll-top');
        if (scrollBtn) {
            window.addEventListener('scroll', function () {
                scrollBtn.classList.toggle('show', window.scrollY > 400);
            }, { passive: true });
            scrollBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    });
    </script>

    {{-- Flash / session messages --}}
    @if ($errors->any())
        <div id="js-flash" class="bg-red-600 text-white text-sm px-5 py-3 shadow-xl rounded-sm">
            <p class="font-semibold mb-1">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @elseif (session('success'))
        <div id="js-flash" class="bg-green-600 text-white text-sm px-5 py-3 shadow-xl rounded-sm">
            ✓ {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div id="js-flash" class="bg-red-600 text-white text-sm px-5 py-3 shadow-xl rounded-sm">
            ✕ {{ session('error') }}
        </div>
    @endif

    @stack('scripts')
</body>

</html>
