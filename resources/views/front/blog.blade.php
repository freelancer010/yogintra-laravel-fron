@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Blogs - YogIntra')
@section('meta_description', 'This blog is about my yoga journey. It started decades ago and has no end.')
@section('meta_keywords', 'Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai.')

@push('styles')
@endpush

@section('content')

<section class="inner-header divider parallax layer-overlay overlay-dark-7"
    style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
    <div class="container pt-60 pb-60">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="title text-white">Blog</h2>
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
                    <div class="col-md-4">
                        <article class="post clearfix mb-30 bg-lighter">
                            <div class="entry-header">
                                <div class="post-thumb thumb">
                                    <a href="{{ url('/blog/' . $all_blog->blog_slug) }}">
                                        <img style="height:150px" class="img-responsive img-fullwidth"
                                            src="{{ asset($all_blog->blog_image) }}"
                                            alt="{{ $all_blog->blog_title }}">
                                    </a>
                                </div>
                            </div>
                            <div class="entry-content border-1px p-20 pr-10">
                                <div class="entry-meta media mt-0 no-bg no-border">
                                    <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
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

@endpush
