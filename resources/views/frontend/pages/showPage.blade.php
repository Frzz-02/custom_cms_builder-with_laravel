{{-- @extends('frontend.layouts.master') --}}

@extends($layout)



@push('styles')
    <style>
        /* Hero Section Isolation - Prevents overlapping when multiple hero sections exist */
        .hero-section-wrapper {
            position: relative;
            isolation: isolate;
            clear: both;
            display: block;
            width: 100%;
        }
        
        /* Panel Item for Hero Style 1 */
        .panel-item {
            position: relative;
            flex: 1;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .panel-item:hover {
            flex: 2.5;
        }
        .panel-item:hover img {
            transform: scale(1.05);
        }
        .panel-item img {
            transition: transform 0.7s ease;
        }
        .panel-item .content-card {
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .panel-item:hover .content-card {
            transform: translateY(0);
        }

        /* Blog Slider Auto Scroll Animation */
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc(-288px * 6 - 24px * 6));
            }
        }
        .animate-scroll {
            animation: scroll 30s linear infinite;
        }
        .animate-scroll:hover {
            animation-play-state: paused;
        }
    </style>
@endpush



@section('content')
{{-- {{ env('DB_HOST') }} --}}
    @foreach ($shortcodes as $shortcode)
        @include('frontend.section.title')

        @include('frontend.section.simpleText')

        @include('frontend.section.latestnews')

        @include('frontend.section.texteditor')

        @include('frontend.section.image')

        @include('frontend.section.newsletter')

        @include('frontend.section.about')

        @include('frontend.section.pricing')
        
        @include('frontend.section.productCategory')

        @include('frontend.section.contact')

        @include('frontend.section.hero-banner')

        @include('frontend.section.service')

        @include('frontend.section.complete-count')

        @include('frontend.section.testimonials')

        @include('frontend.section.brands')

        @include('frontend.section.recentProduct')

        @include('frontend.section.comingsoon')

    @endforeach

@endsection
