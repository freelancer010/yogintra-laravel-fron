@props(['source' => null])

@php
    use Illuminate\Support\Facades\DB;
    $all_service = DB::table('service_category')->get();
    
    // For this blade, always set form_type to embed
    $form_type = 'embed';
    
    // Debug log the form type
    \Log::debug('Form type in embed contact form:', ['form_type' => $form_type]);
@endphp

<form id="multi-step-form" class="booking-form {{ $form_type == 'landing' ? 'bg-black-333 p-30' : '' }} {{ $form_type == 'embed' ? 'embedded-form' : '' }}">
    @if ($form_type == 'landing')
        <h3 class="mt-0 text-white mb-20">Make An Appointment</h3>
    @endif
    @csrf
    <input type="hidden" name="form_type" value="{{ $form_type }}">
    {{-- Debug form type value --}}
    @php \Log::debug('Form type value in blade:', ['form_type' => $form_type]); @endphp
    {{-- Always include form type and source (if available) --}}
    @if($source)
        <input type="hidden" name="source" value="{{ $source }}">
    @endif
    
    <!-- Step 1: Personal Information -->
    <div class="form-step active" id="step-1" data-step="1">
        <div class="form-group">
            <label for="name">Your Name:</label>
            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name here...">
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="number" class="form-control" id="phone" name="number" required placeholder="Enter your number here...">
        </div>
        <div class="form-group">
            <label for="email">Email ID:</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email here...">
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-primary next-step">Next</button>
        </div>
    </div>

    <!-- Step 2: Location -->
    <div class="form-step" id="step-2" data-step="2">
        <div class="form-group">
            <label for="country">Select Country:</label>
            <input type="text" class="form-control countries" id="country" name="country" required placeholder="Enter your Country" />
        </div>
        <div class="form-group">
            <label for="state">Select State:</label>
            <input type="text" class="form-control states" id="state" name="state" required placeholder="Enter your State" />
        </div>
        <div class="form-group">
            <label for="city">Select City:</label>
            <input type="text" class="form-control cities" id="city" name="city" required placeholder="Enter your city" />
        </div>
        <div class="form-buttons d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-light prev-step">Back</button>
            <button type="button" class="btn btn-primary next-step">Next</button>
        </div>
    </div>

    <!-- Step 3: Service Information -->
    <div class="form-step" id="step-3" data-step="3">
        <div class="form-group">
            <label for="class">Service Menu:</label>
            <select class="form-control" id="class" name="class" required>
                @foreach ($all_service as $service)
                    <option value="{{ $service->service_cat_name }}">{{ $service->service_cat_name }}</option>
                @endforeach
                <option value="Yoga Center">Yoga Center</option>
                <option value="TTC">TTC</option>
                <option value="Retreat">Retreat</option>
                <option value="Workshop">Workshop</option>
            </select>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>
        <div class="form-buttons d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-light prev-step">Back</button>
            <button type="submit" class="btn btn-primary">Submit Enquiry</button>
        </div>
    </div>
