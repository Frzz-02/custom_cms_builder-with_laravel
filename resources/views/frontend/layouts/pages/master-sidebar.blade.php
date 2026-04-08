<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="{{ $page->meta_title }}">
    <meta name="keywords" content="{{ $page->meta_keywords }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#0094e2">
    <meta name="description" content="{{ $page->meta_description }}">
    <meta name="robots" content="{{ $page->status === 'published' ? 'index,follow' : 'noindex,nofollow' }}">
    <link rel="canonical" href="{{ is_null($page->slug) ? url('/') : url($page->slug) }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ is_null($page->slug) ? url('/') : url($page->slug) }}">
    <meta property="og:title" content="{{ $page->meta_title }}">
    <meta property="og:description" content="{{ $page->meta_description }}">
    {{-- <meta property="og:image" content="{{ asset('assets/images/thumbnail.webp') }}"> --}}

    {{-- <meta property="twitter:card" content="summary_large_image"> --}}
    {{-- <meta property="twitter:url" content="https://site_url.com"> --}}
    <meta property="twitter:title" content="{{ $page->meta_title }}">
    <meta property="twitter:description" content="{{ $page->meta_description }}">
    {{-- <meta property="twitter:image" content="{{ asset('assets/images/thumbnail.webp') }}"> --}}

    <title>{{ $page->meta_title }}</title>

    <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}">

    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-700 antialiased">
    
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

        .no-scrollbar::-webkit-scrollbar {
           display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE & Edge */
            scrollbar-width: none;     /* Firefox */
        }
    </style>
    
    
    
    
    
    

    @if ($whatsappButton && $whatsappButton->status == 'active')
        <a href="https://api.whatsapp.com/send/?phone={{ $whatsappButton->phone_number }}&text={{ $whatsappButton->message }}&type=phone_number&app_absent=0"
            class="whatsapp-button" target="_blank" aria-label="Chat with us on WhatsApp">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
        </a>
    @endif

    <a class="scroll-top-arrow" href="javascript:void(0);"><i class="feather icon-feather-arrow-up"></i></a>

    @include('frontend.layouts.navmenu')

    {{-- @if ($breadcrumb->status === 'active')
        <section class="page-title-area" style="background-color: {{ $breadcrumb->background_color }}">
            <div class="container">
                <div class="page-title-content text-center">
                    <h1 class="page-title" style="color: {{ $breadcrumb->title_color }}">{{ $page->title }}</h1>

                    <ul class="breadcrumb-nav">
                        <li><a href="/" style="color: {{ $breadcrumb->hometext_color }}">Home</a></li>
                        <li class="active" style="color: {{ $breadcrumb->pagetext_color }}">{{ $page->title }}</li>
                    </ul>
                </div>
            </div>
            @if ($breadcrumb->particle === 'active')
                <div class="page-title-effect d-none d-md-block">
                    <img class="particle-1 animate-zoom-fade" src="{{ asset('assets/img/particle/particle-1.png') }}"
                        alt="particle One">
                    <img class="particle-2 animate-rotate-me" src="{{ asset('assets/img/particle/particle-2.png') }}"
                        alt="particle Two">
                    <img class="particle-3 animate-float-bob-x"
                        src="{{ asset('assets/img/particle/particle-3.png') }}" alt="particle Three">
                    <img class="particle-4 animate-float-bob-y"
                        src="{{ asset('assets/img/particle/particle-4.png') }}" alt="particle Four">
                    <img class="particle-5 animate-float-bob-y"
                        src="{{ asset('assets/img/particle/particle-5.png') }}" alt="particle Five">
                </div>
            @endif

        </section>
    @endif --}}

    <section class="half-section parallax py-10 md:py-14" data-parallax-background-ratio="0.5">
        <div class="container">
            {{-- <div class="row align-items-stretch justify-content-center extra-small-screen">
                <div
                    class="col-xl-6 col-lg-7 col-md-8 page-title-extra-small text-center d-flex justify-content-center flex-column">
                    <h1 class="alt-font text-gradient-sky-blue-pink margin-15px-bottom d-inline-block">Blog standard
                        layout</h1>
                    <h2
                        class="text-extra-dark-gray alt-font font-weight-500 letter-spacing-minus-1px line-height-50 sm-line-height-45 xs-line-height-30 no-margin-bottom">
                        Attractive articles updated daily</h2>
                </div>
            </div> --}}
        </div>
    </section>

    <section class="blog-content-section pt-16 md:pt-20 pb-14 md:pb-20">
        <div class="container mx-auto w-full max-w-[1220px] px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                <main class="w-full lg:col-span-8 right-sidebar" aria-label="Blog articles">
                    @if (!($blogDetail ?? false))
                    <div class="space-y-6 md:space-y-8">
                    @foreach ($blogss as $blog)
                        <article
                            class="col-12 blog-post-content border-all border-color-medium-gray border-radius-6px overflow-hidden text-center p-0 wow animate__fadeIn bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                            <div class="blog-image overflow-hidden">
                                <a href="{{ route('blogs.show', $blog->slug) }}">
                                    @if (!empty($blog->image_featured))
                                        @php
                                            $mediaItem = $media->firstWhere(
                                                'fileencrypt',
                                                str_replace('/storage/', '', $blog->image_featured),
                                            );
                                        @endphp
                                        <img src="{{ asset($blog->image_featured) }}"
                                            alt="{{ $mediaItem->alternative_text ?? $blog->title }}"
                                            loading="lazy"
                                            decoding="async"
                                            class="w-full h-64 md:h-72 object-cover transition-transform duration-500 hover:scale-105">
                                    @endif
                                </a>
                            </div>
                            <div class="blog-text d-inline-block w-100 text-left">
                                <div
                                    class="content padding-5-half-rem-all lg-padding-4-half-rem-all xs-padding-20px-lr xs-padding-40px-tb position-relative mx-auto w-90 lg-w-100 px-6 py-6 md:px-8 md:py-8">
                                    <div
                                        class="blog-details-overlap text-small font-weight-500 bg-fast-blue border-radius-4px alt-font text-white text-uppercase inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-sky-600">
                                        <a href="{{ route('blogs.show', $blog->slug) }}"
                                            class="text-white text-xs tracking-wide">{{ \Carbon\Carbon::parse($blog->publish_date ?? $blog->created_at)->format('d M Y') }}</a> <span
                                            class="margin-5px-lr">•</span> <a href="#" class="text-white text-xs tracking-wide">{!! $blog->category->name !!}</a>
                                    </div>
                                    <h2 class="alt-font font-weight-500 mt-4 text-xl md:text-2xl leading-snug text-slate-900"><a
                                            href="{{ route('blogs.show', $blog->slug) }}"
                                            class="text-extra-dark-gray text-fast-blue-hover hover:text-sky-600 transition-colors">{!! $blog->title !!}</a>
                                    </h2>
                                    <p class="mt-3 text-slate-600 leading-relaxed">{{ Str::limit($blog->meta_description, 150) }}</p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    </div>
                    <div class="text-center mt-8 md:mt-10">
                        {{ $blogss->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </main>

                <aside
                    class="w-full lg:col-span-4 blog-sidebar lg:sticky lg:top-28 self-start"
                    x-data="{ openCategories: true, openRecent: true }"
                    aria-label="Blog sidebar">
                    <div class="margin-5-rem-bottom xs-margin-35px-bottom wow animate__fadeIn bg-white border border-slate-200 rounded-2xl p-5 shadow-sm mb-5">
                        <button type="button"
                            class="w-full flex items-center justify-between gap-3 alt-font font-weight-600 text-large text-extra-dark-gray d-block margin-35px-bottom text-left text-slate-900 pb-2 border-b border-slate-100"
                            @click="openCategories = !openCategories"
                            :aria-expanded="openCategories.toString()">
                            <span>Categories</span>
                            <svg class="w-5 h-5 text-slate-500 transition-transform duration-200" :class="openCategories ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul class="list-style-07 list-unstyled space-y-3 pt-1" x-show="openCategories" x-transition>
                            @foreach ($categories as $category)
                                <li class="flex items-center justify-between border-b border-slate-100 pb-2 last:border-b-0 last:pb-0">
                                    <a href="#" class="text-slate-700 hover:text-sky-600 transition-colors">{!! $category->name !!}</a> <span
                                        class="item-qty inline-flex items-center justify-center text-xs font-semibold text-slate-600 bg-slate-100 rounded-full px-2.5 py-1">{{ $category->blogs_count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="margin-5-rem-bottom mb-20 xs-margin-35px-bottom wow animate__fadeIn bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <button type="button"
                            class="w-full flex items-center justify-between gap-3 alt-font font-weight-600 text-large text-extra-dark-gray d-block margin-35px-bottom text-left text-slate-900 pb-2 border-b border-slate-100"
                            @click="openRecent = !openRecent"
                            :aria-expanded="openRecent.toString()">
                            <span>Recent posts</span>
                            <svg class="w-5 h-5 text-slate-500 transition-transform duration-200" :class="openRecent ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul class="latest-post-sidebar position-relative space-y-3 max-h-[420px] overflow-y-auto no-scrollbar pr-1 pt-1" x-show="openRecent" x-transition>
                            @foreach ($recent_blogs as $post)
                                <li class="d-flex wow animate__fadeIn gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors border border-slate-100" data-wow-delay="0.2s">
                                    <figure class="shrink-0 mb-0">
                                        @if (!empty($post->image_featured))
                                            @php
                                                $mediaItem = $media->firstWhere(
                                                    'fileencrypt',
                                                    str_replace('/storage/', '', $post->image_featured),
                                                );
                                            @endphp
                                            <a href="{{ route('blogs.show', $post->slug) }}">
                                                <img src="{{ asset($post->image_featured) }}"
                                                    alt="{{ $mediaItem->alternative_text ?? $post->title }}"
                                                    loading="lazy"
                                                    decoding="async"
                                                    class="border-radius-3px w-20 h-20 object-cover rounded-lg"></a>
                                        @endif
                                    </figure>
                                    <div class="media-body grow min-w-0">
                                        <a href="{{ route('blogs.show', $post->slug) }}"
                                            class="font-weight-500 text-extra-dark-gray d-inline-block margin-five-bottom md-margin-two-bottom text-slate-800 hover:text-sky-600 transition-colors leading-snug">{{ $post->title }}</a>
                                        <span
                                            class="text-medium d-block line-height-22px text-slate-500 text-sm">{{ Str::limit($post->meta_description, 20) }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>
                <!-- end sidebar -->
            </div>
        </div>
    </section>

    @if (!($isBlogPage ?? false) || ($blogDetail ?? false))
        @yield('content')
    @endif

    @include('frontend.layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
    </script>

    
    @stack('scripts')
    @yield('scripts')
    
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
