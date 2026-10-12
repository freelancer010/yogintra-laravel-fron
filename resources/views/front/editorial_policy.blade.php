@extends('layouts.layout')

@section('meta_title', 'Yoga And wellness content editorial policy')
@section('meta_description', 'Learn how YogIntra reviews yoga and wellness content for accuracy, clarity, and responsible guidance.')
@section('meta_author', 'YogIntra Editorial Team')

@push('styles')
<style>
  .editorial-policy-hero{display:flex;min-height:300px;align-items:center;background-position:center 35%!important;background-size:cover}
  .editorial-policy-hero .container{padding-top:70px;padding-bottom:48px}
  .editorial-policy-hero .title{margin:0;color:#fff;font-size:42px;font-weight:800;line-height:1.2;text-shadow:0 2px 12px rgba(0,0,0,.28)}
  .editorial-policy-hero .breadcrumb{margin:14px 0 0;padding:0;background:transparent}
  .editorial-policy-page{padding:72px 20px;background:linear-gradient(180deg,#f5faf9 0,#fff 100%)}
  .editorial-policy-shell{width:100%;max-width:1040px;margin:0 auto;padding:0}
  .editorial-policy-card{overflow:hidden;border:1px solid #dce9e7;border-radius:22px;background:#fff;box-shadow:0 20px 55px rgba(18,63,69,.1)}
  .editorial-policy-intro{padding:50px 56px 42px;border-bottom:1px solid #e1ecea;background:linear-gradient(135deg,#f7fbfa 0,#edf6f4 100%)}
  .editorial-policy-kicker{display:inline-block;margin-bottom:13px;color:#087477;font-size:12px;font-weight:800;letter-spacing:.18em;text-transform:uppercase}
  .editorial-policy-intro h2{max-width:720px;margin:0 0 16px;color:#123f45;font-size:34px;font-weight:800;line-height:1.25}
  .editorial-policy-intro p{max-width:800px;margin:0;color:#526d71;font-size:17px;line-height:1.75}
  .editorial-policy-reviewed{display:inline-flex;align-items:center;gap:8px;margin-top:22px;padding:8px 13px;border:1px solid #cfe2de;border-radius:999px;background:#fff;color:#45636b;font-size:13px;font-weight:700}
  .editorial-policy-reviewed:before{width:8px;height:8px;border-radius:50%;background:#20a574;content:""}
  .editorial-policy-content{padding:14px 56px 52px}
  .editorial-policy-block{display:grid;grid-template-columns:52px minmax(0,1fr);gap:22px;padding:34px 0;border-bottom:1px solid #e5eeec}
  .editorial-policy-block:last-child{border-bottom:0}
  .editorial-policy-number{display:flex;width:44px;height:44px;align-items:center;justify-content:center;border-radius:13px;background:#e9f5f2;color:#087477;font-size:13px;font-weight:900;letter-spacing:.05em}
  .editorial-policy-block h2{margin:2px 0 12px;color:#123f45;font-size:23px;font-weight:800;line-height:1.3}
  .editorial-policy-block p{margin:0;color:#526d71;font-size:16px;line-height:1.75}
  .editorial-policy-list{display:grid!important;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px 18px;margin:18px 0 0!important;padding:0!important;list-style:none!important}
  .editorial-policy-list li{position:relative;display:block!important;margin:0!important;padding:13px 15px 13px 42px!important;border:1px solid #dfebe9;border-radius:12px;background:#f9fcfb;color:#45636b;font-size:15px;line-height:1.55;list-style:none!important}
  .editorial-policy-list li:before{position:absolute;top:13px;left:15px;display:flex;width:19px;height:19px;align-items:center;justify-content:center;border-radius:50%;background:#d9efea;color:#087477;font-size:12px;font-weight:900;content:"\2713"}
  .editorial-policy-disclaimer{margin-top:4px;padding:22px 24px;border:1px solid #efdcbf;border-left:4px solid #d98b3f;border-radius:12px;background:#fffaf2}
  .editorial-policy-disclaimer p{color:#675b49}
  .editorial-policy-contact{align-items:center;margin-top:4px;padding:26px;border:1px solid #d7e8e5;border-radius:15px;background:#f1f8f6}
  .editorial-policy-contact .editorial-policy-number{background:#fff;box-shadow:0 5px 16px rgba(18,63,69,.08)}
  .editorial-policy-contact a{display:inline-flex;margin-top:16px;padding:11px 20px;border-radius:8px;background:#087477;color:#fff;font-size:14px;font-weight:800;text-decoration:none;transition:background-color .2s ease,transform .2s ease}
  .editorial-policy-contact a:hover,.editorial-policy-contact a:focus{background:#055b5e;color:#fff;transform:translateY(-1px)}
  @media(max-width:767px){
    .editorial-policy-hero{min-height:230px;height:auto!important}
    .editorial-policy-hero .container{padding-top:78px;padding-bottom:34px}
    .editorial-policy-hero .title{font-size:31px}
    .editorial-policy-page{padding:40px 15px}
    .editorial-policy-card{border-radius:16px}
    .editorial-policy-intro{padding:32px 24px 28px}
    .editorial-policy-intro h2{font-size:27px}
    .editorial-policy-intro p{font-size:15px}
    .editorial-policy-content{padding:4px 24px 30px}
    .editorial-policy-block{grid-template-columns:1fr;gap:13px;padding:27px 0}
    .editorial-policy-block h2{font-size:21px}
    .editorial-policy-block p{font-size:15px}
    .editorial-policy-list{grid-template-columns:1fr}
    .editorial-policy-disclaimer,.editorial-policy-contact{padding:19px}
  }
</style>
@endpush

@section('content')
<section class="editorial-policy-hero inner-header divider parallax layer-overlay overlay-dark-7" style="background-image:url('{{ asset('assets/front/images/bg/bg6.jpg') }}');">
  <div class="container"><div class="section-content"><div class="row"><div class="col-md-12 text-center">
    <h1 class="title text-white">Editorial Policy</h1>
    <ol class="breadcrumb text-center mt-10"><li class="text-white"><a class="text-white" href="{{ url('/') }}">Home</a></li><li class="active text-gray">Editorial Policy</li></ol>
  </div></div></div></div>
</section>
<section class="editorial-policy-page">
  <div class="editorial-policy-shell">
    <article class="editorial-policy-card">
      <header class="editorial-policy-intro">
        <span class="editorial-policy-kicker">Our content standards</span>
        <h2>How YogIntra creates wellness content</h2>
        <p>YogIntra publishes yoga, meditation, movement, and wellness information to help visitors make informed choices about our services.</p>
        <span class="editorial-policy-reviewed">Last reviewed September 20, 2026</span>
      </header>

      <div class="editorial-policy-content">
        <section class="editorial-policy-block" aria-labelledby="editorial-expertise">
          <span class="editorial-policy-number" aria-hidden="true">01</span>
          <div>
            <h2 id="editorial-expertise">Expertise and review</h2>
            <p>Our content is prepared or reviewed with input from experienced yoga instructors and our service team. We aim to describe practices, programmes, and classes clearly, accurately, and in language that is useful to students.</p>
          </div>
        </section>

        <section class="editorial-policy-block" aria-labelledby="editorial-standards">
          <span class="editorial-policy-number" aria-hidden="true">02</span>
          <div>
            <h2 id="editorial-standards">Editorial standards</h2>
            <ul class="editorial-policy-list">
              <li>We review content for accuracy, clarity, and relevance before publication.</li>
              <li>We update material when services, schedules, policies, or important information change.</li>
              <li>We distinguish general wellness education from personalised medical or therapeutic advice.</li>
              <li>We correct material errors when they are identified.</li>
            </ul>
          </div>
        </section>

        <section class="editorial-policy-block" aria-labelledby="editorial-disclaimer">
          <span class="editorial-policy-number" aria-hidden="true">03</span>
          <div>
            <h2 id="editorial-disclaimer">Wellness disclaimer</h2>
            <div class="editorial-policy-disclaimer">
              <p>Yoga and wellness information on this website is for general educational purposes only. It is not medical advice, diagnosis, or treatment. Please consult a qualified healthcare professional before beginning a new exercise practice if you have an injury, medical condition, concerns about pregnancy, or any other health consideration.</p>
            </div>
          </div>
        </section>

        <section class="editorial-policy-block editorial-policy-contact" aria-labelledby="editorial-contact">
          <span class="editorial-policy-number" aria-hidden="true">04</span>
          <div>
            <h2 id="editorial-contact">Questions or corrections?</h2>
            <p>If you have a question or notice content that needs attention, our team would be happy to review it.</p>
            <a href="{{ url('/contact') }}">Contact YogIntra</a>
          </div>
        </section>
      </div>
    </article>
  </div>
</section>
@endsection
