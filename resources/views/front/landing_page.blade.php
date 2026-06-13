@extends('layouts.layout')

@section('meta_title', $page_data->page_meta_title ?? '')
@section('meta_description', $page_data->page_meta_description ?? '' )
@section('meta_keywords', $page_data->page_keywords ?? '' )

@push('page_preloads')
    <!-- Critical preloads for LCP optimization -->
    <link rel="preload" as="image" href="{{ asset($page_data->page_image) }}" fetchpriority="high" media="(min-width: 768px)">
    <link rel="preload" as="image" href="{{ asset($page_data->page_image) }}" fetchpriority="high" media="(max-width: 767px)">
    
    <!-- DNS prefetch for external resources -->
    <link rel="dns-prefetch" href="https://geodata.phplift.net">
    <link rel="dns-prefetch" href="https://widgets.sociablekit.com">
    
    <!-- Optimize hero image rendering -->
    <link rel="preconnect" href="{{ asset('') }}" crossorigin>
    
    <!-- Critical inline styles for above-the-fold content -->
    <style>
        #home {
            background-image: url('{{ asset($page_data->page_image) }}') !important;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: scroll;
            contain: layout style paint;
            will-change: background-image;
        }
        
        @media (min-width: 768px) {
            #home {
                min-height: 50vh;
            }
        }
        
        @media (max-width: 767px) {
            #home {
                min-height: 35vh;
                padding: 40px 20px !important;
            }
        }
        
        .home-content {
            z-index: 2;
            position: relative;
        }
        
        /* Prevent layout shift on hero section */
        #home::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to left, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
            z-index: 1;
        }
    </style>
@endpush

