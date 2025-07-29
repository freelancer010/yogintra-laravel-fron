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
        <div class="team-members text-center maxwidth400">
          <div class="team-thumb">
            <img class="img-fullwidth" id="imageresource_{{ $i }}" style="height: 200px; width: auto" alt="YogIntra" src="{{ $api }}/{{ $trainer['profile_image'] }}">
          </div>
          <div class="team-details">
            <div class="p-10" style="background-color: #01AEB7;">
              <h4 class="team-title text-uppercase mt-0 mb-0">
                <a href="{{ route('trainer.show', $trainer['id']) }}"> {{ $trainer['name'] }} </a>
              </h4>
              <p class="team-subtitle mt-0 mb-0">Age - {{ $age }}</p>
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
