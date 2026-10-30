@extends('layouts.layout')

@section('meta_title', 'Contact YogIntra | Yoga Classes & Wellness Support')
@section('meta_description', 'Contact YogIntra for help choosing yoga classes, personal sessions, online yoga, corporate wellness, workshops and teacher training programmes.')
@section('meta_keywords', 'Contact YogIntra, Yoga Classes India, Online Yoga Classes, Home Yoga Trainer, Corporate Yoga, Yoga Teacher Training')

@php
    $contact = \App\Support\BusinessContact::fromSetting($app_setting);
    $mapMarkup = app(\App\Support\HtmlSanitizer::class)->sanitize((string) ($app_setting->map_iframe ?? ''));
    $hasEmbeddedMap = str_contains(mb_strtolower($mapMarkup), '<iframe');
    $mapQuery = trim(implode(', ', array_filter([
        $contact['visible_address'] ?? '',
        $contact['country'] ?? '',
    ])));
@endphp

@section('content')
<div class="contact-page">
    <section class="contact-hero divider parallax layer-overlay" aria-labelledby="contact-page-title">
        <div class="contact-hero-inner container">
            <h1 id="contact-page-title">Let&rsquo;s plan your yoga journey</h1>
            <p class="contact-hero-copy">Tell us what you are looking for and we will help you find a class, instructor or wellness programme that fits your goals.</p>
            <nav aria-label="Breadcrumb">
                <ol class="contact-breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="contact-methods" aria-labelledby="contact-methods-title">
        <div class="container">
            <div class="contact-section-heading text-center">
                <span class="contact-kicker">We are here to help</span>
                <h2 id="contact-methods-title">Choose the easiest way to reach us</h2>
                <p>Ask about class formats, availability, locations or the best place to begin.</p>
            </div>

            <div class="contact-method-grid">
                @if (!empty($contact['telephone']))
                    <a class="contact-method-card" href="tel:{{ $contact['telephone_href'] }}" aria-label="Call YogIntra at {{ $contact['telephone'] }}">
                        <span class="contact-method-icon" aria-hidden="true"><i class="fa fa-phone"></i></span>
                        <span class="contact-method-content">
                            <span class="contact-method-label">Call us</span>
                            <strong>{{ $contact['telephone'] }}</strong>
                            <small>Speak with our support team</small>
                        </span>
                        <i class="fa fa-arrow-right contact-method-arrow" aria-hidden="true"></i>
                    </a>
                @endif

                @if (!empty($contact['email']))
                    <a class="contact-method-card" href="mailto:{{ $contact['email'] }}" aria-label="Email YogIntra at {{ $contact['email'] }}">
                        <span class="contact-method-icon" aria-hidden="true"><i class="fa fa-envelope"></i></span>
                        <span class="contact-method-content">
                            <span class="contact-method-label">Email us</span>
                            <strong>{{ $contact['email'] }}</strong>
                            <small>Send your questions any time</small>
                        </span>
                        <i class="fa fa-arrow-right contact-method-arrow" aria-hidden="true"></i>
                    </a>
                @endif

                @if (!empty($contact['visible_address']))
                    <a class="contact-method-card" href="{{ $contact['map_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="View the YogIntra address on Google Maps">
                        <span class="contact-method-icon" aria-hidden="true"><i class="fa fa-map-marker"></i></span>
                        <span class="contact-method-content">
                            <span class="contact-method-label">Visit us</span>
                            <strong>{{ $contact['visible_address'] }}</strong>
                            <small>Open the location in Google Maps</small>
                        </span>
                        <i class="fa fa-arrow-right contact-method-arrow" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <section class="contact-conversation" aria-labelledby="contact-form-title">
        <div class="container">
            <div class="contact-layout">
                <article class="contact-form-card">
                    <span class="contact-kicker">Send an enquiry</span>
                    <h2 id="contact-form-title">Tell us what you need</h2>
                    <p class="contact-form-intro">Share a few details so our team can recommend the right yoga service for you.</p>
                    @include('components.multi-step-form')
                    <p class="contact-privacy-note"><i class="fa fa-lock" aria-hidden="true"></i> Your details are used only to respond to your enquiry. Read our <a href="{{ url('/privacy-policy') }}">privacy policy</a>.</p>
                </article>

                <aside class="contact-support-column" aria-label="What happens after you contact YogIntra">
                    <div class="contact-next-card">
                        <span class="contact-kicker contact-kicker-light">A simple next step</span>
                        <h2>What happens next?</h2>
                        <ol class="contact-next-list">
                            <li><span>1</span><div><strong>We review your needs</strong><p>We look at your goals, preferred class format and location.</p></div></li>
                            <li><span>2</span><div><strong>We suggest suitable options</strong><p>Our team shares the classes or programmes that fit you best.</p></div></li>
                            <li><span>3</span><div><strong>You choose how to begin</strong><p>Ask questions, confirm availability and start when you are ready.</p></div></li>
                        </ol>
                        <div class="contact-response-note"><i class="fa fa-clock-o" aria-hidden="true"></i><span><strong>Friendly, personal guidance</strong>We usually respond within one business day.</span></div>
                    </div>

                    @if ($hasEmbeddedMap || $mapQuery !== '')
                        <div class="contact-map-card">
                            <div class="contact-map-heading">
                                <div><span class="contact-kicker">Find us</span><h3>YogIntra location</h3></div>
                                @if (!empty($contact['map_url']))
                                    <a href="{{ $contact['map_url'] }}" target="_blank" rel="noopener noreferrer">Directions <i class="fa fa-external-link" aria-hidden="true"></i></a>
                                @endif
                            </div>
                            <div class="contact-map" aria-label="Map showing the YogIntra location">
                                @if ($hasEmbeddedMap)
                                    {!! $mapMarkup !!}
                                @else
                                    <iframe src="https://www.google.com/maps?q={{ rawurlencode($mapQuery) }}&amp;output=embed" title="YogIntra location map" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                                @endif
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>
</div>
@endsection


