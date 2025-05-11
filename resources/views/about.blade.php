@extends('layouts.layout')
@push('styles')

@endpush
@section('content')

<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('css/images/bg/bg8.jpg') }}'); background-position: 50% 55px; height: 300px;">
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
@endpush