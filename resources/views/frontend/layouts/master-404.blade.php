<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="{{ $settings->site_title }}">
    <meta name="keywords" content="{{ $settings->site_keywords }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    {{-- <meta name="theme-color" content="#0094e2"> --}}
    <meta name="description" content="{{ $settings->site_description }}">
    <meta name="robots" content="index, follow">

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
