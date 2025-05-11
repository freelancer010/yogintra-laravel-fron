@extends('layouts.layout')
@section('meta_title', 'About us | YogIntra - Best Yoga Center in India')
@section('meta_description', 'YogIntra is the Best Yoga Center in India for a transformative journey. Immerse yourself in the ancient practice of yoga with experienced instructors./')
@section('meta_keywords', 'Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai, Yoga Teacher Training Courses.')

@push('styles')
  <style>
      .article {
         width: 100%;
         margin-top: 8vh;
         display: flex;
         justify-content: center;
      }

      /* GENERAL SETTINGS */
      h3.yog-ttl {
         text-align: center;
         font-size: 2rem;
         margin-bottom: 1vh;
      }

      h3.yog-ttl.wht {
         color: #fff;
      }

      p.yog-cont {
         font-size: 1.5rem;
         padding: 0 2rem;
      }

      /* BOX SETTINGS */
      .box1 {
         background-color: var(--purple);
         border: 3px solid var(--dark);
         color: var(--dark);
         margin-right: 8vh;
         border-radius: 15px;
         padding-top: 70px;
         padding-bottom: 70px;
         width:50%;
      }

      .box2 {
         background-color: #fff;
         border: 3px solid var(--light);
         color: var(--light);
         margin-left: 1vh;
         position: relative;
         border-radius: 15px;
         padding-top: 70px;
         padding-bottom: 70px;
         width:100%;
      }

      /* BOX-TEXT SETTINGS */
      .text-box1 {
         padding: 2vh;
         text-align: center;
      }

      .text-box2 {
         padding: 2vh;
         text-align: center;
      }

      /* TITLE SETTINGS */
      .title1 {
         grid-row: 1/2;
         grid-column: 1/3;
         align-self: end;
         justify-self: end;
         color: var(--light);
      }

      .title2 {
         grid-row: 5/6;
         grid-column: 5/7;
         align-self: top;
         justify-self: end;
         color: var(--light);
      }
      @media screen and (min-width: 1000px) and (max-width: 1200px) {
         .cst-font{
            font-size:28px;
         }
         .about-section .content-column {
            margin-top: 115px !important;
         }
         .about-section .image-column .inner-column .author-desc{
            width:38% !important;
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

      .about-section .image-column .inner-column .author-desc h2 {
         font-size: 21px;
         letter-spacing: 1px;
         text-align: center;
         color: #fff;
         margin: 0;
      }

      .about-section .image-column .inner-column .author-desc span {
         font-size: 16px;
         /*letter-spacing: 6px;*/
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
         .article
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
   </style>
@endpush
@section('content')

<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg8.jpg') }}'); background-position: 50% 55px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="title text-white">About</h2>
                    <ol class="breadcrumb text-center mt-10">
                        <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li class="active text-gray">About Us</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: About Founder -->
<section class="about-section">
    <div class="container section-padding">
        <div class="row">
            <div class="image-column col-lg-6 col-md-12 col-sm-12">
                <div class="inner-column wow fadeInLeft">
                    <div class="author-desc">
                        <h2>Amit Pandey</h2>
                        <span>CEO & Founder of Yogintra</span>
                    </div>
                    <figure class="image-1">
                        <a href="#" class="lightbox-image" data-fancybox="images">
                            <img title="Amit Pandey" src="{{ asset('assets/image0-1-e1652675710448-povumdsa83b7dajv3gfs2377ei7o24wz5y0tn7sz34.jpeg') }}" alt="Amit Pandey">
                        </a>
                    </figure>
                </div>
            </div>
            <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2 padding-top-media">
                <div class="inner-column">
                    <div class="sec-title">
                        <h2>About Founder:</h2>
                    </div>
                    <div class="text">
                        Mr. Amit Pandey started his journey of yoga back in 2005 as student in Yogic science and then he understood Yoga is the only way he would be able to help people bring smiles back on their faces in this struggling and fast life...
                    </div>
                    <div class="btn-box">
                        <a href="{{ url('/contact') }}" class="theme-btn btn-style-one">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: About YogIntra -->
<section class="divider" data-bg-img="{{ asset('assets/bg-graphic-free-img-1.jpg') }}">
    <div class="container pt-45 pb-20 section-padding-2">
        <div class="section-title">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('assets/Square-Logo-with-Name-2-povy7zr4loqk9maa9hbtvdrc77dpfngjngf3wrmp40.png') }}" />
                </div>
                <div class="col-md-8 text-xs-center">
                    <h2 class="mt-40 text-xs-center">About YogIntra:</h2>
                    <p class="text-size">Back In 2011, Started with a thought to make common people experience Yoga in their busy schedule...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Why YogIntra -->
<section class="divider parallax layer-overlay overlay-theme-colored2-9"
    data-bg-img="{{ asset('assets/about-women.png') }}">
    <div class="container pt-125 pb-125">
        <div class="section-title">
            <div class="row">
                <div class="col-md-5">
                    <h2 class="mt-0 text-white">Why YogIntra?</h2>
                    <p class="text-white">We at YogIntra look at our customers as our assets, hence we believe in serving them with utmost comfort and care...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Vision and Mission -->
<section style="background-color: #fff4e0;">
    <div class="container">
        <div class="section-content">
            <div class="row">
                <div class="article">
                    <div class="box1" data-bg-img="{{ asset('assets/greenfloralbg-image1.jpg') }}">
                        <div class="text-box1">
                            <h3 class="yog-ttl wht">OUR VISION</h3>
                            <p class="yog-cont">HISTORY</p>
                            <p class="yog-cont">FACILITIES</p>
                            <p class="yog-cont">INNER PEACE</p>
                            <p class="yog-cont">TREATMENTS</p>
                            <p class="yog-cont">PEACE MIND</p>
                        </div>
                    </div>
                    <div class="box2">
                        <div class="text-box2">
                            <h3 class="yog-ttl">Our Vision And Mission:</h3>
                            <p class="yog-cont">Making the best version of a human form in Yoga</p>
                            <p class="yog-cont"><br>
                                With a vision of YogIntra building a community helping people stay healthy...
                            </p>
                        </div>
                    </div>
                    <div class="title1"></div>
                    <div class="title2"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')   
   <!-- end main-content -->
   <script type="text/javascript">
      $('[data-bg-img]').each(function() {
         $(this).css('background-image', 'url(' + $(this).data("bg-img") + ')');
      });
   </script>
@endpush