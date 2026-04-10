{{--
    master-service.blade.php
    Layout for service listing and service detail pages.
    Shares the same JS/Tailwind foundation as master-default but with
    an optional hero-style page header slot.

    Child view sections:
        @section('title', 'Layanan Kami')
        @section('description', '...')
        @section('page_header')  ← custom full-width header (replaces default)
        @section('content')  ... @endsection
--}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('page_title', $settings->site_title ?? 'MitraCom - Service')</title>
    <meta name="title" content="@yield('meta_title', $settings->site_title ?? 'Spesialis lanyard custom berkualitas. Konsultasi, bantuan desain, opsi pengiriman, dan garansi kualitas.')">
    <meta name="description" content="@yield('meta_description', $settings->site_description ?? 'Spesialis lanyard custom berkualitas. Konsultasi, bantuan desain, opsi pengiriman, dan garansi kualitas.')">
    <meta name="keywords" content="@yield('meta_keywords', $settings->site_keywords ?? 'MitraCom')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('meta_title', $settings->site_title ?? 'MitraCom')">
    <meta property="og:description" content="@yield('meta_description', $settings->site_description)">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', $settings->site_title)">
    <meta name="twitter:description" content="@yield('meta_description', $settings->site_description)">
    
    <link rel="icon" type="image/png" href="{{ asset('storage/' . ($settings->favicon ?? 'favicon.png')) }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

        /* Scroll reveal */
        .reveal {
            opacity: 0;
            transform: translateY(26px);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        .reveal-left  { opacity:0; transform:translateX(-26px); transition:opacity .65s ease,transform .65s ease; }
        .reveal-right { opacity:0; transform:translateX( 26px); transition:opacity .65s ease,transform .65s ease; }
        .reveal-left.visible,
        .reveal-right.visible { opacity:1; transform:translateX(0); }

        /* Service card hover lift */
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        /* Icon bounce on hover */
        .icon-bounce:hover {
            animation: iconBounce 0.5s ease;
        }
        @keyframes iconBounce {
            0%,100% { transform: translateY(0); }
            40%     { transform: translateY(-8px); }
            70%     { transform: translateY(-4px); }
        }

        /* Scroll-to-top */
        #scroll-top {
            position:fixed; bottom:2rem; left:2rem;
            width:44px; height:44px;
            background:#111827; color:#fff;
            border:none; cursor:pointer;
            display:flex; align-items:center; justify-content:center;
            opacity:0; transform:translateY(12px);
            transition:opacity .3s ease,transform .3s ease,background .2s ease;
            z-index:900; border-radius:2px;
        }
        #scroll-top.show  { opacity:1; transform:translateY(0); }
        #scroll-top:hover { background:#dc2626; }
    </style>

    @stack('styles')
</head>

<body class="bg-white text-gray-900 antialiased">

    <!-- Navigation -->
    @include('frontend.layouts.navmenu')

    <!-- Page Header (optional custom hero / breadcrumb) -->
    @hasSection('page_header')
        @yield('page_header')
    @else
        <section class="bg-gray-50 border-b border-gray-200 pt-20">
            <div class="w-full max-w-[1920px] mx-auto px-6 sm:px-10 lg:px-16 xl:px-24 py-10 sm:py-16">
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors">Home</a>
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-900 font-medium">@yield('breadcrumb_label', 'Layanan')</span>
                </nav>
                <h1 class="text-3xl sm:text-5xl font-semibold text-gray-900 leading-tight">
                    @yield('page_title', 'Layanan Kami')
                </h1>
                @hasSection('page_subtitle')
                    <p class="mt-4 text-lg text-gray-500 max-w-2xl">@yield('page_subtitle')</p>
                @endif
            </div>
        </section>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Scroll to Top -->
    <button id="scroll-top" aria-label="Scroll ke atas">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
    </button>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- WhatsApp Floating Button (pure JS) -->
    <script>
    (function () {
        var btn = document.createElement('a');
        btn.href   = 'https://wa.me/6281316509191?text=Halo%2C%20saya%20ingin%20tanya%20tentang%20layanan';
        btn.target = '_blank'; btn.rel = 'noopener noreferrer';
        btn.setAttribute('aria-label', 'Chat di WhatsApp');
        btn.innerHTML = '<svg viewBox="0 0 24 24" style="width:30px;height:30px;fill:white;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';
        btn.style.cssText = 'position:fixed;bottom:30px;right:30px;z-index:2147483647;width:56px;height:56px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(0,0,0,0.25);cursor:pointer;text-decoration:none;transition:transform 0.3s ease,box-shadow 0.3s ease;';
        btn.onmouseover = function () { this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.35)'; };
        btn.onmouseout  = function () { this.style.transform='scale(1)';   this.style.boxShadow='0 4px 15px rgba(0,0,0,0.25)'; };
        document.documentElement.appendChild(btn);
    })();
    </script>

    <!-- Pure JS: page reveal + scroll-reveal + scroll-to-top -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('page-ready');

        var els = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
        if ('IntersectionObserver' in window && els.length) {
            var obs = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) {
                        var d = parseInt(e.target.getAttribute('data-delay') || '0', 10);
                        setTimeout(function () { e.target.classList.add('visible'); }, d);
                        obs.unobserve(e.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
            els.forEach(function (el) { obs.observe(el); });
        } else {
            els.forEach(function (el) { el.classList.add('visible'); });
        }

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

    @stack('scripts')
</body>

</html>
