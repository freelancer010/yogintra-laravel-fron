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
    grid-template-columns: minmax(0, 1fr);
    gap: 0;
    align-items: center;
    margin: 12px 0 30px !important;
    padding: 22px !important;
    border: 1px solid #dcebed !important;
    border-radius: 14px;
    background: linear-gradient(135deg, #f8fcfc 0%, #fff 72%);
    box-shadow: 0 8px 22px rgba(20, 79, 88, .07);
  }
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
  .blog-article-body {
    max-width: none;
    margin: 0;
    padding: 0 22px;
    color: #49636a;
    font-size: 17px;
    line-height: 1.85;
  }
  .blog-article-body > :first-child { margin-top: 0; }
  .blog-article-body p { margin: 0 0 20px; }
  .blog-article-body h2,
  .blog-article-body h3,
  .blog-article-body h4 {
    margin: 36px 0 13px;
    color: #163f48;
    font-weight: 800;
    line-height: 1.35;
  }
  .blog-article-body h2 { font-size: 28px; }
  .blog-article-body h3 { font-size: 23px; }
  .blog-article-body h4 { font-size: 19px; }
  .entry-content .blog-article-body a { color: #087985 !important; font-weight: 700; text-decoration: underline; text-decoration-thickness: 1px; text-underline-offset: 3px; }
  .blog-article-body ul,
  .blog-article-body ol { margin: 0 0 23px; padding-left: 25px; }
  .blog-article-body li { margin-bottom: 8px; padding-left: 4px; }
  .blog-article-body blockquote {
    margin: 28px 0;
    padding: 18px 22px;
    border-left: 4px solid #0f7c87;
    border-radius: 0 10px 10px 0;
    background: #eef8f8;
    color: #245660;
    font-size: 18px;
    font-weight: 600;
  }
  .blog-article-body img { display: block; max-width: 100%; height: auto; margin: 28px auto; border-radius: 12px; }
  .blog-article-body table { display: block; width: 100%; margin: 24px 0; overflow-x: auto; border-collapse: collapse; }
  .blog-article-body th,
  .blog-article-body td { padding: 10px 13px; border: 1px solid #dbe7e8; text-align: left; }
  .blog-article-body th { background: #edf7f7; color: #173f49; }
  @media (max-width: 575px) {
    .blog-detail-meta { padding: 15px !important; }
    .blog-detail-title { font-size: 18px !important; }
    .blog-article-body { padding: 0 15px; font-size: 16px; line-height: 1.75; }
    .blog-article-body h2 { font-size: 24px; }
    .blog-article-body h3 { font-size: 21px; }
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
    <img class="w-50" src="{{ asset($blog->blog_image) }}" alt="{{ $blog->blog_title }}" title="{{ $blog->blog_title }}" />
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
                  <div>
                    <h1 class="entry-title blog-detail-title">{{ $blog->blog_title }}</h1>
                    <div class="blog-detail-byline">
                      @if($blog->blog_author)
                        <span class="blog-detail-author"><i class="fa fa-user" aria-hidden="true"></i> By {{ $blog->blog_author }}</span>
                      @endif
                      <time class="blog-detail-published" datetime="{{ $publishedAt->toDateString() }}"><i class="fa fa-calendar" aria-hidden="true"></i> Published {{ $publishedAt->format('F j, Y') }}</time>
                    </div>
                  </div>
                </div>
                <div class="blog-article-body">{!! app(\App\Support\HtmlSanitizer::class)->sanitize($blog->blog_content) !!}</div>
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