@push('styles')
<style>
    #home {
        min-height: 50vh;
        height: auto;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: scroll !important;
        position: relative;
        padding: 40px 0 !important;
        overflow: hidden;
        background-image: url('{{ asset($page_data->page_image) }}');
        background-color: #000;
        contain: layout style paint;
        will-change: background-image;
    }
    
    #home::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to left, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4)); /* Darker overlay for better text readability */
        z-index: 1;
    }
    
    #home .display-table {
        position: relative;
        z-index: 2;
        width: 100%;
        height: auto;
        display: table;
    }
    
    #home .display-table-cell {
        height: auto;
        display: table-cell;
        vertical-align: middle;
    }
    
    /* Added for better text readability */
    .home-content {
        padding: 15px;
        border-radius: 8px;
        background-color: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(3px);
    }
    
    @media (max-width: 767px) {
        #home {
            min-height: 40vh;
            background-position: 30% center !important;
            background-size: cover !important;
            background-attachment: scroll !important;
            padding: 30px 15px !important;
        }
        #home::before {
            background: rgba(0, 0, 0, 0.7) !important;
        }
        .home-content {
            text-align: center !important;
            width: 100% !important;
            background-color: rgba(0, 0, 0, 0.3) !important;
            padding: 10px !important;
        }
        .home-content h1 {
            font-size: 1.5rem !important;
            line-height: 1.3 !important;
            margin: 0 !important;
        }
        .home-content h3,
        .home-content h5 {
            font-size: 0.9rem !important;
            margin-top: 10px !important;
        }
    }

    /* Fix Google Reviews widget image aspect ratio warnings */
    .sk-ww-google-reviews img,
    .media_link img {
        max-width: 100% !important;
        height: auto !important;
        width: auto !important;
    }
    
    @media (min-width: 768px) {
        #home {
            position: relative;
            padding: 40px 0 !important;
        }
        .display-table {
            height: auto;
            display: table;
            width: 100%;
        }
        .display-table-cell {
            position: relative !important;
            vertical-align: middle;
            display: table-cell;
            height: auto;
        }
        .home-content {
            text-align: right !important;
            float: right !important;
            width: 45% !important;
            margin-right: 8% !important;
            clear: both;
        }
        .home-content h1,
        .home-content h5 {
            text-align: right !important;
            word-wrap: break-word;
            line-height: 1.2;
        }
        .home-content h1 {
            max-width: 100% !important;
            white-space: normal !important;
            font-size: 2.8rem;
            line-height: 1.2;
        }
        
        .home-content h5 {
            font-size: 1rem;
            line-height: 1.4;
            max-width: 100%;
        }
    }
    
    .yoga-section {
        padding: 30px 0;
    }
    
    .form-step {
        display: none;
    }
    
    .form-step.active {
        display: block;
    }
    
    .bg-black-333 {
        background-color: #01AEB7 !important;
    }
    
    .form-group label, .error-message {
        color: #fff;
    }
    
    @media (min-width: 768px) {
        /* Desktop/Tablet - restore original layout */
        .col-sm-4 {
            display: block !important;
            width: calc(33.333% - 20px) !important;
            margin: 0 10px !important;
            float: left !important;
        }

        .col-sm-4 h2 {
            font-size: 16px !important;
        }

        .col-sm-4 img {
            width: 100px !important;
            height: 100px !important;
            image-rendering: crisp-edges !important;
            image-rendering: -webkit-optimize-contrast !important;
            -ms-interpolation-mode: nearest-neighbor !important;
            backface-visibility: hidden !important;
            -webkit-backface-visibility: hidden !important;
            transform: translateZ(0) !important;
            -webkit-transform: translateZ(0) !important;
            will-change: transform !important;
        }

        /* Restore desktop icon box alignment */
        .icon-box.media {
            display: flex !important;
            flex-direction: row !important;
            align-items: flex-start !important;
            justify-content: flex-start !important;
            text-align: left !important;
        }

        .icon-box .icon {
            float: left !important;
            margin-bottom: 0 !important;
            margin-right: 25px !important;
            margin-left: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: auto !important;
            flex-shrink: 0;
        }

        .icon-box .icon img {
            width: 90px !important;
            height: 90px !important;
            image-rendering: crisp-edges !important;
            image-rendering: -webkit-optimize-contrast !important;
            -ms-interpolation-mode: nearest-neighbor !important;
            backface-visibility: hidden !important;
            -webkit-backface-visibility: hidden !important;
            transform: translateZ(0) !important;
            -webkit-transform: translateZ(0) !important;
            will-change: transform !important;
            filter: drop-shadow(0 0 0px rgba(0,0,0,0)) !important;
        }

        .icon-box .media-body {
            width: auto !important;
            text-align: left !important;
            flex-grow: 1;
        }

        .icon-box.left {
            text-align: left !important;
        }

        /* Desktop col-lg-6 layout */
        .col-lg-6.col-md-12.col-sm-12.w-48-desktop {
            display: inline-block !important;
            width: calc(50% - 10px) !important;
            margin-bottom: 25px !important;
            padding: 5px !important;
            vertical-align: top;
            box-sizing: border-box;
        }

        .col-lg-6 .icon-box {
            margin: 0 !important;
            text-align: left !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: flex-start;
            padding: 10px !important;
        }

        .pull-left.flip {
            float: left !important;
            margin-right: 20px !important;
            margin-bottom: 0 !important;
            margin-left: 0 !important;
        }
    }

    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
        /* Tablet-specific styles */
        .w-48-desktop {
            width: 48% !important;  
        }
        
        /* Fix for home section in tablet view */
        #home {
            min-height: 40vh !important;
            background-size: cover !important;
            padding: 60px 0 !important;
            background-position: 70% center !important;
            background-attachment: scroll !important;
        }
        
        .display-table {
            height: auto !important;
        }
        
        .display-table-cell {
            height: auto !important;
        }
        
        .home-content {
            text-align: center !important;
            float: none !important;
            width: 80% !important;
            margin: 0 auto !important;
            clear: both;
            padding: 20px;
            background-color: rgba(0,0,0,0.5);
            border-radius: 10px;
        }
        
        .home-content h1 {
            font-size: 2.5rem !important;
            text-align: center !important;
            line-height: 1.2;
        }
        
        .home-content h5 {
            text-align: center !important;
            margin-top: 10px !important;
        }
        
        /* Fix for about section author description in tablet view */
        .about-section .image-column .inner-column .author-desc {
            position: absolute !important;
            bottom: 19px !important;
            z-index: 1 !important;
            background: orange !important;
            padding: 5px 5px !important;
            left: 100px !important;
            width: 50% !important;
            border-radius: 1 !important;
        }
      }
 
    @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
        #about {
            text-align: center;
        }
        h1.font-54{
            font-size: 1.857143rem !important;
            }
        }
      .sec-title {
         position: relative;
         z-index: 1;
         margin-bottom: 20px;
      }

      .sec-title .title {
         position: relative;
         display: block;
         font-size: 18px;
         line-height: 24px;
         color: #176a71;
         font-weight: 500;
         margin-bottom: 15px;
      }

      .sec-title h2 {
         position: relative;
         display: block;
         font-size: 40px;
         line-height: 1.28em;
         color: #222222;
         font-weight: 600;
         padding-bottom: 18px;
      }

      .sec-title h2:before {
         position: absolute;
         content: '';
         left: 0px;
         bottom: 0px;
         width: 50px;
         height: 3px;
         background-color: #d1d2d6;
      }

      .sec-title .text {
         position: relative;
         font-size: 16px;
         line-height: 26px;
         color: #848484;
         font-weight: 400;
         margin-top: 35px;
      }

      .sec-title.light h2 {
         color: #ffffff;
      }

      .sec-title.text-center h2:before {
         left: 50%;
         margin-left: -25px;
      }

      .list-style-one {
         position: relative;
      }

      .list-style-one li {
         position: relative;
         font-size: 16px;
         line-height: 26px;
         color: #222222;
         font-weight: 400;
         padding-left: 35px;
         margin-bottom: 12px;
      }

      .list-style-one li:before {
         content: "\f058";
         position: absolute;
         left: 0;
         top: 0px;
         display: block;
         font-size: 18px;
         padding: 0px;
         color: #ff2222;
         font-weight: 600;
         -moz-font-smoothing: grayscale;
         -webkit-font-smoothing: antialiased;
         font-style: normal;
         font-variant: normal;
         text-rendering: auto;
         line-height: 1.6;
         font-family: "Font Awesome 5 Free";
      }

      .list-style-one li a:hover {
         color: #176a71;
      }

      .btn-style-one {
         position: relative;
         display: inline-block;
         font-size: 17px;
         line-height: 30px;
         color: #ffffff;
         padding: 10px 30px;
         font-weight: 600;
         overflow: hidden;
         letter-spacing: 0.02em;
         background-color: #176a71;
      }

      .btn-style-one:hover {
         background-color: #176a71;
         color: #ffffff;
      }

      .about-section {
         position: relative;
         padding: 120px 0 70px;
      }

      .about-section .sec-title {
         margin-bottom: 45px;
      }

      .about-section .content-column {
         position: relative;
         margin-bottom: 50px;
      }

      .about-section .content-column .inner-column {
         position: relative;
         padding-left: 30px;
      }

      .about-section .text {
         margin-bottom: 20px;
         font-size: 16px;
         line-height: 26px;
         color: #848484;
         font-weight: 400;
      }

      .about-section .list-style-one {
         margin-bottom: 45px;
      }

      .about-section .btn-box {
         position: relative;
      }

      .about-section .btn-box a {
         padding: 15px 50px;
      }

      .about-section .image-column {
         position: relative;
      }

      .about-section .image-column .text-layer {
         position: absolute;
         right: -110px;
         top: 50%;
         font-size: 325px;
         line-height: 1em;
         color: #ffffff;
         margin-top: -175px;
         font-weight: 500;
      }

      .about-section .image-column .inner-column {
         position: relative;
         padding-left: 80px;
         padding-bottom: 0px;
      }

      .about-section .image-column .inner-column .author-desc {
         position: absolute;
         bottom: 16px;
         z-index: 1;
         background: orange;
         padding: 10px 15px;
         left: 96px;
         width: calc(100% - 185px);
         border-radius: 50px;
      }

      .about-section .image-column .inner-column .author-desc h4 {
         font-size: 21px;
         letter-spacing: 1px;
         text-align: center;
         color: #fff;
         margin: 0;
      }

      .about-section .image-column .inner-column .author-desc span {
         font-size: 16px;
         letter-spacing: 1px;
         text-align: center;
         color: #fff;
         display: block;
         font-weight: 400;
      }

      .about-section .image-column .inner-column:before {
         content: '';
         position: absolute;
         width: calc(50% + 80px);
         height: calc(100% + 160px);
         top: -80px;
         left: -3px;
         background: transparent;
         z-index: 0;
         border: 44px solid #176a71;
      }

      .about-section .image-column .image-1 {
         position: relative;
      }

      .about-section .image-column .image-2 {
         position: absolute;
         left: 0;
         bottom: 0;
      }

      .about-section .image-column .image-2 img,
      .about-section .image-column .image-1 img {
         box-shadow: 0 30px 50px rgba(8, 13, 62, .15);
         border-radius: 46px;
      }

      .about-section .image-column .video-link {
         position: absolute;
         left: 70px;
         top: 170px;
      }

      .about-section .image-column .video-link .link {
         position: relative;
         display: block;
         font-size: 22px;
         color: #191e34;
         font-weight: 400;
         text-align: center;
         height: 100px;
         width: 100px;
         line-height: 100px;
         background-color: #ffffff;
         border-radius: 50%;
         box-shadow: 0 30px 50px rgba(8, 13, 62, .15);
         -webkit-transition: all 300ms ease;
         -moz-transition: all 300ms ease;
         -ms-transition: all 300ms ease;
         -o-transition: all 300ms ease;
         transition: all 300ms ease;
      }

      .about-section .image-column .video-link .link:hover {
         background-color: #191e34;
         color: #fff;
      }

      .layer-overlay.overlay-theme-colored2-9::before {
         background: rgba(17, 17, 17, 0.5) none repeat scroll 0 0;
      }

      .YogIntra-info {
         color: #3d3333;
      }

      @media only screen and (max-width: 600px) {
         .about-section .image-column .image-1 img {
            border-radius: 0 !important;
         }

         .about-section .image-column .inner-column {
            padding-left: 0 !important;
         }
        .padding-top-media
        {
            margin-top:30px;
        }
         .about-section .image-column .inner-column::before {
            content: '';
            position: absolute;
            width: 100% !important;
            height: 350px !important;
            top: -10px !important;
            /*left: -7px !important;*/
            background: transparent;
            z-index: 0;
            border: 44px solid #176a71;
         }

         .about-section {
            position: relative;
            padding: 10px 0 0px !important;
         }

         .about-section .image-column .inner-column .author-desc {
            position: absolute;
            bottom: 0 !important;
            z-index: 1;
            background: orange;
            padding: 5px 5px !important;
            left: 0 !important;
            width: 100% !important;
            border-radius: 0 !important;
         }

         .about-section .image-column .inner-column .author-desc span {
            font-size: 16px;
            letter-spacing: 0 !important;
            text-align: center;
            color: #fff;
            display: block;
            font-weight: 400;
         }

         .sec-title h2 {
            position: relative;
            display: block;
            font-size: 30px !important;
            line-height: 1.28em;
            color: #222222;
            font-weight: 600;
            padding-bottom: 18px;
            text-align: center;
         }

         .about-section .content-column .inner-column {
            position: relative;
            padding-left: 0 !important;
         }

         .about-section .sec-title {
            margin-bottom: 5px !important;
         }

         .sec-title h2::before {
            position: absolute;
            content: '';
            left: 150px !important;
            bottom: 0px;
            width: 50px;
            height: 3px;
            background-color: #d1d2d6;
            text-align: center;
         }

         .about-section .btn-box a {
            padding: 10px 30px !important;
         }

         .about-section .btn-box {
            position: relative;
            text-align: center !important;
         }

         .section-padding {
            padding-bottom: 0px !important;
         }

         .section-padding-2 {
            padding-top: 0 !important;
         }
         .text-xs-center
         {
            text-align: center;
         }
         .text-size
         {
            font-size: 14px!important;
         }
         article
         {
            margin-top: 0!important;
            display: block!important;
         }
         .box1
         {
            margin-right: 20px!important;
            margin-left: 20px;
         }
         .box2
         {
            padding-top: 0!important;
            padding-bottom: 0!important;
            margin: 20px!important;
         }
      }

    .fs-16 {
        font-size: 16px;
    }

    /* LCP Optimizations */
    section:not(#home) {
        content-visibility: auto;
        contain-intrinsic-size: 0 600px;
    }

    /* Defer below-the-fold rendering */
    .bg-lighter {
        content-visibility: auto;
        contain-intrinsic-size: 0 800px;
    }
    
    .review-section {
        content-visibility: auto;
        contain-intrinsic-size: 0 900px;
    }

    /* Optimize images */
    img[loading="lazy"] {
        content-visibility: auto;
    }
    
    /* Reduce repaints on scroll */
    #home .display-table {
        will-change: auto;
        transform: translateZ(0);
    }

    .sub-text-custom {
        text-align: center; 
        font-weight: bold; 
        font-size: 30px !important;
    }

    .color-444{
        color: #444444 !important;
    }

    /* Hide empty sections that create gap after banner */
    section:has(> .container > .section-title:empty),
    section:has(> .container:only-child > .section-title:empty) {
        display: none !important;
    }

    /* Mobile Layout Fixes */
    @media (max-width: 767px) {
        /* General spacing fixes */
        .container {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        /* Section spacing */
        section {
            padding: 20px 0 !important;
        }

        section .container {
            padding-top: 20px !important;
            padding-bottom: 20px !important;
        }

        /* Icon boxes responsive */
        .icon-box {
            margin-bottom: 20px !important;
            padding: 15px 10px !important;
        }

        .icon-box .media-body {
            padding-left: 15px !important;
        }

        .icon-box h3 {
            font-size: 16px !important;
            margin: 10px 0 !important;
        }

        .icon-box p {
            font-size: 13px !important;
            line-height: 1.5 !important;
            margin: 0 !important;
        }

        /* Icon responsive */
        .icon img {
            width: 60px !important;
            height: 60px !important;
            image-rendering: crisp-edges !important;
            image-rendering: -webkit-optimize-contrast !important;
            -ms-interpolation-mode: nearest-neighbor !important;
            backface-visibility: hidden !important;
            -webkit-backface-visibility: hidden !important;
            transform: translateZ(0) !important;
            -webkit-transform: translateZ(0) !important;
            will-change: transform !important;
        }

        /* Section title fixes */
        .section-title {
            margin-bottom: 20px !important;
        }

        .section-title h2,
        .section-title h3 {
            font-size: 24px !important;
            margin: 15px 0 !important;
            line-height: 1.3 !important;
        }

        .section-title p {
            font-size: 13px !important;
            line-height: 1.6 !important;
            margin: 10px 0 !important;
        }

        /* Row and column spacing */
        .row {
            margin-left: -10px !important;
            margin-right: -10px !important;
        }

        .row > [class^="col-"],
        .row > [class*=" col-"] {
            padding-left: 10px !important;
            padding-right: 10px !important;
            margin-bottom: 15px !important;
        }

        /* Service cards */
        .col-xs-12.col-sm-6.col-md-3 {
            padding: 10px !important;
        }

        .col-xs-12.col-sm-6.col-md-3 img {
            max-width: 120px !important;
            height: auto !important;
            margin-bottom: 10px !important;
        }

        .col-xs-12.col-sm-6.col-md-3 h2 {
            font-size: 14px !important;
            margin: 10px 0 !important;
        }

        .col-xs-12.col-sm-6.col-md-3 .btn {
            padding: 8px 15px !important;
            font-size: 12px !important;
        }

        /* About section stacking */
        .image-column {
            margin-bottom: 30px !important;
            text-align: center !important;
        }

        .image-column img {
            max-width: 100% !important;
            height: auto !important;
            border-radius: 10px !important;
        }

        .content-column {
            padding: 0 !important;
        }

        .content-column .sec-title h4 {
            font-size: 24px !important;
            text-align: center !important;
        }

        .content-column .text {
            text-align: center !important;
            font-size: 13px !important;
        }

        .content-column .btn-box {
            text-align: center !important;
        }

        /* Divider section responsive */
        .divider.parallax {
            min-height: auto !important;
            padding: 20px 0 !important;
        }

        .divider .container {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
        }

        /* Media boxes alignment */
        .media {
            display: flex !important;
            flex-direction: column;
            text-align: center !important;
            align-items: center !important;
        }

        .media .icon {
            margin-right: 0 !important;
            margin-bottom: 15px !important;
        }

        /* Text alignment */
        .text-center {
            text-align: center !important;
        }

        .text-start,
        .text-md-start {
            text-align: center !important;
        }

        /* Button responsive */
        .btn {
            display: inline-block !important;
            padding: 10px 20px !important;
            font-size: 13px !important;
            width: auto !important;
        }

        /* Heading responsive sizing */
        h1, .h1 {
            font-size: 24px !important;
        }

        h2, .h2 {
            font-size: 20px !important;
        }

        h3, .h3 {
            font-size: 18px !important;
        }

        h4, .h4 {
            font-size: 16px !important;
        }

        h5, .h5 {
            font-size: 14px !important;
        }

        /* Image circle responsive */
        .img-circle {
            max-width: 120px !important;
            max-height: 120px !important;
        }

        /* Offset removal on mobile */
        .col-md-offset-2,
        .offset-md-2 {
            margin-left: 0 !important;
        }

        /* Fix large images on mobile */
        img[src*="download.webp"],
        img[src*="Square-Logo"] {
            max-width: 100% !important;
            height: auto !important;
            width: 100% !important;
        }

        /* Pull left/right handling on mobile */
        .pull-left,
        .pull-right {
            float: none !important;
            margin: 0 auto 15px !important;
        }

        /* Flip handling */
        .flip {
            float: none !important;
        }

        /* Prevent horizontal scrollbar */
        table {
            width: 100% !important;
            overflow-x: auto !important;
        }

        /* Icon section fixes for mobile */
        .col-sm-4 {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100% !important;
            text-align: center !important;
        }

        .col-sm-4 img {
            width: 80px !important;
            height: 80px !important;
            margin: 0 auto 15px !important;
            display: block !important;
            image-rendering: crisp-edges !important;
            image-rendering: -webkit-optimize-contrast !important;
            -ms-interpolation-mode: nearest-neighbor !important;
            backface-visibility: hidden !important;
            -webkit-backface-visibility: hidden !important;
            transform: translateZ(0) !important;
            -webkit-transform: translateZ(0) !important;
            will-change: transform !important;
        }

        .col-sm-4 h2 {
            font-size: 15px !important;
            font-weight: 600 !important;
            margin: 10px 0 !important;
            line-height: 1.3 !important;
            word-wrap: break-word !important;
        }

        /* Icon box media alignment fixes */
        .icon-box.media {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
        }

        .icon-box .icon {
            float: none !important;
            margin-bottom: 15px !important;
            margin-right: 0 !important;
            margin-left: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }

        .icon-box .icon img {
            width: 75px !important;
            height: 75px !important;
            display: block !important;
            margin: 0 auto !important;
            image-rendering: crisp-edges !important;
            image-rendering: -webkit-optimize-contrast !important;
            -ms-interpolation-mode: nearest-neighbor !important;
            backface-visibility: hidden !important;
            -webkit-backface-visibility: hidden !important;
            transform: translateZ(0) !important;
            -webkit-transform: translateZ(0) !important;
            will-change: transform !important;
        }

        .icon-box .media-body {
            width: 100% !important;
            text-align: center !important;
            padding: 0 !important;
        }

        .icon-box.left {
            text-align: center !important;
        }

        /* Yoga reasons section mobile alignment */
        .col-lg-6.col-md-12.col-sm-12.w-48-desktop {
            display: block !important;
            width: 100% !important;
            margin-bottom: 30px !important;
            padding: 15px !important;
        }

        .col-lg-6 .icon-box {
            margin: 0 auto !important;
            text-align: center !important;
        }

        .pull-left.flip {
            float: none !important;
            display: block !important;
            margin: 0 auto 15px !important;
        }
    }

    /* FAQ Accordion Styles */
    .faq-section {
        padding: 60px 0;
    }

    .accordion-item {
        background-color: #ffffff;
        border: 1px solid #e0e0e0 !important;
        border-radius: 4px;
        transition: all 0.3s ease;
        margin-bottom: 15px;
    }

    .accordion-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .accordion-button {
        background-color: #ffffff;
        color: #333333;
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
        background-color: #f0f7ff;
        color: #000000;
        box-shadow: none;
        border-bottom: 2px solid #000000;
    }

    .accordion-button:hover {
        background-color: #f5f5f5;
        color: #000000;
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23e07f00'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
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

    .border-1px {
        border: 1px solid #c9c7c7 !important;
    }

    @media (max-width: 767px) {
        .faq-section {
            padding: 30px 0;
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
    }
    
    /* Additional LCP optimizations */
    * {
        box-sizing: border-box;
    }
    
    /* Ensure hero content doesn't cause layout shift */
    .home-content h1 {
        font-size: 2.8rem;
        line-height: 1.2;
        font-weight: 700;
    }
    
    .home-content h3 {
        font-size: 1rem;
        line-height: 1.5;
    }
    
    /* Optimize font loading */
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        font-display: swap;
    }

    .text-dark {
        color: #444444 !important;
    }
   </style>
@endpush


@section('content')
<!-- Section: home -->
<section id="home" class="divider parallax"
    style="background-image: url('{{ asset($page_data->page_image) }}');">
    <div class="display-table">
        <div class="display-table-cell">
            <div class="container pt-100 pb-100">
                <div class="row">
                    <div class="col-md-12">
                        <div class="home-content">
                            {{-- Uncomment if you want to show the logo --}}
                            {{-- <div>
                                <img src="{{ asset($app_setting->app_sticky_logo) }}" alt="Logo">
                            </div> --}}
                            <h1 class="text-white text-uppercase font-54">
                                {{ $page_data->page_image_title }}
                            </h1>
                            <h3 class="text-white font-weight-400" style="margin-top: 20px;">
                                {{ Str::limit($page_data->page_image_description, 120) }}
                            </h3>
                            {{-- <a class="btn btn-colored btn-theme-colored btn-flat smooth-scroll-to-target mt-15" href="#donate-now">Donate Now</a> --}}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: About -->
{{-- <section>
    <div class="container" style="padding-top: 30px !important;padding-bottom: 30px!important;">
        <div class="row">
            <div class="col-sm-8" style="text-align: justify;">
                {!! $page_data->page_content !!}
            </div>
        </div>
    </div>
</section> --}}


<section class="">
  <div class="container" style="padding-top: 30px !important; padding-bottom: 30px !important;">
    <div class="section-title text-center">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <h3 style="text-align: center;">
            <span style="color: inherit; font-size: 36px; font-family: Philosopher, sans-serif !important;">
              LIFE IN DIVINE YOGA
            </span><br>
        </h3>
          <p class="text-theme-colored2" style="text-align: center; font-size: 30px; font-weight: bold;">
            || योग: कर्मसु कौशलम् ||
          </p>
        </div> 
      </div>

      <div class="row">
        <p style="font-size: 14px; color:#444444">
          A journey of self-discovery, inner peace, and spiritual awakening. Embrace balance, harmony,
          and enlightenment through mindful practice and connection with the divine.
        </p>
      </div>

      <div class="row mt-30">
        <div class="col-sm-4 text-center">
          <div class="">
            <img loading="lazy" src="{{ asset('assets/front/images/6503db8d98529icon-1.png') }}" alt="Alternative Medicines" width="100" height="100" decoding="async">
          </div>
          <h5 style="font-size: 16px">Alternative Medicines</h5>
        </div>

        <div class="col-sm-4 text-center">
          <div class="">
            <img loading="lazy" src="{{ asset('assets/front/images/6503dbc7b2fc5icon-2.png') }}" alt="For Good Health" width="100" height="100" decoding="async">
          </div>
          <h5 style="font-size: 16px">For Good Health</h5>
        </div>

        <div class="col-sm-4 text-center">
          <div class="">
            <img loading="lazy" src="{{ asset('assets/front/images/6503dbe5edf47icon-3.png') }}" alt="Healthy Mind &amp; Body" width="100" height="100" decoding="async">
          </div>
          <h5 style="font-size: 16px">Healthy Mind &amp; Body</h5>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="">
  <div class="container" style="padding-top: 30px !important; padding-bottom: 30px !important;">
    <div class="section-title text-center">
      <div class="row">
        <div class="col-12">
          <img style="width: auto; height: auto;" loading="lazy" src="{{ asset('uploads/download.webp') }}" alt="For Good Health" width="800" height="400" decoding="async">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="">
  <div class="container" style="padding-top: 30px !important; padding-bottom: 30px !important;">
    <div class="section-title text-center">
      
      <div class="row">
        <div class="col-md-12 offset-md-2">
          <h2 style="text-align: center; font-size: 36px; ">
            <span style="color: inherit; font-size: 36px; font-family: Philosopher, sans-serif !important;">
              THE MAIN REASONS TO PRACTICE YOGA
            </span><br>
          </h2>
          <p class="text-theme-colored2 sub-text-custom">|| योगश्चित्तवृत्तिनिरोधः ||</p>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <p class="color-444">
            ELEVATE MIND, BODY, AND SPIRIT THROUGH ANCIENT PRACTICES AND MODERN WISDOM.
            EMBRACE BALANCE AND BLISS ON YOUR JOURNEY WITHIN.
          </p>
        </div>
      </div>

      <div class="row">
        @foreach ($section_1_content as $content_1)
            <div class="col-lg-6 col-md-12 col-sm-12 w-48-desktop">
                <div class="icon-box icon-theme-colored left media p-0 mb-sm-10 mt-30">
                    <a href="{{ route('yoga.center') }}" class="icon icon-circled icon-md pull-left flip">
                        <img loading="lazy" src="{{ asset($content_1->of_image) }}" width="75" height="75" alt="{{ $content_1->of_heading }}" decoding="async">
                    </a>
                    <div class="media-body">
                        <h3 class="media-heading heading"><b>{{ $content_1->of_heading }}</b></h3>
                        <p class="color-444">{{ $content_1->of_description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
  </div>
</section>

@php
    $yogaServices = [
        [
            'title' => 'Home Visit Yoga',
            'image' => 'uploads/home_visit_yoga.webp',
            'link' => 'service/home-visit-yoga',
        ],
        [
            'title' => 'Private Online Yoga',
            'image' => 'uploads/private_online_yoga.webp',
            'link' => 'service/private-online-yoga',
        ],
        [
            'title' => 'Group Online Yoga',
            'image' => 'uploads/group_online_yoga.webp',
            'link' => 'service/group-online-yoga',
        ],
        [
            'title' => 'Corporate Yoga',
            'image' => 'uploads/65057356cad36images-150x150.webp',
            'link' => 'service/corporate-yoga',
        ],
        [
            'title' => 'Yoga Center',
            'image' => 'uploads/yog_center.webp',
            'link' => 'yoga-center',
        ],
        [
            'title' => 'TTC',
            'image' => 'uploads/ttc.webp',
            'link' => 'teacher-training-course',
        ],
        [
            'title' => 'Retreat',
            'image' => 'assets/icon-thumb4-150x150.jpg',
            'link' => 'retreat',
        ],
        [
            'title' => 'Workshop',
            'image' => 'uploads/workshop.webp',
            'link' => 'workshop',
        ],
    ];
@endphp

<section class="types-of-yoga-section py-4">
    <div class="container">
        <div class="section-title text-center">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="h3" style="color: #000; font-size: 36px; font-weight: bold; font-family: Philosopher, sans-serif !important;">
                        A BRIEF DESCRIPTION OF THE TYPES OF YOGA SERVICES
                    </h2>
                    <p class="text-theme-colored2 sub-text-custom">|| तत्र स्थितौ यत्नोऽभ्यासः ||</p>
                </div>
            </div>
            <div class="row">
                <p class="color-444 text-center" style="font-size: 14px;">
                    Discover inner peace and vitality with our comprehensive yoga services. From beginner-friendly classes to advanced practices, we offer holistic guidance to enhance your mind, body, and spirit. Start your journey today.
                </p>
            </div>
        </div>

        <div class="section-content text-center">
            <div class="row">
                @foreach ($yogaServices as $service)
                    <div class="col-xs-12 col-sm-6 col-md-3 mb-4 wow fadeInLeft mt-20" data-wow-duration="1s" data-wow-delay="0.3s">
                        <img loading="lazy" width="160" height="160" class="img-circle img-thumbnail mb-2" src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}" decoding="async">
                        <h2 class="mb-5 fs-16">{{ $service['title'] }}</h2>
                        <a href="{{ url($service['link']) }}" class="btn btn-success">Visit Now</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="divider" id="about" style="background-image: url('{{ asset('assets/bg-graphic-free-img-1.webp') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container py-4">
        <div class="section-title">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <img loading="lazy" src="{{ asset('assets/Square-Logo-with-Name-2-povy7zr4loqk9maa9hbtvdrc77dpfngjngf3wrmp40.webp') }}" alt="YogIntra" class="img-fluid" width="250" height="200">
                </div>
                <div class="col-md-8 text-start text-md-start">
                    <h4 style="font-size: 30px;" class="mt-4">About YogIntra:</h4>
                    <p class="text-size color-444">
                        Back In 2011, Started with a thought to make common people experience Yoga in their busy schedule, YogIntra is now nationally and internationally building community to help people stay healthy with a numerous Yoga Experts for all age group and gender. YogIntra comes from two words Yog and Intra, where yog comes from Sanskrit word “Yuj” Which Means connection between “Soul” (Aatma) and “God”(Parmatma) And Intra is an English Word Which Means Within. YogIntra is the connection between the soul and God within oneself.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container section-padding" style="padding-top: 30px !important; padding-bottom: 30px !important;">
        <div class="row">
            <div class="image-column col-lg-6 col-md-12 col-sm-12">
                <div class="inner-column wow fadeInLeft">
                    <div class="author-desc">
                        <h4>Amit Pandey</h4>
                        <span>CEO & Founder of Yogintra</span>
                    </div>
                    <figure class="image-1">
                        <img loading="lazy" title="Amit Pandey" src="{{ asset('assets/image0-1-e1652675710448-povumdsa83b7dajv3gfs2377ei7o24wz5y0tn7sz34.webp') }}" alt="CEO & Founder of Yogintra Amit Pandey" class="lightbox-image" data-fancybox="images">
                    </figure>
                </div>
            </div>

            <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2 padding-top-media">
                <div class="inner-column">
                    <div class="sec-title">
                        <h4 style="font-size: 40px; margin-bottom: 15px;">About Founder:</h4>
                    </div>
                    <div class="text color-444">
                        Mr. Amit Pandey started his journey of yoga back in 2005 as student in Yogic science and then he understood Yoga is the only way he would be able to help people bring smiles back on their faces in this struggling and fast life. He served few years Internationally as a Yoga trainer but coming back to India during his visit a few years back, a thought him hard “Charity begins at home.” And then he never went back thinking about people here need know about Yoga and Yoga Benefits.
                    </div>
                    <div class="btn-box">
                        <a href="{{ url('contact') }}" class="theme-btn btn-style-one">Contact Us</a>
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
                        <h4 style="font-size: 30px;" class="mt-0 line-height-1">Meet Our <span class="text-theme-colored2">Instructors</span></h4 style="font-size: 30px;">
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
                                        <img class="img-fullwidth" width="200" height="200" loading="lazy" alt="yogintra trainers" src="{{ $api . '/' . $trainer->profile_image }}" decoding="async">
                                    </div>
                                    @php
                                        $currentYear = now()->year;
                                        $birthYear = \Carbon\Carbon::parse($trainer->dob)->year;
                                        $age = $currentYear - $birthYear;
                                    @endphp
                                    <div class="team-details">
                                        <div class="p-10">
                                            <h4 class="text-uppercase mt-0 mb-0 text-dark">{{ $trainer->name }}</h4>
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

<section>
    <div class="container pt-1" style="padding-top: 30px !important; padding-bottom: 30px !important;">
        <div class="row">
            <div class="col-md-12 offset-md-2">
                <p style="text-align: center;">
                    <span style="color: #000; font-size: 36px; font-family: Philosopher, sans-serif !important;">Gallery</span>
                </p>
            </div>
        </div>
        <div class="row">
            <p class="mb-20 color-444" style="font-size: 14px; text-align: center;">Discover tranquility through our yoga gallery: poses and serenity captured in stillness.</p>
        </div>
        <div class="row mt-3">
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-xs-12 col-sm-6 col-md-4 sm-text-center mb-30 mb-sm-30">
                    <div class="team-members text-center maxwidth400" onclick="open_modal({{ $i }})">
                        <div class="team-thumb">
                            <img loading="lazy" class="img-fullwidth" id="imageresource_{{ $i }}" style="height: 200px; width: auto" alt="yogintra" width="300" height="200" decoding="async" src="{{ asset('uploads/yoga-pose' . $i . '.jpeg') }}">
                        </div>
                    </div>
                </div>
            @endfor
            <div class="text-center">
                <a href="{{ url('gallery') }}" class="btn btn-success mt-15">View More Gallery <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>

<section class="review-section bg-lighter">
    <div class="container pt-70 pb-70">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3 style="font-size: 30px;" class="mt-0 line-height-1">What Our <span class="text-theme-colored2">Clients Say</span></h3>
                    <p class="text-gray">Real testimonials from our dedicated yoga practitioners and students</p>
                </div>
            </div>
        </div>

        <div class="row mtli-row-clearfix">
            <div class="col-md-12">
                <div class="owl-carousel-3col" data-nav="true" data-dots="true">
                    @forelse($testimonials as $testimonial)
                        <div class="item">
                            <div class="testimonial-card bg-white p-30 rounded" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); min-height: 350px; display: flex; flex-direction: column;">
                                <!-- Star Rating -->
                                <div class="mb-20">
                                    @for($i = 0; $i < $testimonial->test_review; $i++)
                                        <span style="color: #FFD700; font-size: 18px;">★</span>
                                    @endfor
                                    <small class="text-gray ml-10">({{ $testimonial->test_review }}/5)</small>
                                </div>

                                <!-- Review Text -->
                                <div class="flex-grow-1">
                                    <p class="text-black" style="line-height: 1.6; margin-bottom: 20px;">
                                        <em>"{{ $testimonial->test_description }}"</em>
                                    </p>
                                </div>

                                <!-- Reviewer Info -->
                                <div class="testimonial-author mt-auto pt-20" style="border-top: 1px solid #e0e0e0;">
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->test_image)
                                            <img src="{{ asset($testimonial->test_image) }}" 
                                                 width="50" height="50" 
                                                 alt="{{ $testimonial->test_name }}" 
                                                 style="border-radius: 50%; object-fit: cover; margin-right: 15px;">
                                        @else
                                            <div style="width: 50px; height: 50px; background-color: #e07f00; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 15px;">
                                                {{ strtoupper(substr($testimonial->test_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="mb-0 text-dark">{{ $testimonial->test_name }}</h4>
                                            @if($testimonial->test_position)
                                                <small class="text-dark">{{ $testimonial->test_position }}</small>
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

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h5 class="mt-0" style="font-size: 30px;">Frequently Asked <span class="text-theme-colored2">Questions</span></h5>
                    <p class="text-theme-colored2">Your questions answered about our yoga services</p>
                </div>
            </div>
        </div>

        <div class="row mt-50">
            <div class="col-md-8 col-md-offset-2">
                <div class="accordion" id="faqAccordion">
                    <!-- FAQ Item 1 -->
                    <div class="accordion-item mb-15 border-1px">
                        <h5 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <strong>What is YogIntra and what services do you offer?</strong>
                            </button>
                        </h5>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>YogIntra is India's premier yoga platform offering comprehensive services including:</p>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Home visit yoga training</li>
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Online yoga classes (private & group)</li>
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Corporate yoga programs</li>
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Teacher training courses (TTC)</li>
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Yoga retreats and workshops</li>
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Yoga center facilities</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item mb-15 border-1px">
                        <h5 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <strong>Are your yoga classes suitable for beginners?</strong>
                            </button>
                        </h5>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Absolutely! YogIntra welcomes all levels, including complete beginners. Our experienced trainers:</p>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Customize classes for your flexibility level</li>
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Provide modifications for different fitness levels</li>
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Start with foundational poses and breathing techniques</li>
                                    <li><i class="fa fa-check text-theme-colored2 mr-10"></i>Progress gradually at your pace</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="accordion-item mb-15 border-1px">
                        <h5 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <strong>How do I book a session or class with YogIntra?</strong>
                            </button>
                        </h5>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Booking is simple and straightforward:</p>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-phone text-theme-colored2 mr-10"></i>Call us directly at +91-9867291573</li>
                                    <li><i class="fa fa-envelope text-theme-colored2 mr-10"></i>Fill out our contact form on the website</li>
                                    <li><i class="fa fa-calendar text-theme-colored2 mr-10"></i>Visit one of our yoga centers</li>
                                    <li><i class="fa fa-globe text-theme-colored2 mr-10"></i>Register online for online classes</li>
                                </ul>
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
                                    <li><i class="fa fa-phone text-theme-colored2 mr-10"></i>Phone: +91-9867291573</li>
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
<!-- Bootstrap 5 Popper and JS for Accordion - Deferred loading -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" defer></script>

<!-- Landing page specific scripts - deferred to after FCP -->
<script type="text/javascript" defer>
// Optimize initial hero section rendering
window.addEventListener('load', function() {
    // Initialize forms and interactions after page load
    initLandingPageForms();
    lazyLoadGoogleReviews();
}, { once: true });

// Lazy-load Google Reviews widget only when visible
function lazyLoadGoogleReviews() {
    const reviewSection = document.querySelector('.review-section');
    if (reviewSection && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const script = document.createElement('script');
                    script.src = 'https://widgets.sociablekit.com/google-reviews-old/widget.js';
                    script.async = true;
                    document.body.appendChild(script);
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '50px' });
        observer.observe(reviewSection);
    } else if (reviewSection) {
        // Fallback: load on window load
        window.addEventListener('load', function() {
            setTimeout(function() {
                const script = document.createElement('script');
                script.src = 'https://widgets.sociablekit.com/google-reviews-old/widget.js';
                document.body.appendChild(script);
            }, 1000);
        });
    }
}

// Defer non-critical landing page form logic to after page interactive
function initLandingPageForms() {
    var loc = new locationInfo();
    var currentStep = 1;

    $("#multi-step-form").submit(function(e) {
        e.preventDefault(); 
        var form = $(this);
        $.ajax({
            type: "POST",
            url: "{{ url('home/submit_contact_form') }}",
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if(data == 1) {
                    window.location = "{{ url('thank_you') }}";
                } else {
                    alert('Data Submission Failed');
                }
            }
        });
    });

    $(".next").click(function () {
        if (validateStep(currentStep)) {
            $("#step-" + currentStep).removeClass("active");
            currentStep++;
            $("#step-" + currentStep).addClass("active");

            if(currentStep == 2){
                loc.getCountries();
                loc.getStates();
            }
        }
    });

    $(".prev").click(function () {
        $("#step-" + currentStep).removeClass("active");
        currentStep--;
        $("#step-" + currentStep).addClass("active");
    });

    $(".countries").on("change", function() {
        var countryId = $("option:selected", this).attr('countryid');
        if(countryId != ''){
            loc.getStates(countryId);
        } else {
            $(".states option:gt(0)").remove();
        }
    });

    $(".states").on("change", function() {
        var stateId = $("option:selected", this).attr('stateid');
        if(stateId != ''){
            loc.getCities(stateId);
        } else {
            $(".cities option:gt(0)").remove();
        }
    });

    function validateStep(step) {
        var isValid = true;
        $(".form-group").removeClass("has-error");
        $(".error-message").remove();

        function addError(selector, message) {
            isValid = false;
            $(selector).closest(".form-group").addClass("has-error");
            $(selector).after('<div class="error-message">' + message + '</div>');
        }

        if (step === 1) {
            if (!$('#name').val()) addError('#name', 'Please enter your name.');
            if (!$('#phone').val()) addError('#phone', 'Please enter your phone number.');
            if (!$('#email').val()) addError('#email', 'Please enter your email address.');
        }
        else if (step === 2) {
            if (!$('#country').val()) addError('#country', 'Please select your country.');
            if (!$('#state').val()) addError('#state', 'Please select your state.');
            if (!$('#city').val()) addError('#city', 'Please select your city.');
        }
        else if (step === 3) {
            if (!$('#message').val()) addError('#message', 'Please enter a message.');
        }

        return isValid;
    }

    function ajaxCall() {
        this.send = function(data, url, method, success, type = 'json') {
            $.ajax({
                url: url,
                type: method,
                data: data,
                success: success,
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                },
                dataType: type,
                timeout: 60000
            });
        }
    }

    function locationInfo() {
        var rootUrl = "https://geodata.phplift.net/api/index.php";
        var call = new ajaxCall();

        this.getCities = function(id) {
            $(".cities option:gt(0)").remove();
            var url = rootUrl+'?type=getCities&countryId=&stateId=' + id;
            call.send({}, url, 'post', function(data) {
                $(".cities").find("option:eq(0)").html("Select City");
                if (Object.keys(data['result']).length > 0) {
                    $.each(data['result'], function(key, val) {
                        var option = `<option value='${val.name}'>${val.name}</option>`;
                        $('.cities').append(option);
                    });
                }
                $(".cities").prop("disabled",false);
            });
        };

        this.getStates = function(id = 101) {
            $(".states option:gt(0)").remove();
            $(".cities option:gt(0)").remove();
            var url = rootUrl+'?type=getStates&countryId=' + id;
            call.send({}, url, 'post', function(data) {
                $('.states').find("option:eq(0)").html("Select State");
                $.each(data['result'], function(key, val) {
                    var option = `<option value='${val.name}' stateid='${val.id}'>${val.name}</option>`;
                    $('.states').append(option);
                });
                $(".states").prop("disabled",false);
            });
        };

        this.getCountries = function() {
            var url = rootUrl+'?type=getCountries';
            var defaultCountryName = 'India';
            call.send({}, url, 'post', function(data) {
                $('.countries').find("option:eq(0)").html("Select Country");
                $.each(data['result'], function(key, val) {
                    var selected = val.name === defaultCountryName ? 'selected' : '';
                    var option = `<option value='${val.name}' countryid='${val.id}' ${selected}>${val.name}</option>`;
                    $('.countries').append(option);
                });
            });
        };
    }
}


// Initialize form logic after page is interactive (not blocking FCP)
// Already handled by window load event above

</script>

@endpush