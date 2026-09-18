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
  .header-section {
    background-position: 50% 55px;    
    object-fit: cover;
    display: flex;
    justify-content: center;
    text-align: center;
  }
  
  .overlay-dark-7 {
    height: 80vh;
  }

  .fs-16{
    font-size: 16px;
    text-align: left
  }
  .blog-detail-meta {
    display: grid !important;
    grid-template-columns: 78px minmax(0, 1fr);
    gap: 22px;
    align-items: center;
    margin: 12px 0 30px !important;
    padding: 22px !important;
    border: 1px solid #dcebed !important;
    border-radius: 14px;
    background: linear-gradient(135deg, #f8fcfc 0%, #fff 72%);
    box-shadow: 0 8px 22px rgba(20, 79, 88, .07);
  }
  .blog-detail-date {
    display: flex;
    min-height: 78px;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: #0f7c87;
    color: #fff;
    line-height: 1;
    box-shadow: 0 7px 14px rgba(15, 124, 135, .2);
  }
  .blog-detail-date-day { font-size: 28px; font-weight: 800; }
  .blog-detail-date-month { margin-top: 6px; font-size: 11px; font-weight: 800; letter-spacing: .12em; }
  .blog-detail-title {
    margin: 0 0 12px !important;
    color: #123b44 !important;
    font-size: clamp(19px, 2.1vw, 27px) !important;
    font-weight: 800;
    line-height: 1.3;
    text-transform: none !important;
  }
  .blog-detail-byline { display: flex; flex-wrap: wrap; gap: 9px 12px; align-items: center; }
  .blog-detail-author, .blog-detail-published {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border-radius: 999px;
    padding: 7px 11px;
    font-size: 13px;
    font-weight: 700;
  }
  .blog-detail-author { background: #e5f4f4; color: #0e6570; }
  .blog-detail-published { background: #f5f0e6; color: #725824; }
  .blog-detail-author i, .blog-detail-published i { font-size: 12px; }
  @media (max-width: 575px) {
    .blog-detail-meta { grid-template-columns: 62px minmax(0, 1fr); gap: 14px; padding: 15px !important; }
    .blog-detail-date { min-height: 62px; border-radius: 10px; }
    .blog-detail-date-day { font-size: 23px; }
    .blog-detail-title { font-size: 18px !important; }
  }
  .image-sec img {
    width: auto;
    height: auto;
    object-position: center
  }

  @media (min-width: 998px) {
    .image-sec {
      margin-top: 90px;
    }
  }
</style>
@endpush

@section('content')
<div class="main-content">
  <section class="inner-header image-sec divider parallax text-center">
    <img class="w-50" src="{{ asset($blog->blog_image) }}" />
  </section>

  <section>
    <div class="container mt-0 mb-30 pt-0 pb-30">
      <div class="row">
        <div class="col-12">
          <div class="blog-posts single-post">
            <article class="post clearfix mb-0">
              <div class="entry-header">
                <div class="post-thumb thumb">
                  {{-- <img src="{{ asset($blog->blog_image) }}" alt="{{ $blog->blog_title }}" class="img-responsive img-fullwidth"> --}}
                </div>
              </div>
              <div class="entry-content p-15">
                @php($publishedAt = \Carbon\Carbon::parse($blog->created_at))
                <div class="entry-meta blog-detail-meta no-bg no-border">
                  <time class="blog-detail-date" datetime="{{ $publishedAt->toDateString() }}" aria-label="Published {{ $publishedAt->format('F j, Y') }}">
                    <span class="blog-detail-date-day">{{ $publishedAt->format('d') }}</span>
                    <span class="blog-detail-date-month">{{ $publishedAt->format('M') }}</span>
                  </time>
                  <div>
                    <h1 class="entry-title blog-detail-title">{{ $blog->blog_title }}</h1>
                    <div class="blog-detail-byline">
                      @if($blog->blog_author)
                        <span class="blog-detail-author"><i class="fa fa-user" aria-hidden="true"></i> By {{ $blog->blog_author }}</span>
                      @endif
                      <span class="blog-detail-published"><i class="fa fa-calendar" aria-hidden="true"></i> Published {{ $publishedAt->format('F j, Y') }}</span>
                    </div>
                  </div>
                </div>
                <div>{!! app(\App\Support\HtmlSanitizer::class)->sanitize($blog->blog_content) !!}</div>
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
