@extends('layouts.layout')
@push('styles')
    <link rel="preload" as="image" href="{{ asset('uploads/6501ab36d6f70Rectrangular-logo-2.png') }}" type="image/png">
    <style>
        #home {
            min-height: 100vh;
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
            background: #e07f00 !important;
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
        }
        
        /* iPad specific fixes */
        @media screen and (min-width: 768px) and (max-width: 1024px) {
            .section_1 .benefit-icon .icon{
                background: transparent
            }
            #home {
                min-height: auto !important;
                height: 550px !important;
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
  </style>
@endpush
@section('content')
    {{-- Preload the mobile banner image for faster paint --}}
    <link rel="preload" as="image" href="{{ asset('assets/Mobile-Banner-new.webp') }}" fetchpriority="high" />

    <section id="home" class="divider">
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
                    <img src="{{ asset($slider->slider_image) }}" width="1519" height="854" loading="lazy" alt="YogIntra - {{ $slider->slider_heading }}" >
                    <div class="overlay"></div>
                    <div class="display-table display-table-absolute">
                        <div class="display-table-cell">
                            <div class="container position-ab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="bg-white-transparent pt-20 pb-50 outline-border">
                                            <h3 class="text-black-555 font-54 heading-bold">
                                                {{ $slider->slider_heading }}
                                            </h3>
                                            
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
                                <h3 class="text-black-555 mob-font-54">{{ $mob_heading }}</h3>
                                <h3 class="font-weight-400 margin-tp sub_heading mob-sub_heading">{{ $mob_sub_heading }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="section-content-image section-content-bg" style="background-image: url('{{ asset($section_1->of_image) }}');">
        <div class="container">
            <div class="section-title text-center">
                <div class="row">
                    <div class="col-md-7 col-md-offset-5">
                        <h1 class="text-uppercase line-bottom-double-line-centered mt-0 cst-font">
                            {{ $section_1->of_heading }}
                        </h1>
                        <span class="sub-heading">{{ $section_1->of_sub_heading }}</span>
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
                                        <a href="{{ route('yoga.center') }}" class="icon icon-circled icon-md pull-left flip">
                                            <img src="{{ asset($content_1->of_image) }}" 
                                                width="75" height="75" loading="lazy" alt="YogIntra Feature - {{ $content_1->of_heading }}" decoding="async">
                                        </a>
                                        <div class="media-body">
                                            <h3 class="media-heading heading"><b>{{ $content_1->of_heading }}</b></h3>
                                            <p class="text-black">{{ $content_1->of_description }}</p>
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
                        <h5 class="section-3 mb-0 sub-heading">{{ $section_2->os_image_sub_heading }}</h5>
                        <div class="fs-50 ssc-ttl m-fs-25">{{ $section_2->os_image_heading }}</div>
                        <div>
                            <p class="text-black">{!! $section_2->os_image_description !!}</p>
                        </div>
                        <div class="row mt-10">
                            @foreach ($section_2_content as $content_sec_2)
                                <div class="col-sm-4 text-center">
                                    <div class="">
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

    <section class="divider types-of-yoga-section py-70 section-parallax-bg" style="background-image: url('{{ asset('assets/parallax-decor2.png') }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-50">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10">
                                <h3 class="ssc-ttl brief-dec-title m-fs-25 mb-20">A BRIEF DESCRIPTION OF THE TYPES OF YOGA SERVICES</h3>
                                <p class="text-center">We at YogIntra provide various services to the nature of the clients. Wish how you would like to spend your time here we can talk and come to a conclusion.</p>
                            </div>
                        </div>
                    </div>
                    <div class="section-content">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-ipad">
                                @foreach ($rand_service as $r_service)
                                    <div class="col-lg-3 col-md-3 col-sm-4 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                        <div class="yoga-service-item text-center">
                                            <img class="img-circle img-thumbnail mb-20" src="{{ asset($r_service->service_cat_image) }}" loading="lazy" decoding="async" alt="YogIntra Service Category - {{ $r_service->service_cat_name }}">
                                            <h2 class="mb-15 fs-16">{{ $r_service->service_cat_name }}</h2>
                                            <a href="{{ url('service/' . $r_service->service_cat_slug) }}" class="btn-sm-cs btn btn-success">Book Now</a>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-lg-3 col-md-3 col-sm-4 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    <div class="yoga-service-item text-center">
                                        <img class="img-circle img-thumbnail mb-20" src="{{ asset('assets/icon-thumb3-150x150.jpg') }}" decoding="async" loading="lazy" alt="YogIntra TTC - Teacher Training Course">
                                        <h2 class="mb-15 fs-16">TTC</h2>
                                        <a href="{{ route('ttc') }}" class="btn-sm-cs btn btn-success">Visit Now</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-4 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    <div class="yoga-service-item text-center">
                                        <img class="img-circle img-thumbnail mb-20" src="{{ asset('assets/icon-thumb4-150x150.jpg') }}" height="150" width="150" decoding="async" loading="lazy" alt="YogIntra Retreat Programs">
                                        <h2 class="mb-15 fs-16">Retreat</h2>
                                        <a href="{{ route('retreat.all') }}" class="btn-sm-cs btn btn-success">Visit Now</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    <div class="yoga-service-item text-center">
                                        <img class="img-circle img-thumbnail mb-20" src="{{ asset('assets/icon-thumb1-150x150.webp') }}" height="150" width="150" decoding="async" loading="lazy" alt="YogIntra Yoga Workshops">
                                        <h2 class="mb-15 fs-16">Workshop</h2>
                                        <a href="{{ route('workshop') }}" class="btn-sm-cs btn btn-success">Visit Now</a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-6 mb-30 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    <div class="yoga-service-item text-center">
                                        <img class="img-circle img-thumbnail mb-20" src="{{ asset('uploads/yog_center.jpg') }}" width="150" height="150" loading="lazy" decoding="async" alt="YogIntra Yoga Center and Training Facility">
                                        <h2 class="mb-15 fs-16">Yoga Center</h2>
                                        <a href="{{ route('yoga.center') }}" class="btn-sm-cs btn btn-success">Visit Now</a>
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
                        <h2 class="mt-0 line-height-1">Meet Our <span class="text-theme-colored2">Instructors</span></h2>
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
                                        <img class="img-fullwidth" width="200" height="200" loading="lazy" decoding="async" alt="YogIntra Instructor - {{ $trainer->name }}" src="{{ $api . '/' . $trainer->profile_image }}">
                                    </div>
                                    @php
                                        $currentYear = now()->year;
                                        $birthYear = \Carbon\Carbon::parse($trainer->dob)->year;
                                        $age = $currentYear - $birthYear;
                                    @endphp
                                    <div class="team-details">
                                        <div class="p-10">
                                            <h4 class="text-uppercase mt-0 mb-0 text-dark">{{ $trainer->name }}</h4>
                                            <p class="mt-0 mb-0">Age - {{ $age }}</p>
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

    <section class="review-section">
        <div class="container">
            <div class="row">
                <div class='sk-ww-google-reviews' data-embed-id='25389280'></div>
                <script data-src='https://widgets.sociablekit.com/google-reviews-old/widget.js'></script>
            </div>
        </div>
    </section>

    <!-- Form moved to chat icon popup -->


@endsection
@push('scripts')
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
                            "url": "{{ url('service/' . $service->service_cat_slug) }}",
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
                "url": "{{ url('service/' . $service->service_cat_slug) }}",
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