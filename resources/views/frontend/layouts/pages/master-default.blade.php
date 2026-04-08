<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#0094e2">
    
    <!-- SEO Meta Tags -->
    <title>{{ $page->meta_title }}</title>
    <meta name="title" content="{{ $page->meta_title }}">
    <meta name="description" content="{{ $page->meta_description }}">
    <meta name="keywords" content="{{ $page->meta_keywords }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $page->meta_title }}">
    <meta property="og:description" content="{{ $page->meta_description }}">
    @if($settings->logo ?? null)
    <meta property="og:image" content="{{ asset('storage/' . $settings->logo) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $page->meta_title }}">
    <meta property="twitter:description" content="{{ $page->meta_description }}">
    @if($settings->logo ?? null)
        <meta property="twitter:image" content="{{ asset('storage/' . $settings->logo) }}">
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">

    <!-- Fonts - Optimized Loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    
    
    <!-- Font Awesome - Deferred Loading -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
          media="print" onload="this.media='all'; this.onload=null;">
    <noscript>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </noscript>

    <!-- Alpine.js - Deferred -->
    <!-- Scripts - Load Alpine.js first -->
    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Tailwind CSS -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
    
    
    <style>
       [x-cloak] { display: none !important; }

        
        
        /* Lazy Loading Images */
        img[data-src] {
            opacity: 0;
            transition: opacity 0.3s ease-in;
        }
        
        img[data-src].loaded {
            opacity: 1;
        }

        /* Scroll to Top Button */
        .scroll-top-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 3rem;
            height: 3rem;
            background: linear-gradient(135deg, #0094e2 0%, #0077b6 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 148, 226, 0.3);
            z-index: 999;
        }
        
        .scroll-top-btn.show {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-top-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 148, 226, 0.4);
        }

        /* Accessibility - Skip to Content */
        .skip-to-content {
            position: absolute;
            top: -100px;
            left: 0;
            background: #0094e2;
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            z-index: 9999;
        }
        
        .skip-to-content:focus {
            top: 0;
        }

        /* Reduced Motion Support */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

    </style>
</head>

<body class="mitracom-page">
    
    
    
{{-- bg-gray-50 text-gray-800 antialiased --}}
    <!-- Skip to Content Link for Accessibility -->
    <a href="#main-content" class="skip-to-content">Skip to content</a>
    
{{-- {{ dd($layout) }} --}}
    <!-- Navigation Menu -->
    @include('frontend.layouts.navmenu')

    <!-- Main Content -->
    <main id="main-content" class="min-h-screen pt-14 sm:pt-20">
        {{-- {{ $page->header_style }} --}}
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layouts.footer')

    <!-- Scroll to Top Button -->
    <button class="scroll-top-btn" id="scrollTopBtn" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- WhatsApp Button -->
    <div id="whatsapp-container"></div>

    <!-- SweetAlert2 for Notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- WhatsApp Floating Button (pure JS) -->
    <script>
        // SweetAlert Notifications
        @if ($errors->any())
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: "error",
                title: "FAIL!",
                html: `
                    <ul style="text-align: left; margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        @elseif (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: "success",
                title: "SUCCESS",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @elseif (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: "error",
                title: "FAIL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>

    <script>
        // Lazy Loading Images with Intersection Observer
        document.addEventListener('DOMContentLoaded', function() {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px',
                threshold: 0.01
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        });

        // Scroll to Top Button
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.add('show');
            } else {
                scrollTopBtn.classList.remove('show');
            }
        });
        
        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // WhatsApp Button - Dynamic Creation
        @if ($whatsappButton && $whatsappButton->status == 'active')
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('whatsapp-container');
            const position = '{{ $whatsappButton->position }}';
            const offsetX = {{ $whatsappButton->offset_x ?? 20 }};
            const offsetY = {{ $whatsappButton->offset_y ?? 20 }};
            const phoneNumber = '{{ $whatsappButton->phone_number }}';
            const message = '{{ $whatsappButton->message }}';
            
            const whatsappBtn = document.createElement('a');
            whatsappBtn.href = `https://api.whatsapp.com/send/?phone=${phoneNumber}&text=${encodeURIComponent(message)}&type=phone_number&app_absent=0`;
            whatsappBtn.target = '_blank';
            whatsappBtn.rel = 'noopener noreferrer';
            whatsappBtn.setAttribute('aria-label', 'Chat with us on WhatsApp');
            whatsappBtn.className = 'fixed z-[1000] transition-all duration-300 hover:scale-110';
            whatsappBtn.style.cssText = `
                ${position === 'right' ? 'right' : 'left'}: ${offsetX}px;
                bottom: ${offsetY}px;
            `;
            
            whatsappBtn.innerHTML = `
                <div class="bg-[#25D366] rounded-full p-3 shadow-lg hover:bg-[#128C7E] transition-colors duration-300">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" 
                         alt="WhatsApp" 
                         class="w-10 h-10 sm:w-12 sm:h-12 block">
                </div>
            `;
            
            container.appendChild(whatsappBtn);
        });
        @endif

        // Smooth Scroll for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
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


    <script src="https://unpkg.com/feather-icons"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
    });
    </script>
    
    
    @stack('scripts')
</body>

</html>
