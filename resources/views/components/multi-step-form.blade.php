@php
    use Illuminate\Support\Facades\DB;
    $all_service = DB::table('service_category')->get();
@endphp

@props(['form_type' => ''])

<form id="multi-step-form" class="booking-form {{ $form_type == 'landing' ? 'bg-black-333 p-30' : '' }} {{ $form_type == 'embed' ? 'embedded-form' : '' }}">
    @if ($form_type == 'landing')
        <h3 class="mt-0 text-white mb-20">Make An Appointment</h3>
    @endif
    @csrf
    
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

@push('scripts')
    <script>
        $(document).ready(function() {
            // Convert inputs to uppercase
            $('input:not([type="email"])').on('input', function() {
                this.value = this.value.toUpperCase();
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

                $.ajax({
                    type: "POST",
                    url: "{{ route('form.submit') }}",
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Use the showSuccessInPopup function
                        showSuccessInPopup(response.message);
                        // Reset form after successful submission
                        form[0].reset();
                        // Reset the first step
                        moveToStep(1);
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

            function validateCurrentStep(step) {
                let isValid = true;
                const fields = {
                    1: ['name', 'phone', 'email'],
                    2: ['country', 'state', 'city'],
                    3: ['class', 'message']
                };

                // Clear previous errors
                $('.form-group').removeClass('has-error').find('.error-message').remove();

                // Validate current step fields
                fields[step].forEach(fieldId => {
                    const $field = $('#' + fieldId);
                    if (!validateField($field)) {
                        isValid = false;
                    }
                });

                return isValid;
            }

            // Show validation messages on input blur
            $('#name, #phone, #email, #country, #state, #city, #message').on('blur', function() {
                validateField($(this));
            });

            function validateField($field) {
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
    </style>
@endif
