@extends('layouts.layout')

@section('meta_title', 'Best Yoga Trainers in India')
@section('meta_description', "Amit Pandey is an amazing yoga teacher! The classes are very diverse, each session is a unique experience. he is the Best Yoga Trainer in India.")
@section('meta_keywords', 'Best Yoga Trainer in India, Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai.')

@section('content')
@php
  $currentYear = date('Y');
@endphp
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg8.jpg') }}'); background-position: 50% 55px; height: 300px;">
  <div class="container pt-60 pb-60">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1 class="title text-white">PERSONAL YOGA TRAINERS</h1>
          <ol class="breadcrumb text-center mt-10">
            <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
            <li class="active text-gray">PERSONAL YOGA TRAINERS</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section: Team -->
<section class="bg-lighter">
  <div class="container pt-1">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="form-group">
          <input onkeyup="get_data(this.value)" placeholder="{{ strtoupper('Search Your Trainer By Name or Location ...') }}" type="text" class="form-control" id="name" name="name" required>
        </div>
      </div>
    </div>
    <div class="row mtli-row-clearfix" id="content_data">
      @foreach ($all_trainer as $i => $trainer)
      @php
        $birthYear = date('Y', strtotime($trainer['dob']));
        $age = $currentYear - $birthYear;
      @endphp
      <div class="col-xs-12 col-sm-6 col-md-3 sm-text-center mb-30 mb-sm-30">
        <div class="team-members text-center maxwidth400" onclick="window.location.href='{{ route('trainer.show', $trainer['id']) }}'" style="cursor: pointer;">
          <div class="team-thumb">
            <img class="img-fullwidth" id="imageresource_{{ $i }}" style="height: 200px; width: auto" alt="YogIntra" src="{{ $api }}/{{ $trainer['profile_image'] }}">
          </div>
          <div class="team-details">
            <div class="p-10" style="background-color: #01AEB7;">
              <h4 class="team-title text-uppercase mt-0 mb-0">
                <span style="color: white;">{{ $trainer['name'] }}</span>
              </h4>
              <p class="team-subtitle mt-0 mb-0"><i class="fa fa-map-marker"></i> {{ $trainer['city'] }}, {{ $trainer['state'] }}</p>
            </div>
            <div class="p-20 bg-white d-none">
              <input type="hidden" value="{{ $trainer['Education'] }}" id="Education_{{ $i }}">
              <input type="hidden" value="{{ $trainer['experience'] }}" id="experience_{{ $i }}">
              <input type="hidden" value="{{ $trainer['city'] }}, {{ $trainer['state'] }}" id="address_{{ $i }}">
              <input type="hidden" value="{{ $trainer['name'] }}" id="name_{{ $i }}">
              <input type="hidden" value="{{ $age }}" id="age_{{ $i }}">
              <input type="hidden" value="{{ $trainer['package'] }}" id="package_{{ $i }}">
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body text-center p-0">
        <div id="imagepreview"><div style="height: 60vh;"></div></div>
        <div class="p-20 pb-10 pt-10">
          <h3><b id="main_name"></b></h3>
          <h5><b>Age </b> - <span id="age"></span></h5>
          <h6><b>Education </b> - <span id="education"></span></h6>
          <h6><b>Experience </b> - <span id="experience"></span></h6>
          <h5><b>Package </b> - <span id="package"></span></h5>
        </div>
      </div>
      <div class="modal-footer text-center" style="background: #dcd8d8; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px;">
        <h3 class="pt-1 pb-0 text-center">
          <i class="fa fa-map-marker" aria-hidden="true"></i> <span id="address"></span>
        </h3>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  /* Trainer Card Animations */
  .team-members {
    transition: all 0.3s ease;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
  }

  .team-members:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
  }

  .team-thumb {
    position: relative;
    overflow: hidden;
  }

  .team-thumb img {
    transition: transform 0.3s ease;
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .team-members:hover .team-thumb img {
    transform: scale(1.1);
  }

  .team-details {
    transition: all 0.3s ease;
  }

  .team-details .p-10 {
    transition: background-color 0.3s ease;
  }

  .team-members:hover .team-details .p-10 {
    background-color: #009aa3 !important;
  }

  .team-title span {
    color: white;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .team-members:hover .team-title span {
    color: #f0f0f0;
  }

  .team-subtitle {
    color: rgba(255, 255, 255, 0.9);
  }

  /* Add a subtle glow effect */
  .team-members::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
    z-index: 1;
  }

  .team-members:hover::before {
    opacity: 1;
  }

  /* Animation for the entire card container */
  .col-xs-12.col-sm-6.col-md-3 {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
    transform: translateY(30px);
  }

  .col-xs-12.col-sm-6.col-md-3:nth-child(1) { animation-delay: 0.1s; }
  .col-xs-12.col-sm-6.col-md-3:nth-child(2) { animation-delay: 0.2s; }
  .col-xs-12.col-sm-6.col-md-3:nth-child(3) { animation-delay: 0.3s; }
  .col-xs-12.col-sm-6.col-md-3:nth-child(4) { animation-delay: 0.4s; }
  .col-xs-12.col-sm-6.col-md-3:nth-child(5) { animation-delay: 0.5s; }
  .col-xs-12.col-sm-6.col-md-3:nth-child(6) { animation-delay: 0.6s; }
  .col-xs-12.col-sm-6.col-md-3:nth-child(7) { animation-delay: 0.7s; }
  .col-xs-12.col-sm-6.col-md-3:nth-child(8) { animation-delay: 0.8s; }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .team-members:hover {
      transform: translateY(-5px);
    }
  }

  @media (min-width: 768px) {
    .modal-dialog {
      width: 400px;
      margin: 30px auto;
    }
  }
  #imagemodal {
    z-index: 9999;
  }
  .modal-backdrop {
    z-index: 9991;
  }
  #imagepreview {
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    padding: 0;
    text-align: center;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
  }
</style>
@endpush

@push('scripts')
<script>
  $(document).ready(function () {
    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    });

    // Function to open the modal and populate it with trainer data
    window.open_modal = function (id) {
      let imgSrc = $('#imageresource_' + id).attr('src');
      $('#imagepreview').css('background-image', 'url(' + imgSrc + ')');
      $('#imagemodal').modal('show');
      $('#main_name').html($('#name_' + id).val());
      $('#age').html($('#age_' + id).val());
      $('#address').html($('#address_' + id).val());
      $('#experience').html($('#experience_' + id).val());
      $('#education').html($('#Education_' + id).val());
      $('#package').html($('#package_' + id).val());
    };

    // Accessibility fix: remove aria-hidden when modal is shown
    $('#imagemodal').on('show.bs.modal', function () {
      $(this).removeAttr('aria-hidden');
    });

    // Accessibility fix: re-add aria-hidden when modal is hidden
    $('#imagemodal').on('hidden.bs.modal', function () {
      $(this).attr('aria-hidden', 'true');
    });

    // Function to fetch trainer data dynamically
    window.get_data = function (data) {
      $.ajax({
        type: "POST",
        url: "{{ url('get-data-for-trainer') }}",
        data: { data: data },
        success: function (response) {
          $('#content_data').html(response);
        }
      });
    };
  });
</script>
@endpush