</form>
<div class="success-message-container" style="display: none;">
    <div class="success-message-box">
        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>
        <h4 class="success-title">Thank You!</h4>
        <p class="success-text">Your enquiry has been submitted successfully. We'll get back to you soon.</p>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initially disable all next buttons
            $('.next-step').prop('disabled', true);

            // Convert inputs to uppercase and validate
            $('input:not([type="email"])').on('input', function() {
                this.value = this.value.toUpperCase();
                validateCurrentStepAndToggleButton();
            });

            // Real-time validation on all form controls
            $('.form-control').on('input keyup change', function() {
                validateCurrentStepAndToggleButton();
            });
            
            // Form submission handler
            $("#multi-step-form").on('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var form = $(this);
                
                // Clear previous errors
                $(".form-group").removeClass("has-error");
                $(".error-message").remove();
                
                // Validate all fields before submit
                let isValid = true;
                
                // Name validation
                if (!$("#name").val()) {
                    isValid = false;
                    $("#name").closest(".form-group").addClass("has-error")
                        .append('<div class="error-message">Please enter your name.</div>');
                }
                
                // Phone validation
                let phone = $("#phone").val();
                if (!phone || !/^\d{8,15}$/.test(phone)) {
                    isValid = false;
                    $("#phone").closest(".form-group").addClass("has-error")
                        .append('<div class="error-message">Enter a valid phone number (8–15 digits).</div>');
                }
                
                // Email validation
                let email = $("#email").val();
                if (!email || !isValidEmail(email)) {
                    isValid = false;
                    $("#email").closest(".form-group").addClass("has-error")
                        .append('<div class="error-message">Please enter a valid email address.</div>');
                }
                
                // Location validation
                let country = $("#country").val();
                let state = $("#state").val();
                let city = $("#city").val();
                
                if (!country) {
                    isValid = false;
                    $("#country").closest(".form-group").addClass("has-error")
                        .append('<div class="error-message">Please select your country.</div>');
                }
                if (!state) {
                    isValid = false;
                    $("#state").closest(".form-group").addClass("has-error")
                        .append('<div class="error-message">Please select your state.</div>');
                }
                if (!city) {
                    isValid = false;
                    $("#city").closest(".form-group").addClass("has-error")
                        .append('<div class="error-message">Please select your city.</div>');
                }
                
                // Message validation
                if (!$("#message").val()) {
                    isValid = false;
                    $("#message").closest(".form-group").addClass("has-error")
                        .append('<div class="error-message">Please enter a message.</div>');
                }
                
                if (!isValid) {
                    return false;
                }

                // Disable submit button and show loading state
                const submitBtn = form.find('button[type="submit"]');
                const originalBtnText = submitBtn.html();
                submitBtn.html('<span class="spinner"></span> Submitting...').prop('disabled', true);

                // Get the form data and log it
                const formData = new FormData(form[0]);
                const formDataObj = {};
                formData.forEach((value, key) => {
                    formDataObj[key] = value;
                });
                console.log('Form data before submission:', formDataObj);

                // Ensure form_type is set
                if (!formDataObj.form_type) {
                    formDataObj.form_type = '{{ $form_type }}';
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('form.submit') }}",
                    data: formDataObj,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Hide form and show success message
                        form.fadeOut(300, function() {
                            // Reset form
                            form[0].reset();
                            moveToStep(1);
                            // Show success message with animation
                            $('.success-message-container').fadeIn(300).css('display', 'flex');
                            // After 3 seconds, hide success message and show form
                            setTimeout(function() {
                                $('.success-message-container').fadeOut(300, function() {
                                    form.fadeIn(300);
                                });
                            }, 3000);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('Status:', status);
                        console.log('Error:', error);
                        console.log('Response:', xhr.responseText);
                        submitBtn.html(originalBtnText).prop('disabled', false);
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('An error occurred while submitting. Please try again.');
                        }
                    }
                });
            });

            let currentStep = 1;
            const totalSteps = 3;

            // Next step button handler
            $('.next-step').click(function() {
                if (validateCurrentStep(currentStep)) {
                    moveToStep(currentStep + 1);
                }
            });

            // Previous step button handler
            $('.prev-step').click(function() {
                moveToStep(currentStep - 1);
            });

            function moveToStep(step) {
                $('.form-step').removeClass('active');
                $('#step-' + step).addClass('active');
                currentStep = step;
                
                // Scroll to top of form to show validation messages
                $('html, body').animate({
                    scrollTop: $("#multi-step-form").offset().top - 50
                }, 200);
            }

            function validateCurrentStepAndToggleButton() {
                const fields = {
                    1: ['name', 'phone', 'email'],
                    2: ['country', 'state', 'city'],
                    3: ['class', 'message']
                };

                // Get current step
                const $currentStep = $('.form-step.active');
                const currentStepNumber = $currentStep.data('step');
                
                if (!currentStepNumber || !fields[currentStepNumber]) return;

                let isValid = true;
                
                // Validate all fields in current step
                fields[currentStepNumber].forEach(fieldId => {
                    const $field = $('#' + fieldId);
                    if (!validateField($field)) {
                        isValid = false;
                    }
                });

                // Toggle next button
                const $nextButton = $currentStep.find('.next-step');
                $nextButton.prop('disabled', !isValid);
                
                return isValid;
            }

            function validateCurrentStep(step) {
                // Clear previous errors
                $('.form-group').removeClass('has-error').find('.error-message').remove();
                return validateCurrentStepAndToggleButton();
            }

            // Validate fields and update button state on blur
            $('#name, #phone, #email, #country, #state, #city, #message').on('blur', function() {
                validateField($(this));
                validateCurrentStepAndToggleButton();
            });

            function validateField($field) {
                if (!$field || !$field.length) return false;
                const id = $field.attr('id');
                const value = $field.val();
                let isValid = true;
                let errorMessage = '';

                switch(id) {
                    case 'name':
                        if (!value) {
                            isValid = false;
                            errorMessage = 'Please enter your name.';
                        }
                        break;
                    case 'phone':
                        if (!value || !/^\d{8,15}$/.test(value)) {
                            isValid = false;
                            errorMessage = 'Enter a valid phone number (8–15 digits).';
                        }
                        break;
                    case 'email':
                        if (!value || !isValidEmail(value)) {
                            isValid = false;
                            errorMessage = 'Please enter a valid email address.';
                        }
                        break;
                    case 'country':
                        if (!value) {
                            isValid = false;
                            errorMessage = 'Please select your country.';
                        }
                        break;
                    case 'state':
                        if (!value) {
                            isValid = false;
                            errorMessage = 'Please select your state.';
                        }
                        break;
                    case 'city':
                        if (!value) {
                            isValid = false;
                            errorMessage = 'Please select your city.';
                        }
                        break;
                    case 'message':
                        if (!value) {
                            isValid = false;
                            errorMessage = 'Please enter a message.';
                        }
                        break;
                }

                $field.closest(".form-group").removeClass("has-error").find(".error-message").remove();
                
                if (!isValid) {
                    $field.closest(".form-group").addClass("has-error")
                        .append('<div class="error-message">' + errorMessage + '</div>');
                }

                return isValid;
            }
        });
        // 1. Only allow numbers on keypress
        $('#phone').on('keypress', function(e) {
            if (e.which < 48 || e.which > 57) {
                return false;
            }
        });

        // Email validation function
        function isValidEmail(email) {
            const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return regex.test(email);
        }

        // Block special characters and validate email on input
        $('#email').on('input', function(e) {
            let value = $(this).val();
            // Remove any special characters except those allowed in email
            value = value.replace(/[^a-zA-Z0-9.@_-]/g, '');
            $(this).val(value);
        });
    </script>
