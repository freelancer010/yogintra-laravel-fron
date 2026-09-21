@php use Illuminate\Support\Str; @endphp

@extends('layouts.layout')

@section('meta_title', 'Blog - Informative Yoga & Wellness Blogs | YogIntra')
@section('meta_description', 'Practical yoga, wellness, mindfulness and healthy-living guidance from the YogIntra team.')
@section('meta_keywords', 'yoga blog, wellness blog, mindfulness, yoga tips, online yoga classes India, yoga classes Mumbai')

@push('styles')
    <style>
        .blog-index { width:100%; max-width:100%; overflow-x:hidden; background: #f6faf9; }
        .blog-index-hero { position:relative; display:block !important; width:100% !important; max-width:100% !important; height:330px !important; min-height:0 !important; margin:0 !important; padding:0 !important; overflow:hidden; background:#123f49; }
        .blog-index-hero-image { display:block !important; width:100% !important; max-width:none !important; height:100% !important; min-height:0 !important; margin:0 !important; padding:0 !important; object-fit:cover !important; object-position:center !important; }
        .blog-index-hero::after { position:absolute; inset:0; content:''; background:rgba(10,42,48,.58); }
        .blog-index-hero-content { position:absolute; z-index:1; inset:0; display:flex; align-items:center; justify-content:center; color:#fff; text-align:center; }
        .blog-index-hero-content h1 { margin:0; color:#fff; font-size:clamp(38px, 5vw, 56px); font-weight:800; line-height:1.1; }
        .blog-index-content { padding: 38px 0 80px; }
        .blog-index-heading { max-width: 700px; margin: 0 auto 40px; text-align: center; }
        .blog-index-heading h2 { margin: 0 0 10px; color: #153f49; font-size: clamp(27px, 3vw, 38px); font-weight: 700; }
        .blog-index-heading p { margin: 0; color: #647b82; font-size: 17px; line-height: 1.6; }
        .blog-posts { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 28px; }
        .blog-posts .blog-card { float: none; width: auto; min-width: 0; padding: 0; margin: 0; }
        .blog-card .post { display: flex; flex-direction: column; height: 100%; margin: 0; overflow: hidden; border: 1px solid #dce8e8; border-radius: 18px; background: #fff; box-shadow: 0 8px 22px rgba(20,63,73,.07); transition: transform .25s ease, box-shadow .25s ease; }
        .blog-card .post:hover { transform: translateY(-7px); box-shadow: 0 18px 38px rgba(20,63,73,.14); }
        .blog-card .post-thumb { position: relative; aspect-ratio: 16 / 10; overflow: hidden; background: linear-gradient(135deg, #dbeeed, #b9d8d2); }
        .blog-card .post-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .45s ease; }
        .blog-card .post:hover .post-thumb img { transform: scale(1.06); }
        .blog-card .post-thumb-fallback { display: flex; align-items: center; justify-content: center; height: 100%; padding: 24px; color: #153f49; font-size: 19px; font-weight: 700; line-height: 1.35; text-align: center; }
        .blog-card .entry-content { display: flex; flex: 1; flex-direction: column; padding: 24px; border: 0; }
        .blog-card .entry-meta { display: flex; align-items: center; gap: 10px; margin: 0 0 16px; color: #65808a; font-size: 13px; }
        .blog-card .entry-date { display: inline-flex; align-items: center; padding: 6px 10px; border-radius: 7px; background: #e8f5f3; color: #107c87; font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
        .blog-card .entry-category { color: #647b82; font-size: 13px; font-weight: 600; }
        .blog-card .entry-title { margin: 0 0 13px; color: #153f49; font-size: 21px; font-weight: 700; line-height: 1.34; }
        .blog-card .entry-title a { color: inherit; }
        .blog-card .entry-title a:hover { color: #10828d; }
        .blog-card .entry-excerpt { margin: 0 0 22px; color: #62767d; font-size: 15px; line-height: 1.65; }
        .blog-card .btn-read-more { display: inline-flex; align-items: center; gap: 8px; align-self: flex-start; margin-top: auto; color: #10828d; font-size: 14px; font-weight: 700; }
        .blog-card .btn-read-more::after { content: '→'; font-size: 19px; line-height: 1; transition: transform .2s ease; }
        .blog-card .btn-read-more:hover::after { transform: translateX(4px); }
        .blog-index-empty { max-width: 620px; margin: 0 auto; padding: 52px 30px; border: 1px dashed #b9d1d1; border-radius: 18px; background: #fff; color: #647b82; text-align: center; }
        .blog-index-empty h2 { margin: 0 0 8px; color: #153f49; font-size: 25px; }
        @media (max-width: 991px) { .blog-posts { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (max-width: 767px) { .blog-index-hero { height: 230px; } .blog-index-hero-content h1 { font-size:38px; } .blog-index-content { padding: 32px 0 58px; } .blog-posts { grid-template-columns: 1fr; gap: 20px; } .blog-card .entry-content { padding: 21px; } }
        @media (prefers-reduced-motion: reduce) { .blog-card .post, .blog-card .post-thumb img { transition: none; } }
    </style>
@endpush

@section('content')
<main class="blog-index">
    <section class="blog-index-hero" aria-label="YogIntra blog">
        <img class="blog-index-hero-image" src="{{ asset('assets/front/images/bg/bg6.jpg') }}" alt="Peaceful YogIntra wellness landscape" title="Peaceful YogIntra wellness landscape" fetchpriority="high" style="display:block!important;width:100%!important;max-width:none!important;height:100%!important;margin:0!important;padding:0!important;object-fit:cover!important;object-position:center!important;">
        <div class="blog-index-hero-content">
            <h1>Blog</h1>
        </div>
    </section>

    <section class="blog-index-content" aria-labelledby="latest-stories-title">
        <div class="container">
            <header class="blog-index-heading">
                <h2 id="latest-stories-title">Latest stories</h2>
                <p>Explore yoga practices, wellbeing advice and simple ways to feel more balanced.</p>
            </header>

            @forelse ($get_all_blog as $all_blog)
                @if ($loop->first)<div class="blog-posts">@endif
                <div class="blog-card">
                    <article class="post">
                        <a href="{{ url('/blog/' . $all_blog->blog_slug) }}" aria-label="Read {{ $all_blog->blog_title }}">
                            <div class="post-thumb">
                                @if ($all_blog->blog_image)
                                    <img src="{{ asset($all_blog->blog_image) }}" alt="{{ $all_blog->blog_title }}" title="{{ $all_blog->blog_title }}" loading="lazy" decoding="async">
                                @else
                                    <div class="post-thumb-fallback">{{ Str::limit($all_blog->blog_title, 72) }}</div>
                                @endif
                            </div>
                        </a>
                        <div class="entry-content">
                            <div class="entry-meta">
                                <time class="entry-date" datetime="{{ optional($all_blog->created_at)->toDateString() }}">{{ \Carbon\Carbon::parse($all_blog->created_at)->format('d M Y') }}</time>
                                @if ($all_blog->category)
                                    <span class="entry-category">{{ $all_blog->category->category_name }}</span>
                                @endif
                            </div>
                            <h2 class="entry-title"><a href="{{ url('/blog/' . $all_blog->blog_slug) }}">{{ Str::limit($all_blog->blog_title, 72) }}</a></h2>
                            <p class="entry-excerpt">{{ Str::limit(trim(strip_tags($all_blog->blog_short_description ?: $all_blog->blog_content)), 155) }}</p>
                            <a href="{{ url('/blog/' . $all_blog->blog_slug) }}" class="btn-read-more">Read article</a>
                        </div>
                    </article>
                </div>
                @if ($loop->last)</div>@endif
            @empty
                <div class="blog-index-empty">
                    <h2>New articles are on their way</h2>
                    <p>Please check back soon for practical yoga and wellness guidance.</p>
                </div>
            @endforelse

            @if ($get_all_blog instanceof \Illuminate\Contracts\Pagination\Paginator && $get_all_blog->hasPages())
                <div class="row"><div class="col-md-12 text-center mt-40">{{ $get_all_blog->links('pagination::bootstrap-4') }}</div></div>
            @endif
        </div>
    </section>
</main>
@endsection
