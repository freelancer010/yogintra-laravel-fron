@extends('layouts.layout')

@section('meta_title', 'Enquiry - YogIntra')
@section('meta_description', 'Transform your mind and body with YogIntra, the leading Yoga Institute in India. Contact us for online classes and personalized home visits.')
@section('meta_keywords', 'Contact Form, Enquiry, Online Yoga Classes India, Yoga Class in India, Best Yoga Institute In India, Best Yoga Center in India, Personal Yoga Trainer at Home, Best Yoga Classes in Mumbai, Yoga Teacher Training Courses.')
@section('meta_author', 'YogIntra')

@section('content')
<!-- Additional Styles for Embedded Form -->
<style>
    body { 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }
    .has-error input,
    .has-error select,
    .has-error textarea {
        border-color: #dc3545 !important;
    }
    .form-group {
        margin-bottom: 16px;
        position: relative;
    }
    .embedded-form {
        max-width: 600px;
        width: 100%;
        margin: 0 auto;
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    ::placeholder {
        color: #999;
        opacity: 1;
        font-size: 14px;
    }
    .form-control:focus {
        border-color: #ffce00;
        box-shadow: 0 0 0 2px rgba(255, 206, 0, 0.2);
    }
    .embedded-form .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        transition: all 0.2s ease-in-out;
        font-size: 14px;
        height: 40px;
    }
    .embedded-form .form-control:focus {
        border-color: #2563eb;
        outline: 0;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
    }
    .embedded-form label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
        font-size: 14px;
        display: block;
    }
    .btn {
        padding: 8px 20px;
        font-weight: 600;
        border-radius: 4px;
        transition: all 0.2s ease-in-out;
        font-size: 14px;
        height: 40px;
        line-height: 24px;
    }
    .btn-primary {
        background: #ffce00;
        border-color: #ffce00;
        color: #000;
    }
    .btn-primary:hover {
        background: #f5c400;
        border-color: #f5c400;
        color: #000;
    }
    .btn-secondary {
        background: #6b7280;
        border-color: #6b7280;
        color: white;
    }
    .btn-success {
        background: #059669;
        border-color: #059669;
        color: white;
    }
    .btn-success:hover {
        background: #047857;
        border-color: #047857;
    }
    .form-heading {
        text-align: center;
        margin-bottom: 2rem;
        color: #111827;
        font-size: 1.5rem;
        font-weight: 600;
    }
    /* Step Indicators */
    .step-indicators {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }
    .step-indicators::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e5e7eb;
        z-index: 1;
    }
    .step {
        position: relative;
        z-index: 2;
        background: white;
        padding: 0 15px;
    }
    .step-number {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e5e7eb;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    .step.active .step-number {
        background: #2563eb;
        color: white;
    }
    .step.completed .step-number {
        background: #059669;
        color: white;
    }
    .step-label {
        font-size: 0.875rem;
        color: #6b7280;
        text-align: center;
    }
    .step.active .step-label {
        color: #2563eb;
        font-weight: 500;
    }
    .step.completed .step-label {
        color: #059669;
    }
    /* Progress Animation */
    .form-step {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
    .form-step.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Success Message Styles */
    .success-message-container {
        display: none;
        position: relative;
        width: 100%;
        padding: 30px;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .success-message-box {
        text-align: center;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 500px;
    }

    .success-checkmark {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        position: relative;
    }

    .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4CAF50;
    }

    .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }

    .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }

    .check-icon::before, .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: #fff;
        transform: rotate(-45deg);
    }

    .icon-line {
        height: 5px;
        background-color: #4CAF50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }

    .icon-line.line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }

    .icon-line.line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }

    .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid #50b268;
    }

    .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: #fff;
    }

    @keyframes rotate-circle {
        0% { transform: rotate(-45deg); }
        5% { transform: rotate(-45deg); }
        12% { transform: rotate(-405deg); }
        100% { transform: rotate(-405deg); }
    }

    @keyframes icon-line-tip {
        0% { width: 0; left: 1px; top: 19px; }
        54% { width: 0; left: 1px; top: 19px; }
        70% { width: 50px; left: -8px; top: 37px; }
        84% { width: 17px; left: 21px; top: 48px; }
        100% { width: 25px; left: 14px; top: 46px; }
    }

    @keyframes icon-line-long {
        0% { width: 0; right: 46px; top: 54px; }
        65% { width: 0; right: 46px; top: 54px; }
        84% { width: 55px; right: 0px; top: 35px; }
        100% { width: 47px; right: 8px; top: 38px; }
    }

    .success-title {
        color: #333;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .success-text {
        color: #666;
        font-size: 16px;
        line-height: 1.5;
        margin: 0;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .embedded-form {
            padding: 20px;
            margin: 10px;
        }
        .step-label {
            font-size: 0.75rem;
        }
        .btn {
            width: 100%;
            margin: 5px 0;
        }
        .d-flex {
            flex-direction: column;
        }
        .success-message-container {
            padding: 15px;
        }
        .success-message-box {
            padding: 20px;
        }
        .success-checkmark {
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
        }
        .success-title {
            font-size: 20px;
        }
        .success-text {
            font-size: 14px;
        }
    }
</style>