@endpush

@if($form_type == 'embed')
    <style>
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .has-error input, .has-error select, .has-error textarea {
            border-color: #dc3545;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .embedded-form {
            max-width: 100%;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
        }
        .form-control {
            height: 44px;
            padding: 0.5rem 1rem;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #ffd700;
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
        }
        textarea.form-control {
            height: auto;
            min-height: 100px;
            resize: vertical;
        }
        .form-buttons {
            gap: 10px !important;
        }
        .btn {
            height: 44px;
            padding: 0 25px;
            font-size: 15px;
            font-weight: 500;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #ffd700;
            border-color: #ffd700;
            color: #000;
        }
        .btn-primary:hover {
            background-color: #e6c200;
            border-color: #e6c200;
            color: #000;
        }
        .btn-light {
            background-color: #f8f9fa;
            border-color: #ddd;
            color: #333;
        }
        .btn-light:hover {
            background-color: #e9ecef;
            border-color: #ddd;
            color: #000;
        }
        .form-step {
            animation: fadeEffect 0.3s ease-in-out;
        }
        @keyframes fadeEffect {
            from {opacity: 0; transform: translateY(10px);}
            to {opacity: 1; transform: translateY(0);}
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
        }
        .gap-2 {
            gap: 0.5rem !important;
        }
        /* Success Message Styles */
        .success-message {
            text-align: center;
            padding: 30px 20px;
            animation: fadeIn 0.5s ease-out;
        }

        .success-icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 20px;
            animation: scaleIn 0.5s ease-out;
        }

        .success-message h4 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .success-message p {
            color: #666;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {transform: rotate(360deg);}
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @media (max-width: 768px) {
            .btn {
                height: 40px;
                padding: 0 20px;
                font-size: 14px;
            }
            .form-control {
                height: 40px;
            }
            .success-message {
                padding: 20px 15px;
            }
            .success-icon {
                font-size: 40px;
                margin-bottom: 15px;
            }
            .success-message h4 {
                font-size: 20px;
                margin-bottom: 10px;
            }
            .success-message p {
                font-size: 14px;
            }
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

        @media (max-width: 768px) {
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
@endif