@push('styles')
<style>
    .contact-page{--contact-teal:#086d72;--contact-dark:#143f48;--contact-muted:#557078;--contact-line:#d8e8e5;overflow:hidden;color:var(--contact-dark)}
    .contact-page .contact-hero{position:relative;display:flex;min-height:390px;align-items:center;margin:0;background-image:linear-gradient(90deg,rgba(6,44,49,.88),rgba(6,44,49,.56)),url('{{ asset('assets/front/images/bg/bg6.jpg') }}');background-position:center 40%;background-size:cover}
    .contact-page .contact-hero::after{position:absolute;right:-90px;bottom:-160px;width:390px;height:390px;border:1px solid rgba(255,255,255,.18);border-radius:50%;content:''}
    .contact-page .contact-hero-inner{position:relative;z-index:1;width:100%;padding-top:70px;padding-bottom:65px}
    .contact-kicker{display:inline-block;margin-bottom:12px;color:#0b7478;font-size:12px;font-weight:800;letter-spacing:.16em;text-transform:uppercase}
    .contact-hero h1{max-width:760px;margin:0 0 18px;color:#fff;font-size:52px;font-weight:700;line-height:1.08;letter-spacing:-.025em;text-transform:none}
    .contact-hero-copy{max-width:700px;margin:0;color:rgba(255,255,255,.9);font-size:18px;line-height:1.7}
    .contact-breadcrumb{display:flex;gap:10px;margin:25px 0 0;padding:0;list-style:none;color:rgba(255,255,255,.74);font-size:13px}
    .contact-breadcrumb li+li::before{margin-right:10px;content:'/'}
    .contact-breadcrumb a{color:#fff;font-weight:700}
    .contact-methods{position:relative;padding:82px 0 92px;background:#fff}
    .contact-methods::before{position:absolute;top:-110px;left:-110px;width:280px;height:280px;border-radius:50%;background:rgba(13,119,121,.055);content:'';pointer-events:none}
    .contact-section-heading{max-width:720px;margin:0 auto 42px}
    .contact-section-heading h2,.contact-form-card>h2,.contact-next-card>h2{margin:0 0 13px;color:var(--contact-dark);font-size:36px;font-weight:700;line-height:1.25;text-transform:none}
    .contact-section-heading>p,.contact-form-intro{margin:0;color:var(--contact-muted);font-size:17px;line-height:1.7}
    .contact-method-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}
    .contact-method-card{position:relative;display:grid;grid-template-columns:58px minmax(0,1fr) 20px;gap:18px;min-height:180px;align-items:start;padding:30px 25px;border:1px solid var(--contact-line);border-radius:18px;background:#fff;color:var(--contact-dark);box-shadow:0 12px 34px rgba(19,66,72,.07);transition:transform .22s ease,border-color .22s ease,box-shadow .22s ease}
    .contact-method-card:hover,.contact-method-card:focus{border-color:#a7d2cc;color:var(--contact-dark);box-shadow:0 18px 42px rgba(19,66,72,.13);transform:translateY(-5px)}
    .contact-method-icon{display:flex;width:58px;height:58px;align-items:center;justify-content:center;border-radius:16px;background:#e5f3f1;color:var(--contact-teal);font-size:24px}
    .contact-method-content{display:flex;min-width:0;flex-direction:column}
    .contact-method-label{margin-bottom:7px;color:#789095;font-size:11px;font-weight:800;letter-spacing:.13em;text-transform:uppercase}
    .contact-method-content strong{overflow-wrap:anywhere;color:var(--contact-dark);font-size:16px;line-height:1.55}
    .contact-method-content small{margin-top:8px;color:#70858a;font-size:12px;line-height:1.5}
    .contact-method-arrow{margin-top:18px;color:#83aaa5;transition:transform .2s ease}
    .contact-method-card:hover .contact-method-arrow{transform:translateX(4px)}
    .contact-conversation{padding:92px 0 105px;background:linear-gradient(135deg,#eff7f6 0%,#f9fbfb 48%,#e8f3f1 100%)}
    .contact-layout{display:grid;grid-template-columns:minmax(0,1.12fr) minmax(350px,.88fr);gap:34px;align-items:start}
    .contact-form-card,.contact-next-card,.contact-map-card{border:1px solid rgba(19,109,114,.13);border-radius:22px;background:#fff;box-shadow:0 18px 48px rgba(17,64,70,.09)}
    .contact-form-card{padding:45px 48px}
    .contact-form-intro{margin-bottom:30px}
    .contact-form-card .embedded-form{max-width:none;margin:0;padding:0;border-radius:0;background:transparent;box-shadow:none}
    .contact-form-card .form-group{margin-bottom:20px}
    .contact-form-card .form-group label{display:block;margin-bottom:8px;color:#294f56;font-size:13px;font-weight:800}
    .contact-form-card .form-control{width:100%;height:50px;padding:10px 15px;border:1px solid #cbdedb;border-radius:9px;background:#fbfdfd;color:#173f47;font-size:15px;box-shadow:none;transition:border-color .2s ease,box-shadow .2s ease,background-color .2s ease}
    .contact-form-card textarea.form-control{min-height:125px;height:auto}
    .contact-form-card .form-control:focus{border-color:#16848a;background:#fff;box-shadow:0 0 0 3px rgba(22,132,138,.12)}
    .contact-form-card .btn{min-width:118px;height:48px;border:0;border-radius:8px;font-size:14px;font-weight:800;letter-spacing:.02em}
    .contact-form-card .btn-primary{background:#0b777b!important;border-color:#0b777b!important}
    .contact-form-card .btn-primary:hover,.contact-form-card .btn-primary:focus{background:#075c60!important;border-color:#075c60!important}
    .contact-form-card .btn-light{background:#e8efee!important;border:1px solid #cadbd8!important;color:#244c53!important}
    .contact-form-card .error-message{font-weight:600}
    .contact-privacy-note{display:flex;gap:8px;align-items:flex-start;margin:24px 0 0;padding-top:20px;border-top:1px solid #e2edeb;color:#72878b;font-size:12px;line-height:1.6}
    .contact-privacy-note i{margin-top:3px;color:#6c9a95}
    .contact-privacy-note a{color:#087477;font-weight:700;text-decoration:underline}
    .contact-support-column{display:grid;gap:26px}
    .contact-next-card{overflow:hidden;padding:42px;background:linear-gradient(150deg,#0e6268,#143f48);color:#fff}
    .contact-kicker-light{color:#9fe2dc}
    .contact-next-card>h2{color:#fff;font-size:31px}
    .contact-next-list{display:grid;gap:23px;margin:31px 0 28px;padding:0;list-style:none}
    .contact-next-list li{display:grid;grid-template-columns:38px 1fr;gap:15px;align-items:start}
    .contact-next-list li>span{display:flex;width:36px;height:36px;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,.3);border-radius:50%;background:rgba(255,255,255,.1);color:#fff;font-size:13px;font-weight:800}
    .contact-next-list strong{display:block;margin-bottom:4px;color:#fff;font-size:15px}
    .contact-next-list p{margin:0;color:rgba(255,255,255,.73);font-size:13px;line-height:1.65}
    .contact-response-note{display:flex;gap:13px;align-items:center;padding:16px;border:1px solid rgba(255,255,255,.16);border-radius:11px;background:rgba(255,255,255,.08)}
    .contact-response-note>i{color:#9fe2dc;font-size:20px}
    .contact-response-note span{display:flex;flex-direction:column;color:rgba(255,255,255,.74);font-size:12px;line-height:1.5}
    .contact-response-note strong{color:#fff;font-size:13px}
    .contact-map-card{overflow:hidden}
    .contact-map-heading{display:flex;align-items:center;justify-content:space-between;padding:25px 27px 20px}
    .contact-map-heading .contact-kicker{margin-bottom:4px}
    .contact-map-heading h3{margin:0;color:var(--contact-dark);font-size:20px;font-weight:700}
    .contact-map-heading>a{color:#087477;font-size:12px;font-weight:800}
    .contact-map{height:245px;background:#dbe9e7}
    .contact-map iframe{display:block;width:100%!important;height:100%!important;border:0!important}
    @media (max-width:991px){
        .contact-page .contact-hero{min-height:350px}.contact-hero h1{font-size:45px}
        .contact-method-grid{grid-template-columns:1fr;max-width:680px;margin:0 auto}.contact-method-card{min-height:0}
        .contact-layout{grid-template-columns:1fr;max-width:760px;margin:0 auto}
        .contact-support-column{grid-template-columns:repeat(2,minmax(0,1fr))}.contact-next-card,.contact-map-card{height:100%}
    }
    @media (max-width:767px){
        .contact-page{width:100vw!important;max-width:100vw!important;margin:0!important}
        .contact-page section,.contact-page .container,.contact-page .contact-layout,.contact-page .contact-support-column{width:100%;max-width:100%;min-width:0;box-sizing:border-box}
        .contact-page .container{margin-right:0!important;margin-left:0!important}
        .contact-page .contact-hero{min-height:380px;background-position:42% center}.contact-page .contact-hero-inner{padding:74px 22px 55px}
        .contact-hero h1{font-size:38px;line-height:1.12}.contact-hero-copy{font-size:16px;line-height:1.65}
        .contact-page h1,.contact-page h2,.contact-page h3,.contact-page p,.contact-method-content strong{max-width:100%;white-space:normal!important;overflow-wrap:anywhere;text-wrap:wrap!important}
        .contact-methods{padding:62px 0 68px}.contact-methods .container,.contact-conversation .container{padding-right:18px!important;padding-left:18px!important}
        .contact-section-heading{margin-bottom:30px}.contact-section-heading h2,.contact-form-card>h2{font-size:29px}.contact-section-heading>p,.contact-form-intro{font-size:15px}
        .contact-method-grid{width:100%;max-width:100%;gap:14px}.contact-method-card{grid-template-columns:49px minmax(0,1fr) 16px;width:100%;max-width:100%;gap:14px;padding:22px 17px;border-radius:14px;box-sizing:border-box}
        .contact-method-icon{width:49px;height:49px;border-radius:13px;font-size:20px}.contact-method-content strong{font-size:14px}.contact-method-content small{font-size:11px}
        .contact-conversation{padding:68px 0 76px}.contact-layout{gap:20px}.contact-form-card{padding:30px 20px;border-radius:17px}
        .contact-form-card .form-control{font-size:16px}.contact-form-card .form-buttons,.contact-form-card .d-flex{flex-wrap:wrap}.contact-form-card .btn{min-width:108px}
        .contact-support-column{grid-template-columns:1fr;gap:20px}.contact-next-card{padding:30px 22px;border-radius:17px}.contact-next-card>h2{font-size:27px}
        .contact-map-card{border-radius:17px}.contact-map-heading{padding:22px 20px 18px}.contact-map{height:230px}
    }
</style>
@endpush