<!-- Section: inner-header -->
<section class="inner-header divider parallax layer-overlay overlay-dark-7" style="background-image: url('{{ asset('assets/front/images/bg/bg6.jpg') }}'); background-position: 50% 45px; height: 300px;">
  <div class="container pt-60 pb-60">
    <div class="section-content">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1 class="title text-white">Enquire Yogintra</h1>
          <ol class="breadcrumb text-center mt-10">
            <li class="text-white"><a class="text-white" href="{{ url('/') }}">Home</a></li>
            <li class="active text-gray">Contact</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section: Contact Form -->
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="">
            <h4 class="form-heading" style="color: #6c1c45; font-size: 28px; font-weight: 700; margin-bottom: 20px;">Enquire Now</h4>
            @php
                // Ensure source is set properly for embedded form
                $formSource = $source ?? request('source', 'Embedded Form');
            @endphp
            <x-multi-step-form :source="$formSource" />
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    $(document).ready(function() {
        // Initialize form validation flags
        let stepValidation = {
            1: false,
            2: false,
            3: false
        };

        // Handle live validation on input
        $('.form-control').on('input blur', function() {
            const $field = $(this);
            const step = $field.closest('.form-step').data('step');
            validateField($field);
            updateStepValidation(step);
        });

        // Field validation function
        function validateField($field) {
            const fieldId = $field.attr('id');
            const value = $field.val();
            let isValid = true;
            let errorMessage = '';

            const $formGroup = $field.closest('.form-group');
            $formGroup.removeClass('has-error');
            $formGroup.find('.error-message').remove();

            switch(fieldId) {
                case 'name':
                    if (!value.trim()) {
                        isValid = false;
                        errorMessage = 'Please enter your name';
                    }
                    break;
                case 'phone':
                    if (!value || !/^\d{8,15}$/.test(value)) {
                        isValid = false;
                        errorMessage = 'Enter a valid phone number (8-15 digits)';
                    }
                    break;
                case 'email':
                    if (!value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        isValid = false;
                        errorMessage = 'Enter a valid email address';
                    }
                    break;
                case 'country':
                case 'state':
                case 'city':
                    if (!value.trim()) {
                        isValid = false;
                        errorMessage = 'This field is required';
                    }
                    break;
                case 'message':
                    if (!value.trim()) {
                        isValid = false;
                        errorMessage = 'Please enter your message';
                    }
                    break;
            }

            if (!isValid) {
                $formGroup.addClass('has-error')
                    .append(`<span class="error-message">${errorMessage}</span>`);
            }

            return isValid;
        }

        // Update step validation status
        function updateStepValidation(step) {
            const $step = $(`.form-step[data-step="${step}"]`);
            const $fields = $step.find('.form-control');
            stepValidation[step] = Array.from($fields).every(field => validateField($(field)));
        }

        // Handle step navigation
        function goToStep(step) {
            // Debug log
            console.log('Going to step:', step);
            
            // Hide all steps and show the current one
            $('.form-step').removeClass('active').hide();
            $(`.form-step[data-step="${step}"]`).addClass('active').fadeIn(300);
            
            // Update step indicators if they exist
            $('.step').each(function(index) {
                const stepNum = index + 1;
                $(this).removeClass('active completed');
                if (stepNum < step) {
                    $(this).addClass('completed');
                } else if (stepNum === step) {
                    $(this).addClass('active');
                }
            });

            // Update progress bar if it exists
            const progress = ((step - 1) / 2) * 100;
            $('.progress-bar').css('width', `${progress}%`);

            // Scroll to top of form
            $('.embedded-form').animate({
                scrollTop: 0
            }, 300);
        }

        // Next button click handler
        $(document).on('click', '.next-step', function() {
            const currentStep = $(this).closest('.form-step').data('step');
            console.log('Current step:', currentStep); // Debug log
            
            if (validateCurrentStep(currentStep)) {
                goToStep(currentStep + 1);
            }
        });

        // Previous button click handler
        $(document).on('click', '.prev-step', function() {
            const currentStep = $(this).closest('.form-step').data('step');
            console.log('Going back from step:', currentStep); // Debug log
            
            goToStep(currentStep - 1);
        });

        // Validate current step
        function validateCurrentStep(step) {
            const $step = $(`.form-step[data-step="${step}"]`);
            const $fields = $step.find('.form-control');
            let isValid = true;

            $fields.each(function() {
                if (!validateField($(this))) {
                    isValid = false;
                }
            });

            return isValid;
        }

        // Form submission handler
        $('#multi-step-form').on('submit', function(e) {
            e.preventDefault();
            
            if (!validateCurrentStep(3)) {
                return false;
            }

            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...');

            // Get form data and ensure form_type is set to 'embed'
            const formData = new FormData($form[0]);
            formData.set('form_type', 'embed'); // Force form_type to be 'embed'
            
            const formDataObj = {};
            formData.forEach((value, key) => {
                formDataObj[key] = value;
            });
            
            // Log the data for debugging
            console.log('Form Data:', formDataObj);
            
            $.ajax({
                url: "{{ route('form.submit') }}",
                method: 'POST',
                data: $form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Hide form and show success message
                    const $form = $('.embedded-form');
                    $form.fadeOut(300, function() {
                        // Reset form
                        $('#multi-step-form')[0].reset();
                        goToStep(1);
                        // Show success message with animation
                        $('.success-message-container').fadeIn(300).css('display', 'flex');
                        // After 3 seconds, hide success message and show form
                        setTimeout(function() {
                            $('.success-message-container').fadeOut(300, function() {
                                $form.fadeIn(300);
                                $submitBtn.prop('disabled', false).text('Submit Enquiry');
                            });
                        }, 3000);
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred. Please try again.');
                    $submitBtn.prop('disabled', false).text('Submit Enquiry');
                }
            });
        });

        // Only allow numbers in phone field
        $('#phone').on('keypress', function(e) {
            return e.charCode >= 48 && e.charCode <= 57;
        });

        // Auto-uppercase for inputs except email
        $('input:not(#email)').on('input', function() {
            this.value = this.value.toUpperCase();
        });
    });
</script>
@endsection
