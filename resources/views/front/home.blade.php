@extends('layouts.layout')
@push('styles')
    <link rel="preload" as="image" href="{{ asset('assets/Home-Banner.webp') }}" type="image/webp">
    <style>
        .yg-txt-right{
            text-align:right;
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
  </style>
@endpush
@section('content')
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
                    <img src="{{ asset($slider->slider_image) }}" width="1519" height="854" alt="yogintra yoga poses"
                        @if($index !== 0) loading="lazy" @endif>
                    <div class="overlay"></div>
                    <div class="display-table" style="position: absolute; top: 0;">
                        <div class="display-table-cell">
                            <div class="container position-ab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="bg-white-transparent pt-20 pb-50 outline-border">
                                            <h2 class="text-black-555 font-54" style="font-weight: 900">
                                                {{ $slider->slider_heading }}
                                            </h2>
                                            <h5 class="font-weight-400 margin-tp sub_heading">
                                                {{ $slider->slider_sub_heading }}
                                            </h5>
                                            @if ($slider->slider_btn_name && $slider->slider_btn_link)
                                                <a class="btn btn-theme-colored btn-flat mt-15"
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

        <div class="mobile-home position-relative" style="width: 100%;">
            <img
                src="{{ asset('assets/Home-Banner.webp') }}"
                alt="Yoga and Meditation Banner"
                width="360"
                height="640"
                decoding="async"
                fetchpriority="high"
                style="width: 100%; height: auto; display: block;"
            >

            <div class="position-absolute top-0 left-0 w-100 align-items-center p-15 pt-0">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bg-white-transparent pt-20 pb-50 outline-border">
                                <h2 class="text-black-555 mob-font-54">{{ $mob_heading }}</h2>
                                <h5 class="font-weight-400 margin-tp sub_heading mob-sub_heading">{{ $mob_sub_heading }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="section-content-image" style="background-image: url('{{ asset($section_1->of_image) }}'); background-repeat: no-repeat; background-size: auto; min-height: 600px;">
        <div class="container">
            <div class="section-title text-center">
                <div class="row">
                    <div class="col-md-7 col-md-offset-5">
                        <h2 class="text-uppercase line-bottom-double-line-centered mt-0 cst-font">
                            {{ $section_1->of_heading }}
                        </h2>
                        <span>{{ $section_1->of_sub_heading }}</span>
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
                                        <a class="icon icon-circled icon-md pull-left flip">
                                            <img src="{{ asset($content_1->of_image) }}" 
                                                width="75" height="75" loading="lazy" alt="yogintra" decoding="async">
                                        </a>
                                        <div class="media-body">
                                            <h2 class="media-heading heading"><b>{{ $content_1->of_heading }}</b></h2>
                                            <p>{{ $content_1->of_description }}</p>
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

    <section class="divider" style="background-image: url('{{ asset('assets/pattern-chakras-alt-color.webp') }}'); background-repeat: repeat; background-size: auto;">
        <div class="elementor-shape elementor-shape-top" data-negative="false">
            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 283.5 27.8" preserveAspectRatio="xMidYMax slice">
                <path class="elementor-shape-fill" d="M0 0v6.7c1.9-.8 4.7-1.4 8.5-1 9.5 1.1 11.1 6 11.1 6s2.1-.7 4.3-.2c2.1.5 2.8 2.6 2.8 2.6s.2-.5 1.4-.7c1.2-.2 1.7.2 1.7.2s0-2.1 1.9-2.8c1.9-.7 3.6.7 3.6.7s.7-2.9 3.1-4.1 4.7 0 4.7 0 1.2-.5 2.4 0 1.7 1.4 1.7 1.4h1.4c.7 0 1.2.7 1.2.7s.8-1.8 4-2.2c3.5-.4 5.3 2.4 6.2 4.4.4-.4 1-.7 1.8-.9 2.8-.7 4 .7 4 .7s1.7-5 11.1-6c9.5-1.1 12.3 3.9 12.3 3.9s1.2-4.8 5.7-5.7c4.5-.9 6.8 1.8 6.8 1.8s.6-.6 1.5-.9c.9-.2 1.9-.2 1.9-.2s5.2-6.4 12.6-3.3c7.3 3.1 4.7 9 4.7 9s1.9-.9 4 0 2.8 2.4 2.8 2.4 1.9-1.2 4.5-1.2 4.3 1.2 4.3 1.2.2-1 1.4-1.7 2.1-.7 2.1-.7-.5-3.1 2.1-5.5 5.7-1.4 5.7-1.4 1.5-2.3 4.2-1.1c2.7 1.2 1.7 5.2 1.7 5.2s.3-.1 1.3.5c.5.4.8.8.9 1.1.5-1.4 2.4-5.8 8.4-4 7.1 2.1 3.5 8.9 3.5 8.9s.8-.4 2 0 1.1 1.1 1.1 1.1 1.1-1.1 2.3-1.1 2.1.5 2.1.5 1.9-3.6 6.2-1.2 1.9 6.4 1.9 6.4 2.6-2.4 7.4 0c3.4 1.7 3.9 4.9 3.9 4.9s3.3-6.9 10.4-7.9 11.5 2.6 11.5 2.6.8 0 1.2.2c.4.2.9.9.9.9s4.4-3.1 8.3.2c1.9 1.7 1.5 5 1.5 5s.3-1.1 1.6-1.4c1.3-.3 2.3.2 2.3.2s-.1-1.2.5-1.9 1.9-.9 1.9-.9-4.7-9.3 4.4-13.4c5.6-2.5 9.2.9 9.2.9s5-6.2 15.9-6.2 16.1 8.1 16.1 8.1.7-.2 1.6-.4V0H0z"></path>
            </svg>
        </div>
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset($section_2->os_image_image) }}" width="349" height="348" loading="lazy" decoding="async" alt="{{ $section_2->os_image_heading }}">
                    </div>
                    <div class="col-md-6">
                        <h5 class="section-3 mb-0">{{ $section_2->os_image_sub_heading }}</h5>
                        <div class="section-3-title ssc-ttl">{{ $section_2->os_image_heading }}</div>
                        <div>
                            <p>{!! $section_2->os_image_description !!}</p>
                        </div>
                        <div class="row mt-10">
                            @foreach ($section_2_content as $content_sec_2)
                                <div class="col-sm-4 text-center">
                                    <div class="">
                                        <img src="{{ asset($content_sec_2->os_image) }}" width="90" height="95" loading="lazy" decoding="async" alt="{{ $content_sec_2->os_heading }}">
                                    </div>
                                    <h2 style="font-size: 16px">{{ $content_sec_2->os_heading }}</h2>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="divider types-of-yoga-section" style="background-image: url('{{ asset('assets/parallax-decor.webp') }}'); background-position: center center; background-size: auto;">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="section-title">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="ssc-ttl brief-dec-title">A BRIEF DESCRIPTION OF THE TYPES OF YOGA SERVICES</h1>
                                <p>We at YogIntra provide various services to the nature of the clients. Wish how you would like to spend your time here we can talk and come to a conclusion.</p>
                            </div>
                        </div>
                    </div>
                    <div class="section-content text-center">
                        <div class="row">
                            @foreach ($rand_service as $r_service)
                                <div class="col-xs-12 col-sm-6 col-md-3 mb-sm-40 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
                                    <img class="img-circle img-thumbnail mb-0" src="{{ asset($r_service->service_cat_image) }}" height="150" width="150" loading="lazy" decoding="async" alt="{{ $r_service->service_cat_name }}">
                                    <h4 class="mb-5">{{ $r_service->service_cat_name }}</h4>
                                    <a href="{{ url('service/' . $r_service->service_cat_slug) }}" class="btn btn-success">Book Now</a>
                                </div>
                            @endforeach

                            <div class="col-xs-12 col-sm-6 col-md-3 mb-sm-40 wow fadeInLeft mt-20" data-wow-duration="1s" data-wow-delay="0.3s">
                                <img class="img-circle img-thumbnail mb-0" src="{{ asset('assets/icon-thumb3-150x150.jpg') }}" height="150" width="150" decoding="async" loading="lazy" alt="TTC">
                                <h4 class="mb-5">TTC</h4>
                                <a href="{{ url('teacher-training-course') }}" class="btn btn-success">Visit Now</a>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 mb-sm-40 wow fadeInLeft mt-20" data-wow-duration="1s" data-wow-delay="0.3s">
                                <img class="img-circle img-thumbnail mb-0" src="{{ asset('assets/icon-thumb4-150x150.jpg') }}" height="150" width="150" decoding="async" loading="lazy" alt="Retreat">
                                <h4 class="mb-5">Retreat</h4>
                                <a href="{{ url('retreat') }}" class="btn btn-success">Visit Now</a>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 mb-sm-40 wow fadeInLeft mt-20" data-wow-duration="1s" data-wow-delay="0.3s">
                                <img class="img-circle img-thumbnail mb-0" src="{{ asset('assets/icon-thumb1-150x150.webp') }}" height="150" width="150" decoding="async" loading="lazy" alt="Workshop">
                                <h4 class="mb-5">Workshop</h4>
                                <a href="{{ url('workshop') }}" class="btn btn-success">Visit Now</a>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-3 mb-sm-40 wow fadeInLeft mt-20 animated" data-wow-duration="1s" data-wow-delay="0.3s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s;">
                                <img width="150" height="150" loading="lazy" decoding="async" class="img-circle img-thumbnail mb-0" src="{{ asset('uploads/yog_center.jpg') }}" alt="Yoga Center">
                                <h4 class="mb-5">Yoga Center</h4>
                                <a href="{{ url('yoga_center') }}" class="btn btn-success">Visit Now</a>
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
                                        <img class="img-fullwidth" width="200" height="200" loading="lazy" decoding="async" alt="yogintra trainers" src="{{ $api . '/' . $trainer->profile_image }}">
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

    <section class="divider bg-gradient_effect d-none">
        <div class="elementor-shape">
            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 283.5 27.8" preserveAspectRatio="none">
                <path class="elementor-shape-fill" d="M283.5,9.7c0,0-7.3,4.3-14,4.6c-6.8,0.3-12.6,0-20.9-1.5c-11.3-2-33.1-10.1-44.7-5.7 
                s-12.1,4.6-18,7.4c-6.6,3.2-20,9.6-36.6,9.3C131.6,23.5,99.5,7.2,86.3,8c-1.4,0.1-6.6,0.8-10.5,2c-3.8,1.2-9.4,3.8-17,4.7 
                c-3.2,0.4-8.3,1.1-14.2,0.9c-1.5-0.1-6.3-0.4-12-1.6c-5.7-1.2-11-3.1-15.8-3.7C6.5,9.2,0,10.8,0,10.8V0h283.5V9.7z">
                </path>
            </svg>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-6 text-center">
                    <img class="img-circle img-thumbnail mb-15" 
                        src="{{ asset('css/images/about/sq1.jpg') }}" 
                        loading="lazy" 
                        decoding="async"
                        alt="yogintra">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <h2 class="mb-5">Power Vinyasa</h2>
                            <h5>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero omnis unde nesciunt?</h5>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 text-center">
                    <div class="section-4-title">Dietetics and Nutrition</div>
                    <h4>
                        Aziza Firdaus has 7 years of Clinical Experience in Dietetics & Nutrition 
                        in the hospital sector and private clinics, as well as online coaching. 
                        Her objective is to serve society with utmost speed, quality, and integrity, 
                        achieving her goals effectively and efficiently. She has given good results to 
                        her clients and played a role in their journey to becoming healthy.
                    </h4>
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

    <section class="bg-lighter">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    @include('components.multi-step-form', ['app_setting' => $app_setting])
                </div>
                <div class="col-sm-6">
                    <img src="{{ asset('assets/chose_yoga.webp') }}" class="bf-ftr-img" decoding="async" loading="lazy" alt="yoga poses">
                </div>
            </div>
        </div>
    </section>


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
@endpush