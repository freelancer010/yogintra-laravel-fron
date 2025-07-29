@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Blogs - YogIntra')
@section('meta_description', 'This blog is about my yoga journey. It started decades ago and has no end.')
@section('meta_keywords', 'Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai.')

@push('styles')
    <style>
        .blog-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .blog-card.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .blog-card article.post {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .blog-card:hover article.post {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        /* Default state for missing images */
        .post-thumb {
            position: relative;
            background: #f8f8f8;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .post-thumb:empty::before {
            content: 'BLOG';
            font-size: 24px;
            font-weight: bold;
            color: #ddd;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Stagger delay for cards */
        .blog-card:nth-child(1) { transition-delay: 0.1s; }
        .blog-card:nth-child(2) { transition-delay: 0.2s; }
        .blog-card:nth-child(3) { transition-delay: 0.3s; }
        .blog-card:nth-child(4) { transition-delay: 0.4s; }
        .blog-card:nth-child(5) { transition-delay: 0.5s; }
        .blog-card:nth-child(6) { transition-delay: 0.6s; }

        /* Smooth transition for all hover effects */
        article.post {
            transition: all 0.3s ease;
            background: white;
        }

        article.post:hover .post-thumb img {
            transform: scale(1.05);
        }

        .post-thumb {
            overflow: hidden;
        }

        .post-thumb img {
            transition: transform 0.5s ease;
        }

        .btn-read-more {
            position: relative;
            overflow: hidden;
        }

        .btn-read-more:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: currentColor;
            transition: width 0.3s ease;
        }

        .btn-read-more:hover:after {
            width: 100%;
        }
    </style>
@endpush

@section('content')

<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="title text-white">Blog</h1>
                    <ol class="breadcrumb text-center mt-10">
                        <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
                        <li class="active text-gray">All Blog</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Blog Grid -->
<section>
    <div class="container">
        <div class="row multi-row-clearfix">
            <div class="blog-posts">
                @foreach ($get_all_blog as $all_blog)
                    <div class="col-md-4 blog-card">
                        <article class="post clearfix mb-30 bg-lighter">
                            <a href="{{ url('/blog/' . $all_blog->blog_slug) }}">
                                <div class="entry-header">
                                    <div class="post-thumb thumb">
                                        @if($all_blog->blog_image)
                                            <img style="height:150px;object-fit: cover;object-position: top center;" class="img-responsive img-fullwidth"
                                                src="{{ asset($all_blog->blog_image) }}"
                                                alt="{{ $all_blog->blog_title }}"
                                                onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'default-blog-text\' style=\'height:150px;display:flex;align-items:center;justify-content:center;background:#f8f8f8;padding:15px;text-align:center;\'><span style=\'font-size:18px;font-weight:500;color:#666;line-height:1.4;\'>' + this.alt + '</span></div>'">
                                        @else
                                            <div class="default-blog-text" style="height:150px;display:flex;align-items:center;justify-content:center;background:#f8f8f8;padding:15px;text-align:center;">
                                                <span style="font-size:18px;font-weight:500;color:#666;line-height:1.4;">{{ $all_blog->blog_title }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            <div class="entry-content border-1px p-20 pr-10">
                                <div class="entry-meta media mt-0 no-bg no-border">
                                    <div class="entry-date media-left text-center flip pt-5 pr-15 pb-5 pl-15">
                                        <ul>
                                            <li class="font-16 font-weight-600 text-primary">{{ \Carbon\Carbon::parse($all_blog->created_at)->format('d') }}</li>
                                            <li class="font-12 text-uppercase text-primary">{{ \Carbon\Carbon::parse($all_blog->created_at)->format('M') }}</li>
                                        </ul>
                                    </div>
                                    <div class="media-body pl-15">
                                        <div class="event-content pull-left flip">
                                            <h4 class="entry-title text-white text-uppercase m-0 mt-5">
                                                <a class="elipse-text" href="{{ url('/blog/' . $all_blog->blog_slug) }}">
                                                    {{ \Illuminate\Support\Str::limit($all_blog->blog_title, 50, '...') }}
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-10 elipse-text">{{ $all_blog->blog_short_description }}</p>
                                <a href="{{ url('/blog/' . $all_blog->blog_slug) }}" class="btn-read-more">Read more</a>
                                <div class="clearfix"></div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>
        // Animate blog cards when they come into view
        document.addEventListener('DOMContentLoaded', function() {
            var cards = document.querySelectorAll('.blog-card');
            
            function checkCards() {
                cards.forEach(function(card) {
                    var cardPosition = card.getBoundingClientRect().top;
                    var screenPosition = window.innerHeight - 50;
                    
                    if(cardPosition < screenPosition) {
                        card.classList.add('animate');
                    }
                });
            }

            // Check cards on load
            checkCards();

            // Check cards on scroll
            window.addEventListener('scroll', checkCards);
        });
    </script>
@endpush
