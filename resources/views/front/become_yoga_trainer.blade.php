@extends('layouts.layout')

@section('meta_title', 'Yoga Teacher Jobs and Vacancies')
@section('meta_description', 'As YogIntra is one of the best Yoga Platforms, we are offering an opportunity to be a part of our organization.')
@section('meta_keywords', 'Yoga Teacher Training Jobs and Vacancies, Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai, Yoga Teacher Training Courses.')

@section('content')
<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
  <div class="container pt-60 pb-60">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 text-center">
          <h2 class="title text-white">Recruitment</h2>
          <ol class="breadcrumb text-center mt-10">
            <li><a class="text-white" href="{{ url('/') }}">Home</a></li>
            <li class="active text-gray">Recruitment</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section: Become a Trainer Form -->
<section style="background-image: url('{{ asset('assets/front/images/pattern/p4.png') }}');">
  <div class="container">
    <div class="section-title text-center">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="section-3-title">
            <span class="">Become A Trainer</span>
          </div>
          <p>As YogIntra is one of the best Yoga Platform, we are offering a chance to be a part of our organization. You can show your interest by filling the form and Our Team will contact you after analyzing your eligibility.</p>
        </div>
      </div>
    </div>
      <div class="section-content">
        <div class="row">
          <div class="col-md-5">
            <img src="{{ asset('assets/coming_soon.webp') }}">
          </div>
          <div class="col-md-7">
            <form id="multi-step-form" name="contact_form" class="contact-form-transparent" method="POST" action="{{ route('trainer.submit') }}">
              @csrf
              <!-- Step 1 -->
              <div class="form-step active" id="step-1">
                <div class="form-group">
                  <label for="name">Your Name:</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number:</label>
                  <input type="text" class="form-control" id="phone" name="number" required>
                </div>
                <div class="form-group">
                  <label for="email">Email ID:</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                  <label for="dob">Date of Birth:</label>
                  <input type="date" class="form-control" id="dob" name="dob" required>
                </div>
                <button class="btn btn-primary next" type="button">Next</button>
              </div>

              <!-- Step 2 -->
              <div class="form-step" id="step-2">
                <div class="form-group">
                  <label for="certification">University of Certification:</label>
                  <input type="text" class="form-control" id="certification" name="education" required>
                </div>
                <div class="form-group">
                  <label for="year_certification">Year Of Certification:</label>
                  <input type="text" class="form-control" id="year_certification" name="certification" required>
                </div>
                <div class="form-group">
                  <label for="year_experience">Year Of Experience:</label>
                  <input type="number" class="form-control" id="year_experience" name="experience" required>
                </div>
                <div class="form-group">
                  <label for="youga_certificate">Other Yoga Certification (If Any):</label>
                  <textarea class="form-control" id="youga_certificate" name="Other_Certificate"></textarea>
                </div>
                <button class="btn btn-primary prev" type="button">Previous</button>
                <button class="btn btn-primary next" type="button">Next</button>
              </div>

              <!-- Step 3 -->
              <div class="form-step" id="step-3">
                <div class="form-group">
                  <label for="country">Select Country:</label>
                  <select class="form-control countries" id="country" name="country" required>
                    <option value="">Select A Country</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="state">Select State:</label>
                  <select class="form-control states" id="state" name="state" required>
                    <option value="">Select your Country First</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="city">Select City:</label>
                  <select class="form-control cities" id="city" name="city" required>
                    <option value="">Select your state first</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="address">Your Address:</label>
                  <textarea class="form-control" id="address" name="address" required></textarea>
                </div>
                <button class="btn btn-primary prev" type="button">Previous</button>
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('styles')
<style>
  .form-step { display: none; }
  .form-step.active { display: block; }
</style>
@endpush

@push('scripts')
<script src="https://geodata.phplift.net/api/index.js"></script>
<script>
$(document).ready(function () {
  var currentStep = 1;

  $('.next').click(function () {
    if (validateStep(currentStep)) {
      $('#step-' + currentStep).removeClass('active');
      currentStep++;
      $('#step-' + currentStep).addClass('active');
    }
  });

  $('.prev').click(function () {
    $('#step-' + currentStep).removeClass('active');
    currentStep--;
    $('#step-' + currentStep).addClass('active');
  });

  function validateStep(step) {
    let valid = true;
    $('#step-' + step + ' input[required], #step-' + step + ' select[required], #step-' + step + ' textarea[required]').each(function () {
      if (!$(this).val()) {
        $(this).addClass('is-invalid');
        valid = false;
      } else {
        $(this).removeClass('is-invalid');
      }
    });
    return valid;
  }

  // Country -> State -> City chaining
  $.get('https://geodata.phplift.net/api/index.php?type=getCountries', function (data) {
    $.each(data.result, function (i, val) {
      $('#country').append(`<option value="${val.name}" countryid="${val.id}">${val.name}</option>`);
    });
  });

  $('#country').change(function () {
    let countryId = $('#country option:selected').attr('countryid');
    $('#state').html('<option>Please wait...</option>');
    $.get(`https://geodata.phplift.net/api/index.php?type=getStates&countryId=${countryId}`, function (data) {
      $('#state').html('<option value="">Select State</option>');
      $.each(data.result, function (i, val) {
        $('#state').append(`<option value="${val.name}" stateid="${val.id}">${val.name}</option>`);
      });
    });
  });

  $('#state').change(function () {
    let stateId = $('#state option:selected').attr('stateid');
    $('#city').html('<option>Please wait...</option>');
    $.get(`https://geodata.phplift.net/api/index.php?type=getCities&stateId=${stateId}`, function (data) {
      $('#city').html('<option value="">Select City</option>');
      $.each(data.result, function (i, val) {
        $('#city').append(`<option value="${val.name}">${val.name}</option>`);
      });
    });
  });

  // AJAX form submit
  $('#multi-step-form').submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: '{{ route('trainer.submit') }}',
      type: 'POST',
      data: $(this).serialize(),
      success: function (response) {
        if (response.success) {
          window.location.href = '{{ url('thank_you') }}';
        } else {
          alert('Submission failed, please try again.');
        }
      },
      error: function () {
        alert('Something went wrong.');
      }
    });
  });
});
</script>
@endpush
