@extends('layouts.layout')

@section('meta_title', 'Editorial Policy | YogIntra')
@section('meta_description', 'Learn how YogIntra reviews yoga and wellness content for accuracy, clarity, and responsible guidance.')
@section('meta_author', 'YogIntra Editorial Team')

@section('content')
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image:url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position:50% 45px; height:300px;">
  <div class="container pt-60 pb-60"><div class="section-content"><div class="row"><div class="col-md-12 text-center">
    <h1 class="title text-white">Editorial Policy</h1>
    <ol class="breadcrumb text-center mt-10"><li class="text-white"><a class="text-white" href="{{ url('/') }}">Home</a></li><li class="active text-gray">Editorial Policy</li></ol>
  </div></div></div></div>
</section>
<section><div class="container pt-60 pb-60"><div class="row"><article class="col-md-10 col-md-offset-1">
  <h2>How YogIntra creates wellness content</h2>
  <p><strong>Last reviewed: September 20, 2026.</strong> YogIntra publishes yoga, meditation, movement, and wellness information to help visitors make informed choices about our services.</p>
  <h3>Expertise and review</h3>
  <p>Our content is prepared or reviewed with input from experienced yoga instructors and our service team. We aim to describe practices, programmes, and classes clearly, accurately, and in language that is useful to students.</p>
  <h3>Editorial standards</h3>
  <ul>
    <li>We review content for accuracy, clarity, and relevance before publication.</li>
    <li>We update material when services, schedules, policies, or important information change.</li>
    <li>We distinguish general wellness education from personalised medical or therapeutic advice.</li>
    <li>We correct material errors when they are identified.</li>
  </ul>
  <h3>Wellness disclaimer</h3>
  <p>Yoga and wellness information on this website is for general educational purposes only. It is not medical advice, diagnosis, or treatment. Please consult a qualified healthcare professional before beginning a new exercise practice if you have an injury, medical condition, concerns about pregnancy, or any other health consideration.</p>
  <h3>Contact</h3>
  <p>If you have a question or notice content that needs attention, please <a href="{{ url('/contact') }}">contact YogIntra</a>.</p>
</article></div></div></section>
@endsection
