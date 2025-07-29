@extends('layouts.layout')

@section('meta_title', $trainer['name'] . ' - Personal Yoga Trainer')
@section('meta_description', 'Meet ' . $trainer['name'] . ', a certified personal yoga trainer in ' . $trainer['city'] . ', ' . $trainer['state'] . '. Learn about their experience, education, and available yoga packages.')
@section('meta_keywords', $trainer['name'] . ', yoga trainer, personal yoga instructor, yoga trainer in ' . $trainer['city'])
@section('og_image', $api . '/' . $trainer['profile_image'])

@section('content')
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg8.jpg') }}'); height: 300px;">
  <div class="container pt-60 pb-60">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="title text-white">Trainer Profile</h2>
          <ol class="breadcrumb text-center mt-10">
            <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
            <li><a class="text-white" href="{{ url('/trainers') }}">Trainers</a></li>
            <li class="active text-gray">{{ $trainer['name'] }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="trainer-profile py-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-4 text-center mb-4">
        <img src="{{ $api }}/{{ $trainer['profile_image'] }}" alt="{{ $trainer['name'] }}" class="img-fluid rounded shadow" style="max-height: 350px; object-fit: cover;">
      </div>
      <div class="col-md-8">
        <h2 class="mb-3"><i class="fa fa-user text-primary"></i> {{ $trainer['name'] }}</h2>
        <p><i class="fa fa-birthday-cake text-info"></i> <strong>Age:</strong> {{ $age }} years</p>
        <p><i class="fa fa-graduation-cap text-warning"></i> <strong>Education:</strong> {{ strtolower($trainer['Education']) }}</p>
        <p><i class="fa fa-briefcase text-success"></i> <strong>Experience:</strong> {{ $trainer['experience'] }}</p>
        <p><i class="fa fa-map-marker text-danger"></i> <strong>Location:</strong> {{ $trainer['city'] }}, {{ $trainer['state'] }}</p>
        <p><i class="fa fa-money text-purple"></i> <strong>Package:</strong> {{ $trainer['package'] }}</p>

        <a href="{{ url('/contact') }}" class="btn btn-primary mt-4">
          <i class="fa fa-calendar-check-o"></i> Book a Session
        </a>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
  .trainer-profile h2 {
    font-size: 32px;
    margin-bottom: 20px;
  }
  .trainer-profile p {
    font-size: 16px;
    margin-bottom: 10px;
  }
  .fa {
    margin-right: 8px;
  }
  .text-purple {
    color: #6f42c1;
  }
</style>
@endpush
