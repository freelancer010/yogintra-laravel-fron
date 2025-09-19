@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Gallery | YogIntra')
@section('meta_description', 'We are constantly raising awareness of detoxifying the mind and body from within. We guide you to improve your inner beauty and personality through yoga.')
@section('meta_keywords', 'Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai, Yoga Teacher Training Courses.')

@push('styles')
<style>
    .styled-icons .fa {
        line-height: 2.5;
    }

    /* Gallery item animations similar to blog cards */
    .gallery-item {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
        overflow: hidden;
    }

    .gallery-item.animate {
        opacity: 1;
        transform: translateY(0);
    }

    /* Stagger delay for gallery items */
    .gallery-item:nth-child(1) { transition-delay: 0.1s; }
    .gallery-item:nth-child(2) { transition-delay: 0.2s; }
    .gallery-item:nth-child(3) { transition-delay: 0.3s; }
    .gallery-item:nth-child(4) { transition-delay: 0.4s; }
    .gallery-item:nth-child(5) { transition-delay: 0.5s; }
    .gallery-item:nth-child(6) { transition-delay: 0.6s; }
    .gallery-item:nth-child(7) { transition-delay: 0.7s; }
    .gallery-item:nth-child(8) { transition-delay: 0.8s; }
    .gallery-item:nth-child(9) { transition-delay: 0.1s; }
    .gallery-item:nth-child(10) { transition-delay: 0.2s; }
    .gallery-item:nth-child(11) { transition-delay: 0.3s; }
    .gallery-item:nth-child(12) { transition-delay: 0.4s; }

    /* Fast image loading */
    .gallery-item img {
        display: block;
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(1.03) translateY(-5px);
    }

    .gallery-item.animate:hover {
        transform: scale(1.03) translateY(-5px);
    }

    .gallery-item .thumb {
        position: relative;
        overflow: hidden;
    }

    .gallery-item .thumb img {
        transition: transform 0.3s ease-in-out;
    }

    .gallery-item:hover .thumb img {
        transform: scale(1.1);
    }

    .gallery-item .overlay-shade {
        transition: opacity 0.3s ease-in-out;
    }

    .gallery-item .icons-holder {
        transition: all 0.3s ease-in-out;
    }

    .gallery-item:hover .overlay-shade {
        opacity: 0.8;
    }

    .gallery-item:hover .icons-holder {
        opacity: 1;
    /* Ensure grid layout works immediately */
    .gallery-isotope {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    @media (min-width: 768px) {
        .gallery-isotope.grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 767px) {
        .gallery-isotope {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
    }

    /* Override isotope styles when needed */
    .gallery-isotope.isotope-enabled {
        display: block;
    }
</style>
@endpush

@section('content')
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 55px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="title text-white">Gallery</h1>
                    <ol class="breadcrumb text-center text-black mt-10">
                        <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                        <li class="active text-gray">Gallery</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Grid -->
<section>
    <div class="container">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12">

                    <!-- Portfolio Filter -->
                    <div class="portfolio-filter text-center mb-30">
                        <a href="#" class="active" data-filter="*">All</a>
                        @foreach ($all_category as $category)
                            @php $filterClass = 'cat-' . Str::slug($category->g_cat_name, '-'); @endphp
                            <a href="#" data-filter=".{{ $filterClass }}">{{ $category->g_cat_name }}</a>
                        @endforeach
                    </div>

                    <!-- Portfolio Gallery Grid -->
                    <div id="grid" class="gallery-isotope default-animation-effect grid-4 gutter clearfix">
                        @foreach ($all_gallery as $gallery)
                            @php
                                $isImage = $gallery->gallery_is_video_or_image == 1;
                                $categoryClass = $gallery->g_cat_name
                                    ? 'cat-' . Str::slug($gallery->g_cat_name, '-')
                                    : 'cat-uncategorized';
                            @endphp

                            <div class="gallery-item {{ $categoryClass }}">
                                <div class="thumb">
                                    @if ($isImage)
                                        <img style="height: 200px;" 
                                             class="img-fullwidth" 
                                             src="{{ asset($gallery->gallery_image) }}" 
                                             alt="{{ $gallery->g_cat_name }}">
                                        <div class="overlay-shade"></div>
                                        <div class="icons-holder">
                                            <div class="icons-holder-inner">
                                                <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                                                    <a data-lightbox="image" href="{{ asset($gallery->gallery_image) }}"><i class="fa fa-plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="hover-link" data-lightbox="image" href="{{ asset($gallery->gallery_image) }}">View more</a>
                                        <h5 class="mt-10 text-center">{{ $gallery->g_cat_name }}</h5>
                                    @else
                                        @php
                                            $videoId = explode('?v=', $gallery->gallery_video)[1] ?? '';
                                            $videoThumbnail = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                                        @endphp
                                        <img style="height: 200px;" 
                                             class="img-fullwidth" 
                                             src="{{ $videoThumbnail }}" 
                                             alt="YouTube Video">
                                        <div class="overlay-shade"></div>
                                        <div class="icons-holder">
                                            <div class="icons-holder-inner">
                                                <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                                                    <a class="popup-youtube" href="{{ $gallery->gallery_video }}"><i class="fa fa-youtube-play"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="mt-10 text-center">{{ $gallery->g_cat_name }}</h5>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var $gallery = $(".gallery-isotope");
        var $filterLinks = $(".portfolio-filter a");
        
        // Initialize isotope
        function initIsotope() {
            if ($gallery.length > 0) {
                $gallery.isotope({
                    itemSelector: '.gallery-item',
                    layoutMode: $gallery.hasClass("masonry") ? "masonry" : "fitRows",
                    filter: "*",
                    transitionDuration: '0.3s'
                });
            }
        }
        
        // Initialize isotope
        initIsotope();
        
        // Animate gallery items when they come into view (same as blog page)
        var galleryItems = document.querySelectorAll('.gallery-item');
        
        function checkGalleryItems() {
            galleryItems.forEach(function(item) {
                var itemPosition = item.getBoundingClientRect().top;
                var screenPosition = window.innerHeight - 50;
                
                if(itemPosition < screenPosition) {
                    item.classList.add('animate');
                }
            });
        }

        // Check items on load
        checkGalleryItems();

        // Check items on scroll
        window.addEventListener('scroll', checkGalleryItems);
        
        // Filter functionality
        $filterLinks.on("click", function (e) {
            e.preventDefault();
            $filterLinks.removeClass("active");
            $(this).addClass("active");

            var filterValue = $(this).data("filter");
            $gallery.isotope({ filter: filterValue }, function() {
                // Re-animate filtered items
                setTimeout(function() {
                    checkGalleryItems();
                }, 100);
            });
        });
    });
</script>
@endpush
