@extends('layouts.layout')

@section('meta_title', 'Thank You')
@section('meta_description', '')
@section('meta_keywords', '')

@section('content')
<div class="main-content">
  <section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
    <div class="container pt-60 pb-60">
      <div class="section-content">
        <div class="row">
          <div class="col-md-12 text-center">
            <h2 class="title">Thank You</h2>
            <ol class="breadcrumb text-center text-black mt-10">
              <li><a href="{{ url('/') }}">Home</a></li>
              <li class="active text-theme-colored">Thank You</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="thank-you-container text-center">
            <span class="glyphicon glyphicon-ok thank-you-icon"></span>
            <h2>Thank You!</h2>
            <p>Your request has been received.</p>
            <p>We will Contact You Shortly.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('styles')
<style>
  .thank-you-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 40px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-top: 50px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  }

  .thank-you-icon {
    font-size: 48px;
    color: #5cb85c;
  }
</style>
@endpush
