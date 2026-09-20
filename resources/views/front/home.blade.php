@extends('layouts.layout')
@php
    $heroPoster = $app_setting->hero_video_thumbnail ?: null;
    $heroVideoHeading = $app_setting->hero_video_heading ?: ($app_setting->hero_video_title ?: ($all_slider->first()?->slider_heading ?: 'Yoga classes with YogIntra'));
    $heroVideoSubHeading = $app_setting->hero_video_sub_heading ?: ($app_setting->hero_video_description ?: ($all_slider->first()?->slider_sub_heading ?: 'Discover yoga classes and wellness support with YogIntra.'));
    $heroVideoTitle = $heroVideoHeading;
    $heroVideoDescription = $heroVideoSubHeading;
    $heroVideoUploadDate = $app_setting->updated_at?->toDateString();
@endphp
@section('meta_title', $app_setting->app_meta_title ?: 'Yoga Classes, Home Yoga & Online Wellness | YogIntra')
@section('meta_description', $app_setting->app_meta_description ?: 'Discover online yoga classes, home yoga sessions, yoga centres, wellness programs and teacher training with YogIntra. Start your healthier journey today.')
@section('meta_keywords', 'yoga classes, online yoga classes, home yoga, yoga centre, yoga teacher training, wellness programs, YogIntra')
@section('og_image', asset('assets/og-logo.webp'))
@push('page_meta_tags')
    <meta name="theme-color" content="#0f7c87">
    @if(($app_setting->hero_media_type ?? 'slider') === 'video' && filled($app_setting->hero_video))
        @php
            $heroVideoSchema = [
                '@' . 'context' => 'https://schema.org',
                '@' . 'type' => 'VideoObject',
                'name' => $heroVideoTitle,
                'description' => $heroVideoDescription,
                'thumbnailUrl' => $heroPoster ? [asset($heroPoster)] : [],
                'contentUrl' => asset($app_setting->hero_video),
                'embedUrl' => url('/'),
                'uploadDate' => $heroVideoUploadDate,
                'dateModified' => $heroVideoUploadDate,
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($heroVideoSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif
@endpush
@push('styles')
    @if(($app_setting->hero_media_type ?? 'slider') === 'slider' && count($all_slider) > 0)
        <link rel="preload" as="image" href="{{ asset($all_slider[0]->slider_image) }}" media="(min-width: 768px)" fetchpriority="high">
        <link rel="preload" as="image" href="{{ asset('assets/Mobile-Banner-new.webp') }}" media="(max-width: 767px)" fetchpriority="high">
    @endif
    @if(($app_setting->hero_media_type ?? 'slider') === 'video' && $heroPoster)
        <link rel="preload" as="image" href="{{ asset($heroPoster) }}" fetchpriority="high">
    @endif
    <style>
        .img-circle {
            max-width: 90% !important;
        }
        #home {
            min-height: 100vh;
        }
        .hero-video-wrap { position: relative; min-height: 100vh; overflow: hidden; background: #111 center / cover no-repeat; }
        .hero-video-wrap video { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
        .hero-video-wrap::after { content:''; position:absolute; inset:0; background:rgba(0,0,0,.38); }
        .hero-video-copy { position:relative; z-index:1; min-height:100vh; display:flex; align-items:center; }
        @media (max-width: 767px) {
            /* A focused, readable first viewport for image-slider heroes. */
            #home:not(.hero-video-home) { position:relative; min-height:75svh !important; height:75svh !important; overflow:hidden; }
            #home:not(.hero-video-home) .fullwidth-carousel,
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item { min-height:75svh !important; height:75svh !important; }
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item > img,
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item picture,
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item picture img { width:100%; height:100%; object-fit:cover; }
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item > .overlay { position:absolute; inset:0; z-index:1; background:linear-gradient(180deg, rgba(3,22,27,.70) 0%, rgba(3,22,27,.38) 35%, rgba(3,22,27,.54) 100%) !important; }
            #home:not(.hero-video-home) .fullwidth-carousel .display-table-absolute { z-index:2; }
            #home:not(.hero-video-home) .fullwidth-carousel .bg-white-transparent { max-width:330px; margin:0 auto; padding:0 !important; background:transparent !important; text-align:center !important; }
            #home:not(.hero-video-home) .fullwidth-carousel .bg-white-transparent h1,
            #home:not(.hero-video-home) .fullwidth-carousel .bg-white-transparent h2,
            #home:not(.hero-video-home) .fullwidth-carousel .bg-white-transparent p,
            #home:not(.hero-video-home) .fullwidth-carousel .bg-white-transparent h3 { color:#fff !important; text-shadow:0 2px 10px rgba(0,0,0,.35); }
            #home:not(.hero-video-home) .fullwidth-carousel .bg-white-transparent .btn { display:inline-flex; align-items:center; justify-content:center; min-width:154px; margin-top:22px !important; padding:12px 20px; border-radius:7px; background:#1a73e8 !important; border-color:#1a73e8 !important; box-shadow:0 8px 18px rgba(0,0,0,.24); }
            #home:not(.hero-video-home) .fullwidth-carousel .bg-white-transparent .btn:hover { background:#1557b0 !important; border-color:#1557b0 !important; }
            .hero-scroll-cue { position:absolute; z-index:3; left:50%; bottom:17px; transform:translateX(-50%); width:30px; height:46px; border:2px solid rgba(255,255,255,.85); border-radius:20px; }
            .hero-scroll-cue::after { content:''; position:absolute; top:8px; left:50%; width:5px; height:8px; border-radius:5px; background:#fff; transform:translateX(-50%); animation:heroScrollHint 1.6s ease-in-out infinite; }
            @keyframes heroScrollHint { 0%,100% { transform:translate(-50%,0); opacity:.65; } 50% { transform:translate(-50%,14px); opacity:1; } }
            #home.hero-video-home { height:calc(100svh - 70px) !important; min-height:calc(100svh - 70px) !important; margin:0 !important; padding:0 !important; }
            #home.hero-video-home .hero-video-wrap,
            #home.hero-video-home .hero-video-copy { height:calc(100svh - 70px); min-height:calc(100svh - 70px); }
            #home.hero-video-home .hero-video-copy .container { position:static !important; top:auto !important; padding-left:20px; padding-right:20px; }
            #home.hero-video-home .hero-video-copy .row > [class*="col-"] { width:100%; margin-left:0; text-align:center !important; }
            #home.hero-video-home .hero-video-copy .bg-white-transparent { text-align:center !important; }
            #home.hero-video-home .hero-video-copy h1,
            #home.hero-video-home .hero-video-copy p { color:#fff !important; }
            #home.hero-video-home .hero-video-copy .btn { display:inline-block; background-color:#1a73e8 !important; border-color:#1a73e8 !important; color:#fff !important; }
            #home.hero-video-home .hero-video-copy .btn:hover,
            #home.hero-video-home .hero-video-copy .btn:focus { background-color:#1557b0 !important; border-color:#1557b0 !important; }
        }
        .yg-txt-right{
            text-align:right;
        }
        .display-table-absolute {
            position: absolute;
            top: 0;
        }
        .heading-bold {
            font-weight: 900;
        }
        .btn-theme-custom {
            background: #1a73e8 !important;
            border-color: #1a73e8 !important;
        }
        .mobile-home-banner {
            width: 100%;
            height: auto;
            display: block;
        }
        .section-content-bg {
            background-repeat: no-repeat;
            background-size: auto;
            min-height: 600px;
        }
        .section-pattern-bg {
            background-repeat: repeat;
            background-size: auto;
        }
        .section-parallax-bg {
            background-position: center center;
            background-size: cover;
        }
        .service-heading {
            font-size: 16px;
        }

        .bg-black-000 {
            background-color: #000 !important;
        }
        @media screen and (min-width: 1000px) and (max-width: 1200px) {
        .cst-font{
            font-size:28px !important;
        }
        .pt-20{
            padding-top:30px !important;
        }
        .pb-50{
            padding-bottom:30px !important;
        }
        h4.mb-5{
            font-size:12px !important;
        }
        }
        .test_ele .elementor-shape-fill{
            fill: #fff!important;
        }
        .section_1 .benefit-icon .icon
        {
        background-color: #fff;
        }
        @media (max-width: 767px) {
            #home {
                min-height: 60vh !important ;
            }
            .m-fs-25{
                font-size: 25px !important;
            }
            .section-content-image {
                background-image: none!important;
            }
            .font-54 {
            font-size: 2rem !important;
            }
            .position-ab
            {
            position: absolute;
            top: 0;
            }
            .sub_heading
            {
                font-size: 13px;
            }
            .margin-tp
            {
                margin-top:10px!important;
            }
            .fullwidth-carousel .carousel-item {
            min-height: 0;
            width: 100%;
            }
            /* Align types-of-yoga-section to left for mobile */
            .types-of-yoga-section .row.justify-content-center {
                justify-content: flex-start !important;
            }
            .types-of-yoga-section .section-content .row {
                justify-content: flex-start !important;
            }
            .types-of-yoga-section .container {
                padding-left: 15px !important;
            }
            .types-of-yoga-section .section-content .col-md-8 {
                display:flex;
                flex-wrap:wrap;
                width:100% !important;
            }
            .types-of-yoga-section .section-content .col-md-8 > [class*="col-"] {
                display:block;
                flex:0 0 50%;
                width:50% !important;
                max-width:50%;
                padding:0 8px;
            }
            .types-of-yoga-section .yoga-service-item img {
                display:block;
                width:108px !important;
                min-width:108px;
                max-width:108px !important;
                height:108px !important;
                min-height:108px;
                max-height:108px;
                margin-left:auto;
                margin-right:auto;
                object-fit:cover;
            }
            .types-of-yoga-section .yoga-service-item h2 { min-height:38px; font-size:15px; }
        }
        
        /* iPad specific fixes */
        @media screen and (min-width: 768px) and (max-width: 1024px) {
            .section_1 .benefit-icon .icon{
                background: transparent
            }
            #home {
                min-height: auto !important;
                height: 450px !important;
            }
            /* Keep slider copy balanced inside the shorter tablet hero. */
            #home:not(.hero-video-home) .fullwidth-carousel,
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item {
                height: 450px !important;
                min-height: 450px !important;
            }
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item > img,
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item picture,
            #home:not(.hero-video-home) .fullwidth-carousel .carousel-item picture img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            #home:not(.hero-video-home) .display-table-absolute {
                inset: 0;
                width: 100%;
                height: 100%;
                display: table !important;
            }
            #home:not(.hero-video-home) .display-table-cell {
                vertical-align: middle !important;
            }
            #home:not(.hero-video-home) .position-ab {
                position: relative !important;
                top: auto !important;
                width: 100%;
            }
            #home:not(.hero-video-home) .bg-white-transparent {
                max-width: 680px;
                padding-top: 20px !important;
                padding-bottom: 20px !important;
            }
            #home:not(.hero-video-home) .font-54 {
                font-size: 48px !important;
                line-height: 1.14 !important;
                margin-bottom: 0;
            }
            #home:not(.hero-video-home) .bg-white-transparent .btn {
                margin-top: 18px !important;
            }
            .section-content {
                padding: 30px 0 !important;
            }
            .container {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }
            .pt-70, .pb-70 {
                padding-top: 40px !important;
                padding-bottom: 40px !important;
            }
            .section-title {
                margin-bottom: 30px !important;
            }
            .mb-50 {
                margin-bottom: 30px !important;
            }
            .mt-30 {
                margin-top: 20px !important;
            }
            .yoga-service-item {
                margin-bottom: 20px !important;
            }
            .types-of-yoga-section {
                padding: 40px 0 !important;
            }
            .py-70 {
                padding-top: 40px !important;
                padding-bottom: 40px !important;
            }
            .review-section {
                padding: 30px 0 !important;
            }
            /* Align types-of-yoga-section to left for iPad */
            .types-of-yoga-section .row.justify-content-center {
                justify-content: flex-start !important;
            }
            .types-of-yoga-section .section-content .row {
                justify-content: flex-start !important;
            }
        }

        /* Desktop view - align types-of-yoga-section to left for background image balance */
        @media screen and (min-width: 1025px) {
            .types-of-yoga-section .row.justify-content-center {
                justify-content: flex-start !important;
            }
            .types-of-yoga-section .container {
                padding-left: 50px !important;
            }
            .types-of-yoga-section .section-content .row {
                justify-content: flex-start !important;
            }
        }
        
        .margin-tp{
            margin-top:40px;
        }
        .padding-200{
            padding-top:200px;
            padding-bottom:200px;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .border-1px {
        border: 1px solid #c9c7c7 !important;
        }
        .kzANES{
        height: none !important;
        }

        .position-relative {
            position: relative;
        }
        .position-absolute {
            position: absolute;
        }
        .top-0 {
            top: 0;
        }
        .left-0 {
            left: 0;
        }
        .w-100 {
            width: 100%;
        }
        .h-100 {
            height: 100%;
        }
        .d-flex {
            display: flex;
        }
        .align-items-center {
            align-items: center;
        }
        .fs-16 {
            font-size: 16px !important;
        }
        .fs-50 {
            font-size: 50px;
            color: #000;
        }

        .btn-sm-cs {
            padding: 5px 17px !important;
            height: auto !important;
        }

        @media (max-width: 1124px) {
            .col-lg-ipad {
                width: 100% !important;
            }
        }

        .sub-heading {
            font-size: 20px;
        }

        /* Enhanced Button Contrast for Accessibility */
        .btn-success {
            background-color: #1a73e8 !important;
            border-color: #1a73e8 !important;
            color: #ffffff !important;
        }
        
        .btn-success:hover,
        .btn-success:focus {
            background-color: #1557b0 !important;
            border-color: #1557b0 !important;
            color: #ffffff !important;
        }
        
        .btn-primary-dark {
            background-color: #1a73e8 !important;
            border-color: #1a73e8 !important;
            color: #ffffff !important;
        }
        
        .btn-primary-dark:hover,
        .btn-primary-dark:focus {
            background-color: #1557b0 !important;
            border-color: #1557b0 !important;
            color: #ffffff !important;
        }
        
        .btn-primary {
            background-color: #1a73e8 !important;
            border-color: #1a73e8 !important;
            color: #ffffff !important;
        }
        
        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #1557b0 !important;
            border-color: #1557b0 !important;
            color: #ffffff !important;
        }
        
        /* Unified styling for all button-like elements */
        .btn-theme-colored,
        .btn-theme-custom,
        .high-contrast-btn,
        a.btn,
        button.btn,
        .btn {
            background-color: #1a73e8 !important;
            border-color: #1a73e8 !important;
            color: #ffffff !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-theme-colored:hover,
        .btn-theme-custom:hover,
        .high-contrast-btn:hover,
        a.btn:hover,
        button.btn:hover,
        .btn:hover,
        .btn-theme-colored:focus,
        .btn-theme-custom:focus,
        .high-contrast-btn:focus,
        a.btn:focus,
        button.btn:focus,
        .btn:focus {
            background-color: #1557b0 !important;
            border-color: #1557b0 !important;
            color: #ffffff !important;
            text-decoration: none !important;
        }
        
        /* Improved contrast for small buttons */
        .btn-sm-cs {
            font-weight: 600 !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
            background-color: #1a73e8 !important;
            border-color: #1a73e8 !important;
            color: #ffffff !important;
        }
        
        .btn-sm-cs:hover,
        .btn-sm-cs:focus {
            background-color: #1557b0 !important;
            border-color: #1557b0 !important;
            color: #ffffff !important;
        }
        
        /* Special styling for slider buttons */
        .btn-flat {
            border-radius: 4px !important;
            padding: 12px 24px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        /* FAQ Accordion Styles */
        .faq-section {
            background-color: #f9f9f9;
        }

        .accordion-item {
            background-color: #ffffff;
            border: 1px solid #e0e0e0 !important;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .accordion-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .accordion-button {
            background-color: #ffffff !important;
            border-color: #e0e0e0 !important;
            color: #173e47 !important;
            font-size: 16px;
            font-weight: 500;
            padding: 18px 20px;
            border: none;
            text-align: left;
            transition: all 0.3s ease;
            width: 100%;
            cursor: pointer;
            display: block;
        }

        .accordion-button:not(.collapsed) {
            background-color: #ffffff !important;
            border-color: #e0e0e0 !important;
            color: #173e47 !important;
            box-shadow: none;
            border-bottom: 2px solid #16717a;
        }

        .accordion-button:hover {
            background-color: #f3fafa !important;
            border-color: #b9dadd !important;
            color: #12626c !important;
        }

        .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%2312626c'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            background-size: 1.25rem;
        }

        .accordion-body {
            padding: 20px;
            font-size: 15px;
            line-height: 1.8;
            color: #444444;
        }

        .accordion-body ul li {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .accordion-body ul li i {
            margin-right: 12px;
            font-size: 14px;
        }

        .text-gray {
            color: #888888;
        }

        .mr-10 {
            margin-right: 10px;
        }

        /* Testimonial Card Styles */
        .testimonial-card {
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15) !important;
        }

        .testimonial-author {
            font-size: 14px;
        }

        .ml-10 {
            margin-left: 10px;
        }

        .p-30 {
            padding: 30px;
        }

        .pt-70 {
            padding-top: 70px;
        }

        .pb-70 {
            padding-bottom: 70px;
        }

        .flex-grow-1 {
            flex: 1;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .pt-20 {
            padding-top: 20px;
        }

        .mt-auto {
            margin-top: auto;
        }
        .accordion-button {
            padding: 15px 15px;
            font-size: 14px;
        }

        .accordion-body {
            padding: 15px;
            font-size: 14px;
        }

        .col-md-8.col-md-offset-2 {
            padding-left: 10px;
            padding-right: 10px;
        }
        .text-dark {
            color: #444444 !important;
        }

        .fs-14 {
            font-size: 14px !important;
            font-weight: normal;
        }

        .life-divin-section img{
            margin:auto;
        }
  </style>
@endpush
@section('content')
    <section id="home" class="divider {{ (($app_setting->hero_media_type ?? 'slider') === 'video' && filled($app_setting->hero_video)) ? 'hero-video-home' : '' }}">
        @if(($app_setting->hero_media_type ?? 'slider') === 'video' && filled($app_setting->hero_video))
            @php
                $heroVideoTextDirection = $app_setting->hero_video_text_direction ?? 'left';
                $heroVideoColumnClass = match ($heroVideoTextDirection) {
                    'right' => 'col-md-6 ml-md-auto text-right',
                    'center' => 'col-md-8 offset-md-2 text-center',
                    default => 'col-md-6',
                };
            @endphp
            <div class="hero-video-wrap" @if($heroPoster) style="background-image: url('{{ asset($heroPoster) }}');" @endif>
                <video class="hero-background-video" autoplay muted loop playsinline preload="metadata" title="{{ $heroVideoTitle }}" aria-label="{{ $heroVideoDescription }}" @if($heroPoster) poster="{{ asset($heroPoster) }}" @endif>
                    <source src="{{ asset($app_setting->hero_video) }}" type="{{ \Illuminate\Support\Str::endsWith($app_setting->hero_video, '.webm') ? 'video/webm' : (\Illuminate\Support\Str::endsWith($app_setting->hero_video, '.ogg') ? 'video/ogg' : 'video/mp4') }}">
                    <track kind="captions" srclang="en" label="English" src="{{ asset('assets/front/captions/yogintra-hero-en.vtt') }}">
                </video>
                <script>
                    (function () {
                        var video = document.querySelector('.hero-background-video');
                        if (!video) return;
                        video.muted = true;
                        var startVideo = function () { video.play().catch(function () {}); };
                        video.addEventListener('canplay', startVideo, { once: true });
                        startVideo();

                        var showPosterFallback = function () {
                            video.style.display = 'none';
                        };
                        video.addEventListener('error', showPosterFallback);
                    }());
                </script>
                @if($heroVideoHeading)
                    <div class="hero-video-copy">
                        <div class="container position-ab"><div class="row"><div class="{{ $heroVideoColumnClass }}">
                            <div class="bg-white-transparent pt-20 pb-50 outline-border">
                                <h1 class="text-black-555 font-54 heading-bold">{{ $heroVideoHeading }}</h1>
                                @if($heroVideoSubHeading)
                                    <p class="text-black-555 font-18 mt-10">{{ $heroVideoSubHeading }}</p>
                                @endif
                                @if($app_setting->hero_video_btn_name && $app_setting->hero_video_btn_link)
                                    <a class="btn btn-theme-colored btn-flat mt-15 high-contrast-btn btn-theme-custom" href="{{ $app_setting->hero_video_btn_link }}">{{ $app_setting->hero_video_btn_name }}</a>
                                @endif
                            </div>
                        </div></div></div>
                    </div>
                @endif
            </div>
        @else
        <div class="fullwidth-carousel" data-nav="true">
            @php
                $mob_heading = '';
                $mob_sub_heading = '';
            @endphp

            @foreach ($all_slider as $index => $slider)
                @if ($index == 1)
                    @php
                        $mob_heading = $slider->slider_heading;
                        $mob_sub_heading = $slider->slider_sub_heading;
                    @endphp
                @endif

                <div class="carousel-item bg-img-cover">
                    @if ($index === 0)
                        <picture>
                            <source media="(max-width: 767px)" srcset="{{ asset('assets/Mobile-Banner-new.webp') }}">
                            <img
                                src="{{ asset($slider->slider_image) }}"
                                srcset="{{ asset($slider->slider_image) }} 1519w"
                                sizes="(max-width: 767px) 100vw, 1519px"
                                width="1519"
                                height="854"
                                loading="eager"
                                decoding="async"
                                fetchpriority="high"
                                alt="YogIntra - {{ $slider->slider_heading }}"
                            >
                        </picture>
                    @else
                        <img
                            src="{{ asset($slider->slider_image) }}"
                            width="1519"
                            height="854"
                            loading="lazy"
                            decoding="async"
                            alt="YogIntra - {{ $slider->slider_heading }}"
                        >
                    @endif
                    <div class="overlay"></div>
                    <div class="display-table display-table-absolute">
                        <div class="display-table-cell">
                            <div class="container position-ab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="bg-white-transparent pt-20 pb-50 outline-border">
                                            @if ($index === 0)
                                                <h1 class="text-black-555 font-54 heading-bold">{{ $slider->slider_heading }}</h1>
                                            @else
                                                <h2 class="text-black-555 font-54 heading-bold">{{ $slider->slider_heading }}</h2>
                                            @endif
                                            
                                            @if ($slider->slider_btn_name && $slider->slider_btn_link)
                                                <a class="btn btn-theme-colored btn-flat mt-15 high-contrast-btn btn-theme-custom"
                                                href="{{ $slider->slider_btn_link }}">
                                                    {{ $slider->slider_btn_name }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mobile-home position-relative p-0" style="width: 100%;">
            <img
                src="{{ asset('assets/Mobile-Banner-new.webp') }}"
                alt="YogIntra Mobile Banner - Yoga and Meditation Services"
                width="414"
                height="650"
                decoding="async"
                fetchpriority="high"
                class="mobile-home-banner"
            >

            <div class="position-absolute top-0 left-0 w-100 align-items-center p-15 pt-0">
                <div class="container pt-30">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bg-white-transparent pt-20 pb-50 outline-border">
                                <p class="text-black-555 mob-font-54">{{ $mob_heading }}</p>
                                <h3 class="font-weight-400 margin-tp sub_heading mob-sub_heading">{{ $mob_sub_heading }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <a class="hero-scroll-cue visible-xs" href="#home-intro" aria-label="Scroll to explore"><span class="sr-only">Scroll to explore YogIntra services</span></a>
    </section>

    <section id="home-intro" class="section-content-image section-content-bg" style="background-image: url('{{ asset($section_1->of_image) }}');">
        <div class="container">
            <div class="section-title text-center">
                <div class="row">
                    <div class="col-md-7 col-md-offset-5">
                        <h2 class="text-uppercase line-bottom-double-line-centered mt-0 cst-font">
                            {{ $section_1->of_heading }}
                        </h2>
                        <span class="sub-heading text-theme-colored2">{{ $section_1->of_sub_heading }}</span>
                    </div>
                </div>
            </div>
            <div class="section-content section_1">
                <div class="row">
                    <div class="col-md-5">
                        <div class="left_side_image hidden-xs"></div>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            @foreach ($section_1_content as $content_1)
                                <div class="col-sm-6">
                                    <div class="icon-box icon-theme-colored benefit-icon left media p-0 mb-sm-10 mt-30">
                                        <a href="{{ route('yoga.center') }}" class="icon icon-circled icon-md pull-left flip" aria-label="Explore yoga centres">
                                            <img src="{{ asset($content_1->of_image) }}" 
                                                width="75" height="75" loading="lazy" alt="YogIntra Feature - {{ $content_1->of_heading }}" decoding="async">
                                        </a>
                                        <div class="media-body">
                                            <h3 class="media-heading heading"><b>{{ $content_1->of_heading }}</b></h3>
                                            <h3 class="fs-14 text-black">{{ $content_1->of_description }}</h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="divider section-pattern-bg" style="background-image: url('{{ asset('assets/pattern-chakras-alt-color.webp') }}');">
        <div class="elementor-shape elementor-shape-top" data-negative="false">
            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 283.5 27.8" preserveAspectRatio="xMidYMax slice">
                <path class="elementor-shape-fill" d="M0 0v6.7c1.9-.8 4.7-1.4 8.5-1 9.5 1.1 11.1 6 11.1 6s2.1-.7 4.3-.2c2.1.5 2.8 2.6 2.8 2.6s.2-.5 1.4-.7c1.2-.2 1.7.2 1.7.2s0-2.1 1.9-2.8c1.9-.7 3.6.7 3.6.7s.7-2.9 3.1-4.1 4.7 0 4.7 0 1.2-.5 2.4 0 1.7 1.4 1.7 1.4h1.4c.7 0 1.2.7 1.2.7s.8-1.8 4-2.2c3.5-.4 5.3 2.4 6.2 4.4.4-.4 1-.7 1.8-.9 2.8-.7 4 .7 4 .7s1.7-5 11.1-6c9.5-1.1 12.3 3.9 12.3 3.9s1.2-4.8 5.7-5.7c4.5-.9 6.8 1.8 6.8 1.8s.6-.6 1.5-.9c.9-.2 1.9-.2 1.9-.2s5.2-6.4 12.6-3.3c7.3 3.1 4.7 9 4.7 9s1.9-.9 4 0 2.8 2.4 2.8 2.4 1.9-1.2 4.5-1.2 4.3 1.2 4.3 1.2.2-1 1.4-1.7 2.1-.7 2.1-.7-.5-3.1 2.1-5.5 5.7-1.4 5.7-1.4 1.5-2.3 4.2-1.1c2.7 1.2 1.7 5.2 1.7 5.2s.3-.1 1.3.5c.5.4.8.8.9 1.1.5-1.4 2.4-5.8 8.4-4 7.1 2.1 3.5 8.9 3.5 8.9s.8-.4 2 0 1.1 1.1 1.1 1.1 1.1-1.1 2.3-1.1 2.1.5 2.1.5 1.9-3.6 6.2-1.2 1.9 6.4 1.9 6.4 2.6-2.4 7.4 0c3.4 1.7 3.9 4.9 3.9 4.9s3.3-6.9 10.4-7.9 11.5 2.6 11.5 2.6.8 0 1.2.2c.4.2.9.9.9.9s4.4-3.1 8.3.2c1.9 1.7 1.5 5 1.5 5s.3-1.1 1.6-1.4c1.3-.3 2.3.2 2.3.2s-.1-1.2.5-1.9 1.9-.9 1.9-.9-4.7-9.3 4.4-13.4c5.6-2.5 9.2.9 9.2.9s5-6.2 15.9-6.2 16.1 8.1 16.1 8.1.7-.2 1.6-.4V0H0z"></path>
            </svg>
        </div>
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset($section_2->os_image_image) }}" width="349" height="348" loading="lazy" decoding="async" alt="YogIntra Services - {{ $section_2->os_image_heading }}">
                    </div>
                    <div class="col-md-6">
                        <h3 class="section-3 mb-0 sub-heading">{{ $section_2->os_image_sub_heading }}</h3>
                        <div class="fs-50 ssc-ttl m-fs-25">{{ $section_2->os_image_heading }}</div>
                        <div>
                            <div class="text-black">{!! app(\App\Support\HtmlSanitizer::class)->sanitize($section_2->os_image_description) !!}</div>
                        </div>
                        <div class="row mt-10">
                            @foreach ($section_2_content as $content_sec_2)
                                <div class="col-sm-4 text-center">
                                    <div class="life-divin-section">
                                        <img src="{{ asset($content_sec_2->os_image) }}" width="90" height="95" loading="lazy" decoding="async" alt="YogIntra Service Icon - {{ $content_sec_2->os_heading }}">
                                    </div>
                                    <h3 class="service-heading">{{ $content_sec_2->os_heading }}</h3>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        $section3FixedImages = json_decode($app_setting->section3_fixed_card_images ?: '{}', true) ?: [];
        $section3CardBullets = json_decode($app_setting->section3_card_bullets ?: '{}', true) ?: [];
        $section3CardButtons = json_decode($app_setting->section3_card_buttons ?: '{}', true) ?: [];
        $section3DefaultBullets = ['Expert-led sessions', 'Flexible booking', 'Personalised guidance', 'Suitable for all levels', 'Wellness-focused practice'];
        $section3BulletItems = function ($key) use ($section3CardBullets, $section3DefaultBullets) {
            $items = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', $section3CardBullets[$key] ?? ''))));
            return array_slice($items ?: $section3DefaultBullets, 0, 5);
        };
        $section3Button = function ($key, $defaultLabel, $defaultUrl) use ($section3CardButtons) {
            $button = $section3CardButtons[$key] ?? [];
            return ['label' => $button['label'] ?? $defaultLabel, 'url' => $button['url'] ?? $defaultUrl];
        };
    @endphp
    <style>
        /* Keep the service cards and their square images visually aligned. */
        .types-of-yoga-section .yoga-service-item { border-radius: 12px !important; overflow: hidden; }
        .types-of-yoga-section .yoga-service-item img.img-circle { border: 0 !important; padding: 0 !important; border-radius: 12px !important; }
        .types-of-yoga-section .section-title .row{display:flex;justify-content:center}.types-of-yoga-section .section-title .row>[class*="col-"]{flex:0 0 100%;max-width:920px;margin:0 auto}.types-of-yoga-section .section-title,.types-of-yoga-section .section-title h2,.types-of-yoga-section .section-title p{text-align:center!important}.types-of-yoga-section .section-content>.row{justify-content:center}.types-of-yoga-section .section-content>.row>.col-md-8{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:20px;width:100%;max-width:1180px;flex:0 0 100%}.types-of-yoga-section .section-content>.row>.col-md-8>.col-lg-3{width:auto;max-width:none;min-width:0;margin:0 !important;padding:0 5px}.types-of-yoga-section .section-content>.row>.col-md-8>.col-md-4:empty{display:none}.types-of-yoga-section .yoga-service-item{height:100%;min-height:300px;display:flex;flex-direction:column;align-items:center;padding:25px 22px 22px;border:1px solid rgba(255,255,255,.88);border-radius:20px;background:rgba(255,255,255,.88);box-shadow:0 12px 28px rgba(25,65,70,.14);backdrop-filter:blur(5px);transition:transform .22s ease,box-shadow .22s ease}.types-of-yoga-section .yoga-service-item:hover{transform:translateY(-5px);box-shadow:0 18px 34px rgba(25,65,70,.22)}.types-of-yoga-section .yoga-service-item img.img-circle{width:128px!important;height:128px!important;object-fit:cover;margin-bottom:20px!important;border:3px solid #fff;box-shadow:0 8px 20px rgba(18,63,70,.2)}.types-of-yoga-section .yoga-service-item h2{min-height:44px;margin:0 0 10px!important;color:#084451;font-size:19px!important;font-weight:800;line-height:1.35}.types-of-yoga-section .section3-card-bullets{width:100%;min-height:82px;margin:0 0 16px;padding-left:20px;text-align:left;color:#496b73;font-size:13px;line-height:1.55;list-style:disc outside !important}.types-of-yoga-section .section3-card-bullets li{display:list-item !important;margin:3px 0;list-style-type:disc !important}.types-of-yoga-section .section3-card-bullets li::marker{color:#14757d;font-size:1.05em}.types-of-yoga-section .yoga-service-item .btn{width:100%;margin-top:auto;align-self:stretch;border-radius:7px;padding:9px 18px;font-weight:700}@media(max-width:991px){.types-of-yoga-section .section-content>.row>.col-md-8{grid-template-columns:repeat(2,minmax(0,1fr));max-width:680px}}@media(max-width:767px){.types-of-yoga-section{padding-left:14px!important;padding-right:14px!important}.types-of-yoga-section .section-title{margin-bottom:32px!important}.types-of-yoga-section .section-title h2{font-size:29px!important;line-height:1.28}.types-of-yoga-section .section-title p{font-size:17px;line-height:1.65}.types-of-yoga-section .section-content>.row>.col-md-8{grid-template-columns:1fr;max-width:360px;gap:16px}.types-of-yoga-section .section-content>.row>.col-md-8>.col-lg-3{padding:0}.types-of-yoga-section .yoga-service-item{min-height:0;padding:23px 24px}.types-of-yoga-section .yoga-service-item h2{min-height:0;font-size:21px!important}.types-of-yoga-section .section3-card-bullets{max-width:260px;min-height:0;margin-left:auto;margin-right:auto;font-size:14px}}
        @media(max-width:767px){.types-of-yoga-section .section-content>.row{margin-left:0!important;margin-right:0!important}.types-of-yoga-section .section-content .col-lg-ipad{display:block!important;width:100%!important;max-width:100%!important;flex:0 0 100%!important;padding:0!important}.types-of-yoga-section .section-content .col-lg-ipad>[class*="col-"]{display:block!important;float:none!important;position:relative!important;left:50%!important;transform:translateX(-50%)!important;width:calc(100% - 28px)!important;max-width:420px!important;flex:0 0 auto!important;margin:0!important;padding:0!important}.types-of-yoga-section .section-content .col-lg-ipad>[class*="col-"] .yoga-service-item{width:100%!important;box-sizing:border-box;text-align:center}.types-of-yoga-section .section-content .col-lg-ipad>[class*="col-"]:not(:last-of-type) .yoga-service-item{margin-bottom:28px!important}.types-of-yoga-section .section-content .col-lg-ipad>[class*="col-"] .yoga-service-item h2{text-align:center}.types-of-yoga-section .section-content .col-lg-ipad>.col-md-4:empty{display:none!important}}
    </style>
    <section class="divider types-of-yoga-section section-parallax-bg" style="background-image: url('{{ asset($app_setting->section3_background_image ?: 'assets/parallax-decor2.png') }}'); padding-top:{{ $app_setting->section3_padding_y ?: 70 }}px; padding-bottom:{{ $app_setting->section3_padding_y ?: 70 }}px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10">
                                <h2 class="ssc-ttl brief-dec-title m-fs-25 mb-20">{{ $app_setting->section3_heading ?: 'A BRIEF DESCRIPTION OF THE TYPES OF YOGA SERVICES' }}</h2>
                                <p class="text-center">{{ $app_setting->section3_description ?: 'We at YogIntra provide various services to the nature of the clients. Wish how you would like to spend your time here we can talk and come to a conclusion.' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="section-content">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 col-lg-ipad">
                                @foreach ($rand_service as $r_service)
                                    @php
                                        $cardButton = $section3Button('category_'.$r_service->service_cat_id, 'Book Now', url($r_service->service_cat_slug));
                                    @endphp
                                    <div class="col-lg-3 col-md-3 col-sm-4 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                        <div class="yoga-service-item text-center">
                                             <img class="img-circle img-thumbnail mb-20" src="{{ asset($r_service->service_cat_image) }}" width="150" height="150" loading="lazy" decoding="async" alt="YogIntra Service Category - {{ $r_service->service_cat_name }}">
                                             <h2 class="mb-15 fs-16">{{ $r_service->service_cat_name }}</h2>
                                             <ul class="section3-card-bullets">@foreach($section3BulletItems('category_'.$r_service->service_cat_id) as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                             <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-lg-3 col-md-3 col-sm-4 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    @php
                                        $cardButton = $section3Button('ttc', 'Visit Now', route('ttc'));
                                    @endphp
                                    <div class="yoga-service-item text-center">
                                         <img class="img-circle img-thumbnail mb-20" src="{{ asset($section3FixedImages['ttc'] ?? 'assets/icon-thumb3-150x150.jpg') }}" width="150" height="150" decoding="async" loading="lazy" alt="YogIntra TTC - Teacher Training Course">
                                         <h2 class="mb-15 fs-16">TTC</h2>
                                         <ul class="section3-card-bullets">@foreach($section3BulletItems('ttc') as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                         <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-4 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    @php
                                        $cardButton = $section3Button('retreat', 'Visit Now', route('retreat.all'));
                                    @endphp
                                    <div class="yoga-service-item text-center">
                                         <img class="img-circle img-thumbnail mb-20" src="{{ asset($section3FixedImages['retreat'] ?? 'assets/icon-thumb4-150x150.jpg') }}" height="150" width="150" decoding="async" loading="lazy" alt="YogIntra Retreat Programs">
                                         <h2 class="mb-15 fs-16">Retreat</h2>
                                         <ul class="section3-card-bullets">@foreach($section3BulletItems('retreat') as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                         <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    @php
                                        $cardButton = $section3Button('workshop', 'Visit Now', route('workshop'));
                                    @endphp
                                    <div class="yoga-service-item text-center">
                                         <img class="img-circle img-thumbnail mb-20" src="{{ asset($section3FixedImages['workshop'] ?? 'assets/icon-thumb1-150x150.webp') }}" height="150" width="150" decoding="async" loading="lazy" alt="YogIntra Yoga Workshops">
                                         <h2 class="mb-15 fs-16">Workshop</h2>
                                         <ul class="section3-card-bullets">@foreach($section3BulletItems('workshop') as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                         <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    @php
                                        $cardButton = $section3Button('yoga_center', 'Visit Now', route('yoga.center'));
                                    @endphp
                                    <div class="yoga-service-item text-center">
                                         <img class="img-circle img-thumbnail mb-20" src="{{ asset($section3FixedImages['yoga_center'] ?? 'uploads/yog_center.jpg') }}" width="150" height="150" loading="lazy" decoding="async" alt="YogIntra Yoga Center and Training Facility">
                                         <h2 class="mb-15 fs-16">Yoga Center</h2>
                                         <ul class="section3-card-bullets">@foreach($section3BulletItems('yoga_center') as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                         <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                    </div>
                                </div>
                                </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-lighter">
        <div class="container pt-70 pb-70">
            <div class="section-title text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3 class="h2 mt-0 line-height-1">Meet Our <span class="text-theme-colored2">Instructors</span></h3>
                    </div>
                </div>
            </div>

            <div class="row mtli-row-clearfix">
                <div class="col-md-12">
                    <div class="owl-carousel-4col" data-nav="true" data-dots="true">
                        @foreach ($all_trainer as $trainer)
                            <div class="item">
                                <div class="team-members text-center maxwidth400">
                                    <div class="team-thumb">
                                        <img class="img-fullwidth" width="200" height="200" loading="lazy" decoding="async" alt="YogIntra Instructor - {{ $trainer->name ?? 'Instructor' }}" src="{{ $api . '/' . ($trainer->profile_image ?? '') }}">
                                    </div>
                                    @php
                                        $currentYear = now()->year;
                                        $birthYear = !empty($trainer->dob ?? null) ? \Carbon\Carbon::parse($trainer->dob)->year : $currentYear;
                                        $age = $currentYear - $birthYear;
                                    @endphp
                                    <div class="team-details">
                                        <div class="p-10">
                                            <h4 class="text-uppercase mt-0 mb-0 text-dark">{{ $trainer->name ?? 'YogIntra Instructor' }}</h4>
                                            {{-- <p class="mt-0 mb-0 text-dark">Age - {{ $age }}</p> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center">
                        <a href="{{ url('trainers') }}" class="btn btn-success mt-15">
                            View Our More Instructors <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .yogintra-guidance-section { background: #f4f9f8; }
        .yogintra-guidance-section .section-title { margin-bottom: 28px; }
        .yogintra-guidance-copy { max-width: 760px; margin: 0 auto; color: #45666d; font-size: 16px; line-height: 1.7; }
        .yogintra-guidance-list { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px 30px; max-width: 760px; margin: 0 auto; padding: 0; list-style: none; text-align: left; }
        .yogintra-guidance-list li { position: relative; padding-left: 22px; color: #365b63; font-size: 14px; line-height: 1.45; }
        .yogintra-guidance-list li::before { position: absolute; top: 1px; left: 0; content: '•'; color: #14757d; font-size: 22px; line-height: .75; }
        .yogintra-guidance-footer { max-width: 760px; margin: 28px auto 0; color: #45666d; font-size: 15px; line-height: 1.65; }
        .yogintra-guidance-note { max-width: 760px; margin: 12px auto 0; color: #71878b; font-size: 12px; line-height: 1.6; }
        @media (max-width: 767px) { .yogintra-guidance-list { grid-template-columns: 1fr; gap: 9px; max-width: 320px; }.yogintra-guidance-copy, .yogintra-guidance-footer, .yogintra-guidance-note { padding: 0 14px; } }
    </style>
    <section class="yogintra-guidance-section">
        <div class="container pt-50 pb-50 text-center">
            <div class="section-title">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3 class="h2 mt-0 line-height-1">Guidance for Your <span class="text-theme-colored2">Yoga Journey</span></h3>
                        <p class="yogintra-guidance-copy">A knowledgeable instructor can help you understand yoga techniques, develop appropriate movement patterns, and build a practice suited to your current experience.</p>
                    </div>
                </div>
            </div>
            <p class="font-weight-700 text-black mb-15">Our instructors can help you focus on:</p>
            <ul class="yogintra-guidance-list">
                <li>Yoga fundamentals</li>
                <li>Yoga posture and alignment</li>
                <li>Breathing practices</li>
                <li>Flexibility and mobility</li>
                <li>Strength-building movements</li>
                <li>Relaxation techniques</li>
                <li>Wellness and mindfulness</li>
                <li>Building consistent yoga habits</li>
            </ul>
            <p class="yogintra-guidance-footer">Whether you are beginning yoga or continuing an established practice, the right guidance can make each session more structured, purposeful, and personal.</p>
            <p class="yogintra-guidance-note"><time datetime="2026-09-20">Last reviewed: September 20, 2026</time> · Yoga and wellness information is for general education only and is not a substitute for medical advice. Please consult a qualified healthcare professional before starting a new exercise practice, especially if you have an injury, health condition, or are pregnant. Read our <a href="{{ url('editorial-policy') }}">Editorial Policy</a>.</p>
        </div>
    </section>

    <section class="review-section bg-lighter">
        <div class="container pt-70 pb-70">
            <div class="section-title text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3 class="h2 mt-0 line-height-1">What Our <span class="text-theme-colored2">Clients Say</span></h3>
                        <p class="text-black">Real testimonials from our dedicated yoga practitioners and students</p>
                    </div>
                </div>
            </div>

            <div class="row mtli-row-clearfix">
                <div class="col-md-12">
                    <div class="owl-carousel-3col" data-nav="true" data-dots="true">
                        @forelse($testimonials as $testimonial)
                            <div class="item">
                                <div class="testimonial-card bg-white rounded" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 350px; display: flex; flex-direction: column; overflow: hidden; padding: 25px;">
                                    <!-- Star Rating -->
                                    <div style="margin-bottom: 15px; flex-shrink: 0;">
                                        @for($i = 0; $i < $testimonial->test_review; $i++)
                                            <span style="color: #FFD700; font-size: 18px;">★</span>
                                        @endfor
                                        <small class="text-dark ml-10">({{ $testimonial->test_review }}/5)</small>
                                    </div>

                                    <!-- Review Text -->
                                    <div style="flex: 1; overflow-y: auto; margin-bottom: 15px;">
                                        <p class="text-black" style="line-height: 1.6; margin: 0; font-size: 17px;">
                                            <em>"{{ $testimonial->test_description }}"</em>
                                        </p>
                                    </div>

                                    <!-- Reviewer Info -->
                                    <div class="testimonial-author" style="border-top: 1px solid #e0e0e0; padding-top: 12px; flex-shrink: 0;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            @if($testimonial->test_image)
                                                <img src="{{ asset($testimonial->test_image) }}" 
                                                     width="38" height="38" 
                                                     loading="lazy" decoding="async"
                                                     alt="{{ $testimonial->test_name }}" 
                                                     style="border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                                            @else
                                                <div style="width: 38px; height: 38px; background-color: #e07f00; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; flex-shrink: 0; font-size: 16px;">
                                                    {{ strtoupper(substr($testimonial->test_name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div style="min-width: 0;">
                                                <h4 class="mb-0 text-dark" style="font-size: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $testimonial->test_name }}</h4>
                                                @if($testimonial->test_position)
                                                    <small class="text-dark" style="font-size: 12px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $testimonial->test_position }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="alert alert-info text-center">
                                    <p>No testimonials available yet. Check back soon!</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Form moved to chat icon popup -->

    <!-- FAQ Section -->
    <section class="faq-section bg-lighter">
        <div class="container">
            <div class="section-title text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h5 class="h2 mt-0 line-height-1">Frequently Asked <span class="text-theme-colored2">Questions</span></h5>
                        <p class="text-black">Find answers to common questions about YogIntra services and programs</p>
                    </div>
                </div>
            </div>

            <div class="row mt-50">
                <div class="col-md-8 col-md-offset-2">
                    <div class="accordion" id="faqAccordion">
                        <!-- FAQ Item 1 -->
                        <div class="accordion-item mb-15 border-1px">
                            <h5 class="h2 accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <strong>What is YogIntra?</strong>
                                </button>
                            </h5>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yogintra is a wellness platform offering yoga classes, holistic programs, and community events designed to support physical, mental, and spiritual well-being.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="accordion-item mb-15 border-1px">
                            <h5 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <strong>What services does YogIntra provide?</strong>
                                </button>
                            </h5>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Yogintra offers:</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Group yoga classes (beginner to advanced)</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Online and home Yoga classes</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Private one-on-one sessions</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Meditation and breathwork classes</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Corporate wellness programs</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Workshops on mindfulness and holistic living</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="accordion-item mb-15 border-1px">
                            <h5 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <strong>Do YogIntra offer trial classes?</strong>
                                </button>
                            </h5>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Many Yogintra locations offer trial or introductory packages. Check the pricing section for current offers.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 4 -->
                        <div class="accordion-item mb-15 border-1px">
                            <h5 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <strong>Do YogIntra Trainers offer personalized programs?</strong>
                                </button>
                            </h5>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Absolutely. Trainers can design customized plans for:</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Flexibility and strength goals</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Stress reduction</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Injury recovery (non-medical guidance)</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Lifestyle and mindfulness routines</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Item 5 -->
                        <div class="accordion-item mb-15 border-1px">
                            <h5 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    <strong>How can I contact YogIntra?</strong>
                                </button>
                            </h5>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>You can reach the team via:</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-envelope text-theme-colored2 mr-10"></i>Website contact form</li>
                                        <li><i class="fa fa-envelope text-theme-colored2 mr-10"></i>Email</li>
                                        <li><i class="fa fa-phone text-theme-colored2 mr-10"></i>Phone</li>
                                        <li><i class="fa fa-share-alt text-theme-colored2 mr-10"></i>Social media channels</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ Section End -->


@endsection
@push('scripts')
    {{-- FAQ accordion uses the site's existing Bootstrap 4 collapse styles; no second Bootstrap runtime is needed. --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var accordion = document.getElementById('faqAccordion');
            if (!accordion) return;

            accordion.querySelectorAll('.accordion-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    var panel = document.querySelector(button.getAttribute('data-bs-target'));
                    if (!panel) return;

                    var shouldOpen = !panel.classList.contains('show');
                    accordion.querySelectorAll('.accordion-collapse').forEach(function (item) {
                        item.classList.remove('show');
                    });
                    accordion.querySelectorAll('.accordion-button').forEach(function (item) {
                        item.classList.add('collapsed');
                        item.setAttribute('aria-expanded', 'false');
                    });

                    if (shouldOpen) {
                        panel.classList.add('show');
                        button.classList.remove('collapsed');
                        button.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">  
        function ajaxCall() {
            this.send = function(data, url, method, success, type) {
                type = 'json';
                var successRes = function(data) {
                        success(data);
                    }
                    var errorRes = function(xhr, ajaxOptions, thrownError) {            
                        // console.log(xhr.responseText);
                    }   
                    jQuery.ajax({
                        url: url,
                        type: method,
                        data: data,
                        success: successRes,
                        error: errorRes,
                        dataType: type,
                        timeout: 60000,
                        xhrFields: {},
                });
            }
        }
    
        function locationInfo() {
            var rootUrl = "https://geodata.phplift.net/api/index.php";
            var call = new ajaxCall();
            this.getCities = function(id) {
                jQuery(".cities option:gt(0)").remove();
                var url = rootUrl+'?type=getCities&countryId='+ '&stateId=' + id;
                var method = "post";
                var data = {};
                jQuery('.cities').find("option:eq(0)").html("Please wait..");
                call.send(data, url, method, function(data) {
                    jQuery('.cities').find("option:eq(0)").html("Select City");
                        var listlen = Object.keys(data['result']).length;
                        if(listlen > 0)
                        {
                            jQuery.each(data['result'], function(key, val) {
                                var option = `<option value='${val.name}'>${val.name}</option>`;
                                jQuery('.cities').append(option);
                            });
                        }
                        jQuery(".cities").prop("disabled",false);
                });
        };

        this.getStates = function(id) {
            jQuery(".states option:gt(0)").remove();
            jQuery(".cities option:gt(0)").remove();
            var stateClasses = jQuery('#stateId').attr('class');

            
            var url = rootUrl+'?type=getStates&countryId=' + id;
            var method = "post";
            var data = {};
            jQuery('.states').find("option:eq(0)").html("Please wait..");
            call.send(data, url, method, function(data) {
                jQuery('.states').find("option:eq(0)").html("Select State");
                
                    jQuery.each(data['result'], function(key, val) {
                        // var option = jQuery('');
                        var option = `<option value='${val.name}' stateid='${val.id}'>${val.name}</option>`;
                        // option.attr('value', val.name).text(val.name);
                        // option.attr('stateid', val.id);
                        jQuery('.states').append(option);
                    });
                    jQuery(".states").prop("disabled",false);
                
            });
        };

        this.getCountries = function() {
            var url = rootUrl+'?type=getCountries';
            var method = "post";
            var data = {};
            jQuery('.countries').find("option:eq(0)").html("Please wait..");
            call.send(data, url, method, function(data) {
                jQuery('.countries').find("option:eq(0)").html("Select Country");
                jQuery.each(data['result'], function(key, val) {
                    var option = `<option value='${val.name}' countryid='${val.id}'>${val.name}</option>`;
                    // option.attr('value', val.name).text(val.name);
                    // option.attr('countryid', val.id);
                    jQuery('.countries').append(option);
                });
                    // jQuery(".countries").prop("disabled",false);
                
            });
        };

        }

        var $owl_carousel_4col = $('.owl-carousel-4col');

        if ( $owl_carousel_4col.length > 0 ) {
            if(!$owl_carousel_4col.hasClass("owl-carousel")){
                $owl_carousel_4col.addClass("owl-carousel owl-theme");
            }
            $owl_carousel_4col.each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    // rtl: THEMEMASCOT.isRTL.check(),
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 4,
                    margin: 15,
                    dots: false,
                    nav: data_nav,
                    navText: [
                        '<i class="fa fa-chevron-left"></i>',
                        '<i class="fa fa-chevron-right"></i>'
                    ],
                    responsive: {
                        0: {
                            items: 1,
                            center: true
                        },
                        480: {
                            items: 1,
                            center: false
                        },
                        600: {
                            items: 3,
                            center: false
                        },
                        750: {
                            items: 3,
                            center: false
                        },
                        960: {
                            items: 3
                        },
                        1170: {
                            items: 4
                        },
                        1300: {
                            items: 4
                        }
                    }
                });
            });
        }
        
        var $owl_carousel_3col = $('.owl-carousel-3col');
    
        if ( $owl_carousel_3col.length > 0 ) {
            if(!$owl_carousel_3col.hasClass("owl-carousel")){
                $owl_carousel_3col.addClass("owl-carousel owl-theme");
            }
            $owl_carousel_3col.each(function() {
                var data_dots = ( $(this).data("dots") === undefined ) ? false: $(this).data("dots");
                var data_nav = ( $(this).data("nav")=== undefined ) ? false: $(this).data("nav");
                var data_duration = ( $(this).data("duration") === undefined ) ? 4000: $(this).data("duration");
                $(this).owlCarousel({
                    autoplay: true,
                    autoplayTimeout: data_duration,
                    loop: true,
                    items: 3,
                    margin: 15,
                    dots: data_dots,
                    nav: data_nav,
                    navText: [
                        '<i class="fa fa-chevron-left"></i>',
                        '<i class="fa fa-chevron-right"></i>'
                    ],
                    responsive: {
                        0: {
                            items: 1,
                            center: false
                        },
                        480: {
                            items: 1,
                            center: false
                        },
                        600: {
                            items: 1,
                            center: false
                        },
                        750: {
                            items: 2,
                            center: false
                        },
                        960: {
                            items: 2
                        },
                        1170: {
                            items: 3
                        },
                        1300: {
                            items: 3
                        }
                    }
                });
            });
        }
    </script>

    <!-- Enhanced Structured Data for Home Page -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "YogIntra - Premier Yoga Institute in India",
        "url": "{{ url('/') }}",
        "description": "Transform your mind and body with YogIntra, the premier Yoga Institute in India. We offer online classes, personal home visits, teacher training courses, and yoga center services.",
        "mainEntity": {
            "@type": "HealthAndBeautyBusiness",
            "name": "YogIntra",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('assets/og-logo.webp') }}",
            "description": "Premier Yoga Institute offering comprehensive yoga services including personal training, group classes, teacher training courses, and wellness programs.",
            "hasOfferCatalog": {
                "@type": "OfferCatalog",
                "name": "Yoga Services",
                "itemListElement": [
                    @foreach($rand_service as $index => $service)
                    {
                        "@type": "Offer",
                        "itemOffered": {
                            "@type": "Service",
                            "name": "{{ $service->service_cat_name }}",
                            "url": "{{ url($service->service_cat_slug) }}",
                            "image": "{{ asset($service->service_cat_image) }}",
                            "provider": {
                                "@type": "Organization",
                                "name": "YogIntra"
                            }
                        }
                    }{{ $loop->last ? '' : ',' }}
                    @endforeach
                ]
            }
        },
        "breadcrumb": {
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "{{ url('/') }}"
                }
            ]
        }
    }
    </script>

    <!-- Services Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ItemList",
        "name": "Yoga Services by YogIntra",
        "description": "Comprehensive yoga services including personal training, group classes, teacher training, and specialized programs",
        "itemListElement": [
            @foreach($rand_service as $index => $service)
            {
                "@type": "Service",
                "position": {{ $index + 1 }},
                "name": "{{ $service->service_cat_name }}",
                "url": "{{ url($service->service_cat_slug) }}",
                "image": "{{ asset($service->service_cat_image) }}",
                "provider": {
                    "@type": "HealthAndBeautyBusiness",
                    "name": "YogIntra",
                    "url": "{{ url('/') }}"
                },
                "serviceType": "Yoga Training",
                "areaServed": {
                    "@type": "Country",
                    "name": "India"
                }
            }{{ $loop->last ? '' : ',' }}
            @endforeach,
            {
                "@type": "Service",
                "position": {{ count($rand_service) + 1 }},
                "name": "TTC (Teacher Training Course)",
                "url": "{{ route('ttc') }}",
                "image": "{{ asset('assets/icon-thumb3-150x150.jpg') }}",
                "provider": {
                    "@type": "HealthAndBeautyBusiness",
                    "name": "YogIntra",
                    "url": "{{ url('/') }}"
                },
                "serviceType": "Yoga Teacher Training",
                "areaServed": {
                    "@type": "Country",
                    "name": "India"
                }
            },
            {
                "@type": "Service",
                "position": {{ count($rand_service) + 2 }},
                "name": "Yoga Retreat Programs",
                "url": "{{ route('retreat.all') }}",
                "image": "{{ asset('assets/icon-thumb4-150x150.jpg') }}",
                "provider": {
                    "@type": "HealthAndBeautyBusiness",
                    "name": "YogIntra",
                    "url": "{{ url('/') }}"
                },
                "serviceType": "Yoga Retreat",
                "areaServed": {
                    "@type": "Country",
                    "name": "India"
                }
            },
            {
                "@type": "Service",
                "position": {{ count($rand_service) + 3 }},
                "name": "Yoga Workshops",
                "url": "{{ route('workshop') }}",
                "image": "{{ asset('assets/icon-thumb1-150x150.webp') }}",
                "provider": {
                    "@type": "HealthAndBeautyBusiness",
                    "name": "YogIntra",
                    "url": "{{ url('/') }}"
                },
                "serviceType": "Yoga Workshop",
                "areaServed": {
                    "@type": "Country",
                    "name": "India"
                }
            }
        ]
    }
    </script>

    <!-- Organization Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "YogIntra",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('assets/og-logo.webp') }}",
        "description": "Premier Yoga Institute in India offering comprehensive yoga training, personal sessions, teacher training courses, and wellness programs",
        "foundingDate": "2018",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+91-9867291573",
            "contactType": "customer service",
            "areaServed": "IN",
            "availableLanguage": ["English", "Hindi"]
        },
        "sameAs": [
            "https://www.facebook.com/yogintra",
            "https://www.instagram.com/yogintra",
            "https://www.twitter.com/yogintra"
        ],
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "Mumbai",
            "addressRegion": "Maharashtra",
            "addressCountry": "IN"
        }
    }
    </script>
@endpush
