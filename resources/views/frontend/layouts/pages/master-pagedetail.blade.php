<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title', $settings->site_title ?? 'MitraCom - Page Detail')</title>
    <meta name="title" content="@yield('meta_title', $settings->site_title ?? 'Spesialis lanyard custom berkualitas. Konsultasi, bantuan desain, opsi pengiriman, dan garansi kualitas.')">
    <meta name="description" content="@yield('meta_description', $settings->site_description ?? 'Spesialis lanyard custom berkualitas. Konsultasi, bantuan desain, opsi pengiriman, dan garansi kualitas.')">
    <meta name="keywords" content="@yield('meta_keywords', $settings->site_keywords ?? 'MitraCom')">
    <link rel="icon" type="image/png" href="{{ asset('storage/' . ($settings->favicon ?? 'favicon.png')) }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('meta_title', $settings->site_title ?? 'MitraCom')">
    <meta property="og:description" content="@yield('meta_description', $settings->site_description)">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', $settings->site_title)">
    <meta name="twitter:description" content="@yield('meta_description', $settings->site_description)">

    <!-- Fonts - Optimized Loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        /* Modern Typography */
        body {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 400;
            letter-spacing: 0.01em;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Lazy Load Images */
        img[loading="lazy"] {
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        img[loading="lazy"].loaded {
            opacity: 1;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-white text-gray-900 antialiased">
    

    <!-- Navigation -->
    @include('frontend.layouts.navmenu')

    <!-- Main Content -->
    <main class="pt-14 sm:pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- WhatsApp Floating Button -->
    @if(isset($whatsappButton) && $whatsappButton->status == 'active')
    <script>
    (function() {
        var waBtn = document.createElement('a');
        waBtn.href = 'https://api.whatsapp.com/send/?phone={{ $whatsappButton->phone_number }}&text={{ urlencode($whatsappButton->message) }}&type=phone_number&app_absent=0';
        waBtn.target = '_blank';
        waBtn.rel = 'noopener noreferrer';
        waBtn.id = 'wa-floating-button';
        waBtn.setAttribute('aria-label', 'Chat WhatsApp');
        waBtn.innerHTML = '<svg viewBox="0 0 24 24" style="width:28px;height:28px;fill:white;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>';
        
        var position = '{{ $whatsappButton->position }}' === 'left' ? 'left' : 'right';
        var offsetX = '{{ $whatsappButton->offset_x }}' || '20';
        var offsetY = '{{ $whatsappButton->offset_y }}' || '20';
        
        waBtn.style.cssText = 'position:fixed;bottom:' + offsetY + 'px;' + position + ':' + offsetX + 'px;z-index:9999;width:56px;height:56px;background-color:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,0.15);text-decoration:none;transition:transform 0.2s ease,box-shadow 0.2s ease;';

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

    <!-- Scripts -->
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lazy Load Images -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            lazyImages.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback for older browsers
            lazyImages.forEach(img => img.classList.add('loaded'));
        }
    });
    </script>


    <!-- Feather Icons (TARUH DI SINI) -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
    });
    </script>
    
    
    @stack('scripts')
</body>
</html>
