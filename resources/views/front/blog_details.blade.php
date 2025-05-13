@extends('layouts.layout')

@section('meta')
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="{{ $blog->blog_meta_description }}" />
<meta property="og:title" content="{{ $blog->blog_title }}" />
<meta property="og:description" content="{{ $blog->blog_meta_description }}" />
<meta name="keywords" content="{{ $blog->blog_meta_keywords }}" />
<meta name="author" content="YogIntra" />
<title>{{ $blog->blog_title }}</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />
<style>
  .post p a {
    color: blue !important;
  }
  .jssocials-share-link {
    color: #fff !important;
  }
</style>
@endsection

@section('content')
<div class="main-content">
  <section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset($blog->blog_image) }}'); background-position: 50% 55px;height: 300px;">
    <div class="container pt-60 pb-60">
      <div class="section-content">
        <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="title text-white">{{ \Illuminate\Support\Str::limit($blog->blog_title, 100, '...') }}</h2>
            <ol class="breadcrumb text-center text-black mt-10">
              <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
              <li><a href="{{ url('blog_category/' . $blog->category_slug) }}" class="text-white">{{ $blog->category_name }}</a></li>
              <li class="active text-gray">{{ \Illuminate\Support\Str::limit($blog->blog_title, 100, '...') }}</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section>
    <div class="container mt-30 mb-30 pt-30 pb-30">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="blog-posts single-post">
            <article class="post clearfix mb-0">
              <div class="entry-header">
                <div class="post-thumb thumb">
                  <img src="{{ asset($blog->blog_image) }}" alt="{{ $blog->blog_title }}" class="img-responsive img-fullwidth">
                </div>
              </div>
              <div class="entry-content">
                <div class="entry-meta media no-bg no-border mt-15 pb-20">
                  <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
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
                          <i class="fa fa-user mr-5 text-theme-colored"></i> Author : {{ $blog->blog_author }}
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
<script>
  $(document).ready(function() {
    $("#share").jsSocials({
      shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest", "stumbleupon", "whatsapp"]
    });
  });
</script>
@endpush
