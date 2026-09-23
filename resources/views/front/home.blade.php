@extends('layouts.layout')
@php
    $heroPoster = $app_setting->hero_video_thumbnail ?: null;
    $heroVideoHeading = $app_setting->hero_video_heading ?: ($app_setting->hero_video_title ?: ($all_slider->first()?->slider_heading ?: 'Wellness classes with YogIntra'));
    $heroVideoSubHeading = $app_setting->hero_video_sub_heading ?: ($app_setting->hero_video_description ?: ($all_slider->first()?->slider_sub_heading ?: 'Discover guided movement and wellbeing support with YogIntra.'));
    $heroVideoTitle = $heroVideoHeading;
    $heroVideoDescription = $heroVideoSubHeading;
    // Application settings do not use Eloquent timestamps. Use the hero video's
    // file modification time as its upload date, with a valid ISO fallback for
    // installations where the video is served from remote storage.
    $heroVideoPath = filled($app_setting->hero_video) ? public_path($app_setting->hero_video) : null;
    $heroVideoUploadDate = $heroVideoPath && is_file($heroVideoPath)
        ? date(DATE_ATOM, filemtime($heroVideoPath))
        : now()->toAtomString();
@endphp
@section('meta_title', $app_setting->app_meta_title ?: 'Yoga Classes, Home Yoga & Online Wellness | YogIntra')
@section('meta_description', 'YogIntra offers guided yoga, meditation and wellness classes online, at home and near you to build strength, flexibility, balance and calm every day.')
@section('meta_keywords', 'yoga, online classes, home sessions, wellness programs, teacher training, YogIntra')
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
    <link rel="stylesheet" href="{{ asset('assets/front/css/home.min.css') }}">
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
                <video class="hero-background-video" muted loop playsinline preload="none" title="{{ $heroVideoTitle }}" aria-label="{{ $heroVideoDescription }}" @if($heroPoster) poster="{{ asset($heroPoster) }}" @endif>
                    <source src="{{ asset($app_setting->hero_video) }}" type="{{ \Illuminate\Support\Str::endsWith($app_setting->hero_video, '.webm') ? 'video/webm' : (\Illuminate\Support\Str::endsWith($app_setting->hero_video, '.ogg') ? 'video/ogg' : 'video/mp4') }}">
                    <track kind="captions" srclang="en" label="English" src="{{ asset('assets/front/captions/yogintra-hero-en.vtt') }}">
                </video>
                                <script src="{{ asset('assets/front/js/home-hero-video.min.js') }}" defer></script>
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
                                title="YogIntra - {{ $slider->slider_heading }}"
                            >
                        </picture>
                    @else
                        <img
                            src="{{ asset($slider->slider_image) }}"
                            width="1519"
                            height="854"
                            loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                            decoding="async"
                            alt="YogIntra - {{ $slider->slider_heading }}"
                            title="YogIntra - {{ $slider->slider_heading }}"
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
                title="YogIntra Mobile Banner - Yoga and Meditation Services"
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
                                                width="75" height="75" loading="lazy" alt="YogIntra Feature - {{ $content_1->of_heading }}" title="YogIntra Feature - {{ $content_1->of_heading }}" decoding="async">
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
                        <img src="{{ asset($section_2->os_image_image) }}" width="349" height="348" loading="lazy" decoding="async" alt="YogIntra Services - {{ $section_2->os_image_heading }}" title="YogIntra Services - {{ $section_2->os_image_heading }}">
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
                                        <img src="{{ asset($content_sec_2->os_image) }}" width="90" height="95" loading="lazy" decoding="async" alt="YogIntra Service Icon - {{ $content_sec_2->os_heading }}" title="YogIntra Service Icon - {{ $content_sec_2->os_heading }}">
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
    <section class="divider types-of-yoga-section section-parallax-bg" style="background-image: url('{{ asset($app_setting->section3_background_image ?: 'assets/parallax-decor2.png') }}'); padding-top:{{ $app_setting->section3_padding_y ?: 70 }}px; padding-bottom:{{ $app_setting->section3_padding_y ?: 70 }}px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10">
                                <h2 class="ssc-ttl brief-dec-title m-fs-25 mb-20">{{ $app_setting->section3_heading ?: 'A BRIEF DESCRIPTION OF THE TYPES OF YOGA SERVICES' }}</h2>
                                <p class="text-center">{{ $app_setting->section3_description ?: 'Choose a class that fits your goals, schedule and experience. Our team can help you find the right place to begin.' }}</p>
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
                                    <div class="col-lg-3 col-md-3 col-sm-4 mb-30">
                                        <div class="yoga-service-item text-center">
                                             <img class="img-circle img-thumbnail mb-20" src="{{ asset($r_service->service_cat_image) }}" width="150" height="150" loading="lazy" decoding="async" alt="YogIntra Service Category - {{ $r_service->service_cat_name }}" title="YogIntra Service Category - {{ $r_service->service_cat_name }}">
                                             <h2 class="mb-15 fs-16">{{ $r_service->service_cat_name }}</h2>
                                             <ul class="section3-card-bullets">@foreach($section3BulletItems('category_'.$r_service->service_cat_id) as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                             <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-lg-3 col-md-3 col-sm-4 mb-30">
                                    @php
                                        $cardButton = $section3Button('ttc', 'Visit Now', route('ttc'));
                                    @endphp
                                    <div class="yoga-service-item text-center">
                                         <img class="img-circle img-thumbnail mb-20" src="{{ asset($section3FixedImages['ttc'] ?? 'assets/icon-thumb3-150x150.jpg') }}" width="150" height="150" decoding="async" loading="lazy" alt="YogIntra TTC - Teacher Training Course" title="YogIntra TTC - Teacher Training Course">
                                         <h2 class="mb-15 fs-16">TTC</h2>
                                         <ul class="section3-card-bullets">@foreach($section3BulletItems('ttc') as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                         <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-4 mb-30">
                                    @php
                                        $cardButton = $section3Button('retreat', 'Visit Now', route('retreat.all'));
                                    @endphp
                                    <div class="yoga-service-item text-center">
                                         <img class="img-circle img-thumbnail mb-20" src="{{ asset($section3FixedImages['retreat'] ?? 'assets/icon-thumb4-150x150.jpg') }}" height="150" width="150" decoding="async" loading="lazy" alt="YogIntra Retreat Programs" title="YogIntra Retreat Programs">
                                         <h2 class="mb-15 fs-16">Retreat</h2>
                                         <ul class="section3-card-bullets">@foreach($section3BulletItems('retreat') as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                         <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 mb-30">
                                    @php
                                        $cardButton = $section3Button('workshop', 'Visit Now', route('workshop'));
                                    @endphp
                                    <div class="yoga-service-item text-center">
                                         <img class="img-circle img-thumbnail mb-20" src="{{ asset($section3FixedImages['workshop'] ?? 'assets/icon-thumb1-150x150.webp') }}" height="150" width="150" decoding="async" loading="lazy" alt="YogIntra Yoga Workshops" title="YogIntra Yoga Workshops">
                                         <h2 class="mb-15 fs-16">Workshop</h2>
                                         <ul class="section3-card-bullets">@foreach($section3BulletItems('workshop') as $bullet)<li>{{ $bullet }}</li>@endforeach</ul>
                                         <a href="{{ $cardButton['url'] }}" class="btn-sm-cs btn btn-success btn-primary-dark">{{ $cardButton['label'] }}</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 mb-30">
                                    @php
                                        $cardButton = $section3Button('yoga_center', 'Visit Now', route('yoga.center'));
                                    @endphp
                                    <div class="yoga-service-item text-center">
                                         <img class="img-circle img-thumbnail mb-20" src="{{ asset($section3FixedImages['yoga_center'] ?? 'uploads/yog_center.jpg') }}" width="150" height="150" loading="lazy" decoding="async" alt="YogIntra Yoga Center and Training Facility" title="YogIntra Yoga Center and Training Facility">
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

    <section class="home-content-summary">
        <div class="container pt-70 pb-70">
            <div class="section-title text-center">
                <h2 class="mt-0 line-height-1">A clear way to begin</h2>
                <p class="summary-intro">YogIntra helps you choose a class that suits your schedule, experience and goals. Start gently, ask questions and build a routine that feels sustainable.</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <article class="summary-card">
                        <h3>Guidance you can trust</h3>
                        <p>Our instructors support safe, steady progress. They can explain movement, offer simpler options and help you practise with confidence.</p>
                        <p><a href="{{ url('trainers') }}" class="text-theme-colored2">Meet our instructors</a></p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="summary-card">
                        <h3>Classes for real life</h3>
                        <ul>
                            <li>Beginner-friendly group sessions</li>
                            <li>Private classes at home or online</li>
                            <li>Breathwork, meditation and wellness support</li>
                            <li>Workshops and teacher-training programmes</li>
                        </ul>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="summary-card">
                        <h3>Find a suitable option</h3>
                        <p>Explore classes, centres and wellness services in your area. If you are unsure where to start, our team can help you choose the right format.</p>
                        <p><a href="{{ route('yoga.center') }}" class="text-theme-colored2">Explore centres and services</a></p>
                    </article>
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
                                        <img class="img-fullwidth" width="200" height="200" loading="lazy" decoding="async" alt="YogIntra Instructor - {{ $trainer->name ?? 'Instructor' }}" title="YogIntra Instructor - {{ $trainer->name ?? 'Instructor' }}" src="{{ $api . '/' . ($trainer->profile_image ?? '') }}">
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

    <section class="yogintra-guidance-section">
        <div class="container pt-70 pb-70 text-center">
            <div class="yogintra-guidance-panel">
            <div class="section-title">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <span class="yogintra-guidance-kicker">Thoughtful, personal support</span>
                        <h3 class="h2 mt-0 line-height-1">Guidance for Your <span class="text-theme-colored2">Practice</span></h3>
                        <p class="yogintra-guidance-copy">A knowledgeable instructor can help you understand core techniques, develop appropriate movement patterns, and build a practice suited to your current experience.</p>
                    </div>
                </div>
            </div>
            <p class="yogintra-guidance-focus">Our instructors can help you focus on:</p>
            <ul class="yogintra-guidance-list">
                <li>Foundations and mindful movement</li>
                <li>Posture and alignment</li>
                <li>Breathing practices</li>
                <li>Flexibility and mobility</li>
                <li>Strength-building movements</li>
                <li>Relaxation techniques</li>
                <li>Wellness and mindfulness</li>
                <li>Building consistent habits</li>
            </ul>
            <p class="yogintra-guidance-footer">Whether you are getting started or continuing an established practice, the right guidance can make each session more structured, purposeful, and personal.</p>
            <p class="yogintra-guidance-note"><time datetime="2026-09-20">Last reviewed: September 20, 2026</time> · Wellness information is for general education only and is not a substitute for medical advice. Please consult a qualified healthcare professional before starting a new exercise practice, especially if you have an injury, health condition, or are pregnant.</p>
            <p class="yogintra-guidance-policy"><a class="btn btn-theme-colored btn-flat" href="{{ url('editorial-policy') }}">Read Editorial Policy</a></p>
            </div>
        </div>
    </section>

    <section class="review-section bg-lighter">
        <div class="container pt-70 pb-70">
            <div class="section-title text-center">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h3 class="h2 mt-0 line-height-1">What Our <span class="text-theme-colored2">Clients Say</span></h3>
                        <p class="text-black">Real testimonials from our dedicated practitioners and students</p>
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
                                                     title="{{ $testimonial->test_name }}"
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
                                    YogIntra offers guided classes, wellness programmes and community events. Each option supports movement, rest and everyday wellbeing.
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
                                    <p>Choose from:</p>
                                    <ul class="list-unstyled">
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Group classes (beginner to advanced)</li>
                                        <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Online and at-home classes</li>
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
                                    Many locations offer trial or introductory packages. Check current options before you book.
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
                                    <p>Yes. Instructors can tailor a plan for:</p>
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
                                    <p>You can contact our team by:</p>
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
        <script src="{{ asset('assets/front/js/home-page.min.js') }}" defer></script>

    

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
