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
                <a href="/" class="text-gray-600 hover:text-gray-900 transition-colors">Beranda</a>
                <span class="text-gray-300">•</span>
                <a href="/tentang-kami" class="text-gray-600 hover:text-gray-900 transition-colors">Tentang Kami</a>
                <span class="text-gray-300">•</span>
                <a href="/produk" class="text-gray-600 hover:text-gray-900 transition-colors">Produk</a>
                <span class="text-gray-300">•</span>
                <a href="/kontak" class="text-gray-600 hover:text-gray-900 transition-colors">Kontak</a>
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


    <meta property="og:type" content="website">
    {{-- <meta property="og:url" content="site_url"> --}}
    <meta property="og:title" content="{{ $settings->site_title }}">
    <meta property="og:description" content="{{ $settings->site_description }}">
    {{-- <meta property="og:image" content="{{ asset('assets/images/thumbnail.webp') }}"> --}}

    {{-- <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://site_url.com"> --}}
    <meta property="twitter:title" content="{{ $settings->site_title }}">
    <meta property="twitter:description" content="{{ $settings->site_description }}">
    {{-- <meta property="twitter:image" content="{{ asset('assets/images/thumbnail.webp') }}"> --}}

    <title>{{ $settings->site_title }}</title>

    <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-icons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/theme-vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('revolution/css/settings.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('revolution/css/layers.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('revolution/css/navigation.css') }}">

</head>

<body>
    <style>
        .whatsapp-button {
            position: fixed;
            bottom: {{ old('offset_y', $whatsappButton->offset_y) }}px;

            @if ($whatsappButton->position == 'right')
                right: {{ old('offset_x', $whatsappButton->offset_x) }}px;
            @else
                left: {{ old('offset_x', $whatsappButton->offset_x) }}px;
            @endif
            background-color: #25D366;
            border-radius: 50%;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .whatsapp-button img {
            width: 45px;
            height: 45px;
            display: block;
        }

        .whatsapp-button:hover {
            background-color: #128C7E;
        }
    </style>

    @if ($whatsappButton && $whatsappButton->status == 'active')
        <a href="https://api.whatsapp.com/send/?phone={{ $whatsappButton->phone_number }}&text={{ $whatsappButton->message }}&type=phone_number&app_absent=0"
            class="whatsapp-button" target="_blank" aria-label="Chat with us on WhatsApp">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
        </a>
    @endif

    {{-- @include('frontend.layouts.navbar') --}}

    {{-- @include('frontend.layouts.navmenu') --}}

    {{-- <div class="modal fade search-area" id="search-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form>
                    <input type="text" placeholder="Search here...">
                    <button class="search-btn"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div> --}}

    @yield('content')

    {{-- @include('frontend.layouts.footer') --}}

    <a class="scroll-top-arrow" href="javascript:void(0);"><i class="feather icon-feather-arrow-up"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script>
        @if ($errors->any())
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: "error",
                title: "FAIL!",
                html: `
                <ul style="text-align: left; margin: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
                showConfirmButton: false,
                timer: 5000,
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        @elseif (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: "success",
                title: "SUCCESS",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        @elseif (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: "error",
                title: "FAIL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        @endif
    </script> --}}

    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/theme-vendors.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

    <script type="text/javascript" src="{{ asset('revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('revolution/js/jquery.themepunch.revolution.min.js') }}"></script>

    <!-- slider revolution 5.0 extensions (load extensions only on local file systems ! the following part can be removed on server for on demand loading) -->
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.actions.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.carousel.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.kenburn.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.migration.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.navigation.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.parallax.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.slideanims.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('revolution/js/extensions/revolution.extension.video.min.js') }}">
    </script>

    <script type="text/javascript">
        var revapi349;
        $(document).ready(function() {
            if ($("#rev_slider_27_1").revolution === undefined) {
                revslider_showDoubleJqueryError("#rev_slider_27_1");
            } else {
                revapi349 = $("#rev_slider_27_1").show().revolution({
                    sliderType: "standard",
                    jsFileLocation: "revolution/js/",
                    sliderLayout: "fullscreen",
                    dottedOverlay: "none",
                    delay: 9000,
                    navigation: {
                        keyboardNavigation: "off",
                        keyboard_direction: "horizontal",
                        mouseScrollNavigation: "off",
                        mouseScrollReverse: "reverse",
                        onHoverStop: "off",
                        arrows: {
                            enable: true,
                            style: "metis",
                            hide_onmobile: false,
                            hide_under: 0,
                            hide_onleave: false,
                            tmp: '',
                            left: {
                                h_align: "right",
                                v_align: "bottom",
                                h_offset: 90,
                                v_offset: 261,
                            },
                            right: {
                                h_align: "right",
                                v_align: "bottom",
                                h_offset: 90,
                                v_offset: 193
                            }
                        },
                        touch: {
                            touchenabled: 'on',
                            swipe_threshold: 20,
                            swipe_min_touches: 1,
                            swipe_direction: 'horizontal',
                            drag_block_vertical: true

                        }
                    },
                    responsiveLevels: [1240, 1025, 778, 480],
                    visibilityLevels: [1240, 1025, 778, 480],
                    gridwidth: [1240, 1024, 778, 480],
                    gridheight: [950, 500, 560, 500],
                    lazyType: "none",
                    shadow: 0,
                    spinner: "spinner3",
                    stopLoop: "off",
                    stopAfterLoops: -1,
                    stopAtSlide: -1,
                    shuffle: "off",
                    autoHeight: "off",
                    fullScreenAutoWidth: "on",
                    fullScreenAlignForce: "off",
                    fullScreenOffsetContainer: "",
                    fullScreenOffset: "100px",
                    hideThumbsOnMobile: "off",
                    hideSliderAtLimit: 0,
                    hideCaptionAtLimit: 0,
                    hideAllCaptionAtLilmit: 0,
                    debugMode: false,
                    fallbacks: {
                        simplifyAll: "off",
                        nextSlideOnWindowFocus: "off",
                        disableFocusListener: false
                    }
                });
            }
        });
    </script>

</body>

</html>
