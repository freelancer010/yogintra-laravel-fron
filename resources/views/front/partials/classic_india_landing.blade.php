@php
    $classicCities = ['Mumbai', 'Delhi', 'Bengaluru', 'Hyderabad', 'Chennai', 'Pune', 'Kolkata', 'Ahmedabad', 'Jaipur', 'Chandigarh', 'Gurgaon', 'Noida', 'Thane', 'Navi Mumbai', 'Kochi', 'Indore', 'Lucknow', 'Surat', 'Vadodara', 'Bhubaneswar'];
    $classicServices = [
        ['icon' => 'fa-laptop', 'title' => 'Online Yoga Classes', 'text' => 'Live, instructor-led yoga sessions from the comfort of home.'],
        ['icon' => 'fa-user', 'title' => 'Personalized Yoga Classes', 'text' => 'Practice adapted to your experience, goals, schedule and comfort level.'],
        ['icon' => 'fa-leaf', 'title' => 'Yoga for Beginners', 'text' => 'Learn foundational poses, breathing, alignment and relaxation progressively.'],
        ['icon' => 'fa-arrows', 'title' => 'Flexibility & Mobility', 'text' => 'Build body awareness and comfortable movement through a consistent practice.'],
        ['icon' => 'fa-heart', 'title' => 'Stress Management', 'text' => 'Make dedicated time for mindful movement, breathing and relaxation.'],
        ['icon' => 'fa-briefcase', 'title' => 'Yoga for Professionals', 'text' => 'Flexible sessions that fit around work, sitting and everyday demands.'],
        ['icon' => 'fa-universal-access', 'title' => 'Yoga for Seniors', 'text' => 'Gentle, adaptable practices for mobility, balance and comfortable movement.'],
        ['icon' => 'fa-female', 'title' => "Women's Yoga & Wellness", 'text' => 'Personalized practices that can adapt to individual needs and life stages.'],
    ];
@endphp

