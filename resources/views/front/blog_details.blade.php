@extends('layouts.layout')

@section('meta_title', $blog->blog_title)
@section('meta_description', $blog->blog_meta_description)
@section('meta_keywords', $blog->blog_meta_keywords)
@section('og_image', asset($blog->blog_image))

@push('styles')
<style>
  .post p a {
    color: blue !important;
  }
  .jssocials-share-link {
    color: #fff !important;
  }
</style>
@endpush

@section('content')
<div class="main-content">
  <section class="inner-header divider parallax layer-overlay overlay-dark-7" 
    style="background-image: linear-gradient(360deg, black, transparent),url('{{ asset($blog->blog_image) }}'); 
    background-position: 50% 55px;    
    height: 60vh;
    object-fit: cover;
    display: flex;
    justify-content: center;
    text-align: center;
    margin-bottom: -10%;"
  >
    <div class="container pt-60 pb-60">
      <div class="section-content">
        <div class="row">
          <div class="col-md-12 text-center d-flex align-items-center justify-content-center">
            <h1 class="title text-white">{{ \Illuminate\Support\Str::limit($blog->blog_title, 100, '...') }}</h1>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container mt-30 mb-30 pt-30 pb-30">
      <div class="row">
        <div class="col-12">
          <div class="blog-posts single-post">
            <article class="post clearfix mb-0">
              <div class="entry-header" style="border-radius: 12px; box-shadow: 0px 6px 10px #00000050;">
                <div class="post-thumb thumb">
                  <img src="{{ asset($blog->blog_image) }}" alt="{{ $blog->blog_title }}" class="img-responsive img-fullwidth">
                </div>
              </div>
              <div class="entry-content p-15">
                <div class="entry-meta media no-bg no-border mt-15 pb-20">
                  <div class="entry-date media-left text-center flip pt-5 pr-15 pb-5 pl-15">
                    <ul>
                      <li class="font-16 font-weight-600 text-primary">{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</li>
                      <li class="font-12 text-uppercase text-primary">{{ \Carbon\Carbon::parse($blog->created_at)->format('M') }}</li>
                    </ul>
                  </div>
                  <div class="media-body pl-15">
                    <div class="event-content pull-left flip">
                      <h3 class="entry-title text-dark text-uppercase pt-0 mt-0">{{ $blog->blog_title }}</h3>
                      @if($blog->blog_author)
                        <span class="mb-10 text-gray-darkgray mr-10 font-13">
                          <i class="fa fa-user mr-5"></i> Author : {{ $blog->blog_author }}
                        </span>
                      @endif
                    </div>
                  </div>
                </div>
                <p>{!! $blog->blog_content !!}</p>
              </div>
            </article>
            <div id="share"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection