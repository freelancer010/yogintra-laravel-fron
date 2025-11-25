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
          <h1 class="title text-white">Recruitment</h1>
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
            <h2 class="fs-50">Become A Trainer</h2>
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
            <!-- Step Progress Indicators -->
            <div class="step-progress">
              <ul class="step-indicators">
                <li class="step active" data-step="1">Personal Info</li>
                <li class="step" data-step="2">Education</li>
                <li class="step" data-step="3">Location</li>
              </ul>
              <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

            <form id="multi-step-form" name="contact_form" class="contact-form-transparent" method="POST" action="{{ route('trainer.submit') }}">
              @csrf
              <!-- Step 1 -->
              <div class="form-step active" id="step-1">
                <h4 class="mb-4">Personal Information</h4>
                <div class="form-group">
                  <label for="name">Your Name: <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" required>
                  <div class="invalid-feedback">Please enter your full name.</div>
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number: <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="phone" name="number" required pattern="[0-9]{10,15}">
                  <div class="invalid-feedback">Please enter a valid phone number (10-15 digits).</div>
                </div>
                <div class="form-group">
                  <label for="email">Email ID: <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="email" name="email" required>
                  <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="form-group">
                  <label for="dob">Date of Birth: <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="dob" name="dob" required>
                  <div class="invalid-feedback">Please select your date of birth.</div>
                </div>
                <div class="text-right">
                  <button class="btn btn-primary next" type="button" disabled>Next</button>
                </div>
              </div>

              <!-- Step 2 -->
              <div class="form-step" id="step-2">
                <h4 class="mb-4">Education & Experience</h4>
                <div class="form-group">
                  <label for="certification">University of Certification: <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="certification" name="education" required>
                  <div class="invalid-feedback">Please enter your university/institution name.</div>
                </div>
                <div class="form-group">
                  <label for="year_certification">Year Of Certification: <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="year_certification" name="certification" required min="1950" max="2025">
                  <div class="invalid-feedback">Please enter a valid certification year.</div>
                </div>
                <div class="form-group">
                  <label for="year_experience">Years Of Experience: <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="year_experience" name="experience" required min="0" max="50">
                  <div class="invalid-feedback">Please enter your years of experience.</div>
                </div>
                <div class="form-group">
                  <label for="youga_certificate">Other Yoga Certification (If Any):</label>
                  <textarea class="form-control" id="youga_certificate" name="Other_Certificate" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-between">
                  <button class="btn btn-secondary prev" type="button">Previous</button>
                  <button class="btn btn-primary next" type="button" disabled>Next</button>
                </div>
              </div>

              <!-- Step 3 -->
              <div class="form-step" id="step-3">
                <h4 class="mb-4">Location Details</h4>
                <div class="form-group">
                  <label for="country">Country: <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="country" name="country" required placeholder="Country">
                  <div class="invalid-feedback">Please enter your country.</div>
                </div>
                <div class="form-group">
                  <label for="state">State: <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="state" name="state" required placeholder="State">
                  <div class="invalid-feedback">Please enter your state.</div>
                </div>
                <div class="form-group">
                  <label for="city">City: <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="city" name="city" required placeholder="City">
                  <div class="invalid-feedback">Please enter your city.</div>
                </div>
                <div class="form-group">
                  <label for="address">Your Address: <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="address" name="address" required rows="3"></textarea>
                  <div class="invalid-feedback">Please enter your complete address.</div>
                </div>
                <div class="d-flex justify-content-between">
                  <button class="btn btn-secondary prev" type="button">Previous</button>
                  <button type="submit" class="btn btn-success submit-btn" disabled>Submit Application</button>
                </div>
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
  .form-step { 
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
  }
  .form-step.active { 
    display: block;
    opacity: 1;
  }
  
  .form-control.is-invalid {
    border-color: #dc3545;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
  }
  
  .form-control.is-valid {
    border-color: #28a745;
    padding-right: calc(1.5em + 0.75rem);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.8-.77L4.25 5l.89-.89-1.42-1.42L2.9 3.5l-.6.72-1.4-1.42L0 3.64l2.3 2.3z'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
  }
  
  .invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
  }

  /* Visual uppercase only for name, country, state, city inputs */
  #name, #country, #state, #city {
    text-transform: uppercase;
  }
  
  .form-control.is-invalid + .invalid-feedback {
    display: block;
  }
  
  .btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
  
  .step-progress {
    margin-bottom: 30px;
  }
  
  .step-progress .progress {
    height: 4px;
    background-color: #e9ecef;
  }
  
  .step-progress .progress-bar {
    background-color: #f5a742;
    transition: width 0.3s ease;
  }
  
  .step-indicators {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 0;
    list-style: none;
  }
  
  .step-indicators .step {
    flex: 1;
    text-align: center;
    position: relative;
    color: #6c757d;
    font-size: 14px;
    font-weight: 500;
  }
  
  .step-indicators .step.active {
    color: #f5a742;
  }
  
  .step-indicators .step.completed {
    color: #28a745;
  }
  
  .step-indicators .step::before {
    content: '';
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #e9ecef;
  }
  
  .step-indicators .step.active::before {
    background-color: #f5a742;
  }
  
  .step-indicators .step.completed::before {
    background-color: #28a745;
  }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
  let currentStep = 1;
  const totalSteps = 3;

  // Initialize form
  initializeForm();

  // Real-time validation for all inputs
  $(document).on('input change', 'input, textarea', function() {
    validateField($(this));
    updateNextButtonState();
  });

  // Next button click
  $('.next').click(function () {
    if (validateCurrentStep()) {
      goToNextStep();
    }
  });

  // Previous button click
  $('.prev').click(function () {
    goToPreviousStep();
  });

  // Initialize form setup
  function initializeForm() {
    updateStepIndicators();
    updateNextButtonState();
    
    // Set max date for DOB (18 years ago)
    const eighteenYearsAgo = new Date();
    eighteenYearsAgo.setFullYear(eighteenYearsAgo.getFullYear() - 18);
    $('#dob').attr('max', eighteenYearsAgo.toISOString().split('T')[0]);

    // Transform to uppercase only for name, country, state, city inputs (on input and keyup)
    function transformToUppercaseElement(el) {
      const caret = el.selectionStart;
      const val = $(el).val();
      const newVal = val.toUpperCase();
      $(el).val(newVal);
      try { el.setSelectionRange(caret, caret); } catch (e) {}
    }

    // Apply on both input and keyup so uppercase transformation happens as user types
    $(document).on('input keyup', '#name, #country, #state, #city', function() {
      transformToUppercaseElement(this);
    });

    // Phone number formatting (keep only digits)
    $('#phone').on('input', function() {
      let value = $(this).val().replace(/\D/g, '');
      $(this).val(value);
    });
  }

  // Validate individual field
  function validateField($field) {
    const value = $field.val().trim();
    const fieldType = $field.attr('type');
    const fieldName = $field.attr('name');
    let isValid = true;

    // Remove previous validation classes
    $field.removeClass('is-valid is-invalid');

    if ($field.prop('required') && !value) {
      isValid = false;
    } else if (value) {
      // Specific validation rules
      switch (fieldType) {
        case 'email':
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          isValid = emailRegex.test(value);
          break;
        case 'text':
          if (fieldName === 'number') {
            const phoneRegex = /^[0-9]{10,15}$/;
            isValid = phoneRegex.test(value.replace(/\D/g, ''));
          } else if (fieldName === 'name') {
            isValid = value.length >= 2 && /^[a-zA-Z\s]+$/.test(value);
          }
          break;
        case 'number':
          const numValue = parseInt(value);
          if (fieldName === 'certification') {
            isValid = numValue >= 1950 && numValue <= 2025;
          } else if (fieldName === 'experience') {
            isValid = numValue >= 0 && numValue <= 50;
          }
          break;
        case 'date':
          if (fieldName === 'dob') {
            const birthDate = new Date(value);
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            isValid = age >= 18 && age <= 80;
          }
          break;
      }
    }

    // Apply validation classes
    if ($field.prop('required') || value) {
      $field.addClass(isValid ? 'is-valid' : 'is-invalid');
    }

    return isValid;
  }

  // Validate current step
  function validateCurrentStep() {
    let isValid = true;
    const currentStepElement = $('#step-' + currentStep);
    
    currentStepElement.find('input[required], textarea[required]').each(function() {
      if (!validateField($(this))) {
        isValid = false;
      }
    });

    return isValid;
  }

  // Update next button state
  function updateNextButtonState() {
    const currentStepElement = $('#step-' + currentStep);
    let allValid = true;

    currentStepElement.find('input[required], textarea[required]').each(function() {
      const $field = $(this);
      if (!$field.val().trim() || $field.hasClass('is-invalid')) {
        allValid = false;
        return false;
      }
    });

    if (currentStep < totalSteps) {
      currentStepElement.find('.next').prop('disabled', !allValid);
    } else {
      currentStepElement.find('.submit-btn').prop('disabled', !allValid);
    }
  }

  // Go to next step
  function goToNextStep() {
    if (currentStep < totalSteps) {
      $('#step-' + currentStep).removeClass('active');
      currentStep++;
      $('#step-' + currentStep).addClass('active');
      updateStepIndicators();
      updateProgressBar();
      updateNextButtonState();
    }
  }

  // Go to previous step
  function goToPreviousStep() {
    if (currentStep > 1) {
      $('#step-' + currentStep).removeClass('active');
      currentStep--;
      $('#step-' + currentStep).addClass('active');
      updateStepIndicators();
      updateProgressBar();
      updateNextButtonState();
    }
  }

  // Update step indicators
  function updateStepIndicators() {
    $('.step-indicators .step').each(function(index) {
      const stepNum = index + 1;
      $(this).removeClass('active completed');
      
      if (stepNum < currentStep) {
        $(this).addClass('completed');
      } else if (stepNum === currentStep) {
        $(this).addClass('active');
      }
    });
  }

  // Update progress bar
  function updateProgressBar() {
    const progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
    $('.progress-bar').css('width', progressPercentage + '%').attr('aria-valuenow', progressPercentage);
  }

  // Form submission
  $('#multi-step-form').submit(function (e) {
    e.preventDefault();
    
    if (!validateCurrentStep()) {
      return false;
    }

    // Disable submit button and show loading
    $('.submit-btn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');

    $.ajax({
      url: '{{ route('trainer.submit') }}',
      type: 'POST',
      data: $(this).serialize(),
      success: function (response) {
        if (response.success) {
          // Show success message
          $('#multi-step-form').html(`
            <div class="alert alert-success text-center">
              <h4><i class="fa fa-check-circle"></i> Application Submitted Successfully!</h4>
              <p>Thank you for your interest in joining YogIntra. Our team will review your application and contact you soon.</p>
              <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
            </div>
          `);
        } else {
          throw new Error('Submission failed');
        }
      },
      error: function (xhr) {
        let errorMessage = 'Something went wrong. Please try again.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }
        
        alert(errorMessage);
        $('.submit-btn').prop('disabled', false).html('Submit Application');
      }
    });
  });
});
</script>
@endpush