<style>
  .india-classic { --india-teal:#0d6772; --india-ink:#143b43; --india-mist:#eff8f7; color:var(--india-ink); font-family:Roboto,Arial,sans-serif; overflow:hidden; }
  .india-classic section { position:relative; padding:86px 0; }
  .india-classic .india-shell { width:min(1140px, calc(100% - 32px)); margin:0 auto; }
  .india-classic .india-eyebrow { display:inline-flex; align-items:center; gap:8px; padding:7px 13px; border-radius:99px; background:#dff1ee; color:var(--india-teal); font-size:12px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
  .india-classic h2 { margin:14px 0 15px; color:var(--india-ink); font-family:Roboto,Arial,sans-serif; font-size:clamp(30px, 4vw, 45px); font-weight:700; line-height:1.16; }
  .india-classic .india-lead { max-width:760px; margin:0 auto; color:#496a71; font-size:18px; line-height:1.75; }
  .india-classic .india-btn { display:inline-flex; align-items:center; justify-content:center; min-height:48px; padding:12px 23px; border:1px solid var(--india-teal); border-radius:6px; background:var(--india-teal); color:#fff !important; font-family:Roboto,Arial,sans-serif; font-weight:700; text-decoration:none !important; transition:transform .2s ease, background .2s ease, box-shadow .2s ease; }
  .india-classic .india-btn:hover, .india-classic .india-btn:focus { background:#094f56; color:#fff !important; box-shadow:0 12px 25px rgba(13,103,114,.22); transform:translateY(-2px); }
  .india-classic .india-btn-outline { border-color:#b7d4d3; background:transparent; color:var(--india-teal) !important; }
  .india-classic .india-btn-outline:hover, .india-classic .india-btn-outline:focus { border-color:var(--india-teal); background:#e9f5f3; color:var(--india-teal) !important; }
  .india-classic .india-actions { display:flex; flex-wrap:wrap; justify-content:center; gap:12px; margin-top:28px; }
  .india-classic .india-reveal { opacity:0; transform:translateY(22px); transition:opacity .65s ease, transform .65s ease; }
  .india-classic .india-reveal.is-visible { opacity:1; transform:none; }
  .india-classic-hero { background:#f7f4ee; }
  .india-classic-hero::before, .india-classic-hero::after { display:none; }
  .india-classic-hero .india-shell { position:relative; z-index:1; max-width:900px; text-align:center; }
  .india-classic-hero h1, .india-classic-hero h2 { max-width:820px; margin:16px auto; color:#102f37; font-family:Roboto,Arial,sans-serif; font-size:clamp(36px, 4.25vw, 54px); font-weight:700; line-height:1.1; letter-spacing:-.03em; }
  .india-classic-hero .india-hero-copy { max-width:800px; margin:0 auto; color:#41656c; font-size:19px; line-height:1.75; }
  .india-classic-hero .india-hero-note { max-width:780px; margin:20px auto 0; color:#55757b; font-size:16px; line-height:1.7; }
  .india-benefits { margin-top:52px; display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:16px; }
  .india-benefit { min-height:142px; padding:22px 17px; border:1px solid #dcebe9; border-radius:14px; background:rgba(255,255,255,.84); box-shadow:0 10px 24px rgba(17,70,76,.06); text-align:left; }
  .india-benefit i { display:grid; width:38px; height:38px; place-items:center; border-radius:10px; background:#e4f4f1; color:var(--india-teal); font-size:18px; }
  .india-benefit strong { display:block; margin-top:15px; font-size:16px; line-height:1.3; }
  .india-benefit span { display:block; margin-top:6px; color:#607c81; font-size:13px; line-height:1.55; }
  .india-story { padding:68px 0 !important; background:#fff; }
  .india-story-grid { display:grid; grid-template-columns:.82fr 1.18fr; gap:56px; align-items:center; }
  .india-story-mark { position:relative; display:grid; min-height:320px; place-items:center; overflow:hidden; border-radius:18px; background:#0d6772; box-shadow:0 18px 36px rgba(13,103,114,.16); color:#fff; text-align:center; }
  .india-story-mark > img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; object-position:62% center; opacity:.84; filter:saturate(.72); }
  .india-story-mark::after { position:absolute; inset:0; background:rgba(13,103,114,.52); content:''; }
  .india-story-mark > div { position:relative; z-index:1; padding:28px; }
  .india-story-mark strong { display:block; max-width:235px; font-family:Roboto,Arial,sans-serif; font-size:24px; font-weight:700; line-height:1.28; }
  .india-story h2 { max-width:660px; margin-top:15px; font-size:clamp(32px, 3.4vw, 46px); line-height:1.12; }
  .india-story .india-copy { max-width:650px; color:#4d6c72; font-size:17px; line-height:1.75; }
  .india-story .india-copy p + p { margin-top:15px; }
  .india-story .india-copy .india-story-next { margin-top:18px; color:#143b43; font-weight:700; }
  .india-story-link { display:inline-flex; align-items:center; gap:8px; margin-top:22px; color:var(--india-teal) !important; font-family:Roboto,Arial,sans-serif; font-size:15px; font-weight:700; text-decoration:none !important; }
  .india-story-link::after { width:34px; height:2px; background:var(--india-teal); content:''; transition:width .2s ease; }
  .india-story-link:hover::after { width:48px; }
  .india-service-section { background:#f5faf9; }
  .india-service-grid { display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:18px; margin-top:32px; }
  .india-service-group + .india-service-group { margin-top:48px; }
  .india-service-group-label { display:flex; align-items:center; gap:12px; margin-top:44px; color:#0d6772; font-family:Roboto,Arial,sans-serif; font-size:13px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
  .india-service-group-label::before, .india-service-group-label::after { height:1px; background:#d8e9e6; content:''; }
  .india-service-group-label::before { width:42px; }.india-service-group-label::after { flex:1; }
  .india-service-card-link { display:block; height:100%; color:inherit !important; text-decoration:none !important; }
  .india-service { position:relative; display:flex; flex-direction:column; min-height:228px; height:100%; padding:24px 22px; border:1px solid #dceae8; border-radius:13px; background:#fff; box-shadow:0 8px 18px rgba(17,70,76,.045); transition:transform .22s ease, box-shadow .22s ease, border-color .22s ease; }
  .india-service-card-link:hover .india-service, .india-service-card-link:focus .india-service { border-color:#9fcfc9; box-shadow:0 16px 28px rgba(17,70,76,.11); transform:translateY(-4px); }
  .india-service i { display:grid; width:38px; height:38px; place-items:center; border-radius:10px; background:#e4f4f1; color:var(--india-teal); font-size:18px; }
  .india-service h3 { margin:18px 0 9px; color:var(--india-ink); font-family:Roboto,Arial,sans-serif; font-size:18px; font-weight:700; line-height:1.32; }
  .india-service p { margin:0; color:#5c787d; font-family:Roboto,Arial,sans-serif; font-size:14px; line-height:1.62; }
  .india-service .india-card-link { display:inline-flex; align-items:center; gap:7px; margin-top:auto; padding-top:17px; color:var(--india-teal); font-family:Roboto,Arial,sans-serif; font-size:13px; font-weight:700; opacity:0; transform:translateY(4px); transition:opacity .2s ease, transform .2s ease; }
  .india-service .india-card-link i { display:inline; width:auto; height:auto; border-radius:0; background:transparent; color:inherit; font-size:12px; }
  .india-service-card-link:hover .india-card-link, .india-service-card-link:focus .india-card-link { opacity:1; transform:none; }
  .india-service-guidance { display:flex; align-items:center; justify-content:center; flex-wrap:wrap; gap:15px; margin-top:42px; color:#496a71; font-family:Roboto,Arial,sans-serif; font-size:16px; }
  .india-service-guidance .india-btn { min-height:42px; padding:9px 17px; }
  .india-for-grid, .india-benefit-grid { display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); gap:20px; margin-top:38px; }
  .india-list-panel { padding:32px; border-radius:16px; background:#fff; box-shadow:0 12px 30px rgba(17,70,76,.07); }
  .india-list-panel h3 { margin:0 0 16px; color:var(--india-ink); font-size:22px; font-weight:800; }
  .india-check-list { margin:0; padding:0; list-style:none; }
  .india-check-list li { position:relative; padding:9px 0 9px 29px; color:#4e6f75; line-height:1.5; }
  .india-check-list li::before { position:absolute; top:10px; left:0; display:grid; width:18px; height:18px; place-items:center; border-radius:50%; background:#dff1ee; color:var(--india-teal); content:'✓'; font-size:12px; font-weight:800; }
  .india-benefits-section { background:linear-gradient(135deg, #113f48, #0d6c75); color:#fff; }
  .india-benefits-section h2, .india-benefits-section .india-lead { color:#fff; }
  .india-benefits-section .india-lead { opacity:.84; }
  .india-benefit-grid { grid-template-columns:repeat(3, minmax(0,1fr)); }
  .india-benefit-card { padding:29px; border:1px solid rgba(255,255,255,.17); border-radius:15px; background:rgba(255,255,255,.09); }
  .india-benefit-card h3 { margin:0 0 14px; color:#fff; font-size:21px; font-weight:800; }
  .india-benefit-card .india-check-list li { color:rgba(255,255,255,.84); }
  .india-benefit-card .india-check-list li::before { background:rgba(255,255,255,.17); color:#fff; }
  .india-steps { display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:26px; margin-top:38px; }
  .india-step { position:relative; padding:30px; border-radius:16px; background:#fff; box-shadow:0 13px 30px rgba(17,70,76,.08); }
  .india-step-number { display:grid; width:42px; height:42px; place-items:center; border-radius:50%; background:#e1f2ef; color:var(--india-teal); font-weight:900; }
  .india-step h3 { margin:18px 0 8px; color:var(--india-ink); font-size:21px; font-weight:800; }
  .india-step p { margin:0; color:#5c787d; line-height:1.65; }
  .india-locations { background:#f5faf9; }
  .india-city-cloud { display:flex; flex-wrap:wrap; justify-content:center; gap:10px; max-width:920px; margin:35px auto 0; }
  .india-city-cloud span { padding:9px 14px; border:1px solid #d5e7e4; border-radius:99px; background:#fff; color:#315e66; font-weight:700; }
  .india-packages { display:grid; grid-template-columns:repeat(3, minmax(0,1fr)); gap:22px; margin-top:40px; }
  .india-package { display:flex; flex-direction:column; padding:34px 28px; border:1px solid #d9e8e6; border-radius:17px; background:#fff; box-shadow:0 12px 28px rgba(17,70,76,.06); }
  .india-package.is-featured { border-color:var(--india-teal); box-shadow:0 18px 36px rgba(13,103,114,.15); transform:translateY(-8px); }
  .india-package h3 { margin:0; color:var(--india-ink); font-size:23px; font-weight:800; }
  .india-package > p { min-height:50px; color:#5c787d; line-height:1.6; }
  .india-package .india-check-list { margin:8px 0 24px; }
  .india-package .india-btn { margin-top:auto; }
  .india-faq { max-width:900px; margin:38px auto 0; }
  .india-faq details { margin:11px 0; padding:0 22px; border:1px solid #d9e8e6; border-radius:10px; background:#fff; }
  .india-faq summary { padding:18px 0; color:var(--india-ink); cursor:pointer; font-size:17px; font-weight:800; }
  .india-faq p { margin:0; padding:0 0 18px; color:#527177; line-height:1.7; }
  .india-final { background:linear-gradient(135deg, #e1f3f0, #edf5ff); text-align:center; }
  .india-final .india-shell { max-width:820px; }
  @media (max-width:991px) { .india-benefits { grid-template-columns:repeat(2,minmax(0,1fr)); }.india-service-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }.india-story-grid { gap:35px; }.india-benefit-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
  @media (max-width:767px) { .india-classic section { padding:58px 0; }.india-classic-hero h1 { font-size:36px; }.india-classic-hero .india-hero-copy, .india-classic .india-lead { font-size:16px; }.india-benefits, .india-service-grid, .india-for-grid, .india-benefit-grid, .india-steps, .india-packages, .india-story-grid { grid-template-columns:1fr; }.india-story { padding:54px 0 !important; }.india-story-mark { min-height:270px; }.india-story h2 { font-size:32px; }.india-service-section { padding:52px 0 !important; }.india-service-grid { gap:12px; margin-top:24px; }.india-service-group + .india-service-group { margin-top:36px; }.india-service-group-label { margin-top:34px; }.india-service { display:grid !important; grid-template-columns:40px minmax(0,1fr); column-gap:15px; min-height:0; padding:20px; }.india-service i { grid-row:1 / span 3; grid-column:1; }.india-service h3 { grid-column:2; margin:1px 0 6px; font-size:17px; }.india-service p { grid-column:2; font-size:14px; }.india-service .india-card-link { grid-column:2; margin-top:12px; padding-top:0; opacity:1; transform:none; }.india-service-guidance { align-items:stretch; flex-direction:column; margin-top:30px; text-align:center; }.india-service-guidance .india-btn { align-self:center; width:auto; }.india-benefit { min-height:0; }.india-list-panel, .india-step, .india-package { padding:25px 21px; }.india-package.is-featured { transform:none; }.india-actions { flex-direction:column; }.india-btn { width:100%; }.india-final .india-btn { width:auto; } }
  @media (prefers-reduced-motion:reduce) { .india-classic *, .india-classic .india-reveal { scroll-behavior:auto !important; transition:none !important; transform:none !important; } .india-classic .india-reveal { opacity:1; } }
</style>

<main class="india-classic" id="classic-india-template">
  <section class="india-classic-hero">
    <div class="india-shell india-reveal">
      <span class="india-eyebrow"><i class="fa fa-leaf" aria-hidden="true"></i> Yoga for everyday life</span>
      <h2>For a Healthier, More Balanced Life</h2>
      <p class="india-hero-copy">Practice yoga with experienced instructors through personalized and online yoga classes across India.</p>
      <p class="india-hero-note">Whether you are a beginner, a busy professional, a senior, or an experienced practitioner, YogIntra makes it easier to build a consistent practice around your goals, schedule and lifestyle.</p>
      <div class="india-actions"><a class="india-btn" href="{{ url('contact') }}">Book Your Yoga Session</a><a class="india-btn india-btn-outline" href="{{ url('service') }}">Explore Yoga Classes</a></div>
      <div class="india-benefits">
        <article class="india-benefit"><i class="fa fa-user" aria-hidden="true"></i><strong>Experienced instructors</strong><span>Structured, mindful guidance.</span></article>
        <article class="india-benefit"><i class="fa fa-home" aria-hidden="true"></i><strong>Practice from home</strong><span>Convenient sessions without travel.</span></article>
        <article class="india-benefit"><i class="fa fa-sliders" aria-hidden="true"></i><strong>Personalized classes</strong><span>Adapted to your comfort and goals.</span></article>
        <article class="india-benefit"><i class="fa fa-clock-o" aria-hidden="true"></i><strong>Flexible scheduling</strong><span>Fits work, family and daily life.</span></article>
      </div>
    </div>
  </section>

  <section class="india-story"><div class="india-shell india-story-grid india-reveal"><div class="india-story-mark"><img src="{{ asset('assets/about-women.webp') }}" alt="Woman practising yoga"><div><strong>Your yoga partner, wherever you are in India</strong></div></div><div><span class="india-eyebrow">About YogIntra</span><h2>Start where you are. Practice at your pace.</h2><div class="india-copy"><p>Yoga has been part of India’s wellness traditions for centuries. YogIntra brings that practice into modern everyday life with convenient, personalized yoga sessions.</p><p>You do not need to be flexible, experienced, or ready to change your whole routine. With thoughtful guidance and a practice that fits your day, yoga can become a sustainable part of your wellbeing journey.</p><p class="india-story-next">Explore a practice that fits your life.</p></div><a class="india-story-link" href="{{ url('about') }}">About YogIntra</a></div></div></section>

  <section class="india-service-section"><div class="india-shell text-center india-reveal"><span class="india-eyebrow">Find your format</span><h2>Yoga Services Available Across India</h2><p class="india-lead">Choose a practice that meets you where you are, from live online guidance to sessions designed around your personal goals.</p><div class="india-service-group"><div class="india-service-grid">@foreach(array_slice($classicServices, 0, 4) as $service)<a class="india-service-card-link" href="{{ url('service') }}" aria-label="Explore {{ $service['title'] }}"><article class="india-service"><i class="fa {{ $service['icon'] }}" aria-hidden="true"></i><h3>{{ $service['title'] }}</h3><p>{{ $service['text'] }}</p><span class="india-card-link">Explore <i class="fa fa-arrow-right" aria-hidden="true"></i></span></article></a>@endforeach</div></div><div class="india-service-group"><div class="india-service-group-label">Wellness support</div><div class="india-service-grid">@foreach(array_slice($classicServices, 4) as $service)<a class="india-service-card-link" href="{{ url('service') }}" aria-label="Explore {{ $service['title'] }}"><article class="india-service"><i class="fa {{ $service['icon'] }}" aria-hidden="true"></i><h3>{{ $service['title'] }}</h3><p>{{ $service['text'] }}</p><span class="india-card-link">Explore <i class="fa fa-arrow-right" aria-hidden="true"></i></span></article></a>@endforeach</div></div><div class="india-service-guidance"><span>Not sure which class suits you?</span><a class="india-btn india-btn-outline" href="{{ url('contact') }}">Talk to us</a></div></div></section>

  <section><div class="india-shell text-center india-reveal"><span class="india-eyebrow">Made for real life</span><h2>Yoga Classes for Different Needs, Ages & Experience Levels</h2><p class="india-lead">You do not have to fit a particular fitness level to begin. Your practice can evolve as your experience and requirements change.</p><div class="india-for-grid"><article class="india-list-panel text-left"><h3>Who can begin</h3><ul class="india-check-list"><li>Yoga beginners learning from the basics</li><li>Working professionals seeking convenient sessions</li><li>Students exploring movement, mindfulness and relaxation</li><li>Seniors looking for gentle, adaptable movement</li><li>People working on flexibility and mobility</li></ul></article><article class="india-list-panel text-left"><h3>What a practice can support</h3><ul class="india-check-list"><li>Complementing an active lifestyle</li><li>More relaxation and mindful movement</li><li>Structured guidance for experienced practitioners</li><li>A home-based online yoga routine</li><li>A pace that feels realistic and sustainable</li></ul></article></div></div></section>

  <section class="india-benefits-section"><div class="india-shell text-center india-reveal"><span class="india-eyebrow" style="background:rgba(255,255,255,.13);color:#fff">Regular practice</span><h2>Benefits of Regular Yoga Practice</h2><p class="india-lead">When practiced appropriately and consistently, yoga can support movement, mindfulness, relaxation and overall wellbeing.</p><div class="india-benefit-grid text-left"><article class="india-benefit-card"><h3>Physical benefits</h3><ul class="india-check-list"><li>Supports flexibility and mobility</li><li>Helps develop functional strength</li><li>Encourages body awareness</li><li>Supports balance and coordination</li></ul></article><article class="india-benefit-card"><h3>Mental & lifestyle benefits</h3><ul class="india-check-list"><li>Creates time for relaxation</li><li>Supports everyday stress management</li><li>Encourages conscious breathing</li><li>Promotes mindfulness</li></ul></article><article class="india-benefit-card"><h3>The power of consistency</h3><p style="color:rgba(255,255,255,.84);line-height:1.75">You do not need hours of practice every day. Finding a realistic routine you can maintain is the most important step towards a long-term yoga practice.</p></article></div></div></section>

  <section><div class="india-shell text-center india-reveal"><span class="india-eyebrow">Simple to begin</span><h2>Start Your Yoga Journey in 3 Simple Steps</h2><div class="india-steps text-left"><article class="india-step"><span class="india-step-number">1</span><h3>Share your requirements</h3><p>Tell us about your experience, preferred schedule, lifestyle and what you want from your practice.</p></article><article class="india-step"><span class="india-step-number">2</span><h3>Choose your format</h3><p>Explore a suitable option such as online yoga classes or personalized yoga sessions.</p></article><article class="india-step"><span class="india-step-number">3</span><h3>Start practicing</h3><p>Attend your sessions, follow instructor guidance and gradually build a consistent routine.</p></article></div><div class="india-actions"><a class="india-btn" href="{{ url('contact') }}">Start Your Yoga Journey</a></div></div></section>

  <section class="india-locations"><div class="india-shell text-center india-reveal"><span class="india-eyebrow">Across India</span><h2>Yoga Classes Across India</h2><p class="india-lead">Online and personalized sessions help make yoga more accessible across cities and regions. Explore availability in your area or join from home.</p><div class="india-city-cloud">@foreach($classicCities as $city)<span>{{ $city }}</span>@endforeach</div><div class="india-actions"><a class="india-btn india-btn-outline" href="{{ url('locate-us') }}">Find Yoga Classes in Your City</a><a class="india-btn" href="{{ url('contact') }}">Join Online Yoga Classes</a></div></div></section>

  <section><div class="india-shell text-center india-reveal"><span class="india-eyebrow">Flexible ways to practice</span><h2>Yoga Plans for Different Needs</h2><p class="india-lead">Choose a package based on your preferred schedule, class format and practice goals. Contact YogIntra for current pricing and availability.</p><div class="india-packages text-left"><article class="india-package"><h3>Trial Yoga Session</h3><p>A simple way to experience YogIntra before choosing a routine.</p><ul class="india-check-list"><li>Discuss your yoga goals</li><li>Understand the class format</li><li>Meet your instructor</li><li>Explore suitable options</li></ul><a class="india-btn india-btn-outline" href="{{ url('contact') }}">Book a Trial Session</a></article><article class="india-package is-featured"><h3>Monthly Yoga Plan</h3><p>Build consistency with regular instructor-guided yoga sessions.</p><ul class="india-check-list"><li>Scheduled yoga classes</li><li>Instructor guidance</li><li>Flexible session options</li><li>Suitable for regular practice</li></ul><a class="india-btn" href="{{ url('contact') }}">Explore Monthly Plans</a></article><article class="india-package"><h3>Personalized Yoga Plan</h3><p>Individual guidance shaped around your requirements.</p><ul class="india-check-list"><li>Goal-oriented practice</li><li>Flexible scheduling</li><li>Individual attention</li><li>Practice adapted to you</li></ul><a class="india-btn india-btn-outline" href="{{ url('contact') }}">Get a Personalized Plan</a></article></div></div></section>

  <section class="india-locations"><div class="india-shell text-center india-reveal"><span class="india-eyebrow">Questions answered</span><h2>Frequently Asked Questions About Yoga Classes in India</h2><div class="india-faq text-left"><details><summary>Does YogIntra offer yoga classes across India?</summary><p>YogIntra offers online and other available formats. Online sessions can help students in different parts of India practice remotely with an instructor.</p></details><details><summary>Are classes suitable for beginners?</summary><p>Yes. Beginners can start with foundational practices and gradually become familiar with poses, breathing, alignment and relaxation.</p></details><details><summary>Do I need to be flexible to start yoga?</summary><p>No. A suitable beginner practice can be adapted to your current level and comfort.</p></details><details><summary>What equipment do I need for online yoga?</summary><p>A yoga mat and enough comfortable space to move are generally useful. Your instructor can advise on any additional equipment for your sessions.</p></details><details><summary>How do I choose the right yoga class?</summary><p>Consider your experience level, goals, schedule, preferred class format and the type of guidance you want. YogIntra can help you identify an appropriate option.</p></details></div></div></section>

  <section class="india-final"><div class="india-shell india-reveal"><span class="india-eyebrow">Your next step</span><h2>Ready to Start Your Yoga Journey?</h2><p class="india-lead">Whether you are taking your first class or looking for a more consistent practice, YogIntra makes it easier to find yoga sessions that fit your lifestyle.</p><p style="margin:18px 0 0;color:#315e66;font-size:18px;font-weight:700">Practice from home. Learn with an instructor. Build a routine that works for you.</p><div class="india-actions"><a class="india-btn" href="{{ url('contact') }}">Book Your Yoga Session</a><a class="india-btn india-btn-outline" href="{{ url('private-online-yoga') }}">Explore Online Yoga Classes</a></div></div></section>
</main>

<script>
  (function () {
    var reveals = document.querySelectorAll('#classic-india-template .india-reveal');
    if (!('IntersectionObserver' in window)) { reveals.forEach(function (item) { item.classList.add('is-visible'); }); return; }
    var observer = new IntersectionObserver(function (entries) { entries.forEach(function (entry) { if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); } }); }, { threshold: .12 });
    reveals.forEach(function (item) { observer.observe(item); });
  }());
</script>
