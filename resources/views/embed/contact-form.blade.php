<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Enquiry Form - YogIntra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            padding: 0; 
            margin: 0;
            background: transparent;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .container { 
            width: 100%; 
            padding: 15px; 
            max-width: 800px;
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
            margin-bottom: 1.5rem;
            position: relative;
        }
        .embedded-form {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .embedded-form .form-control {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
            font-size: 0.95rem;
        }
        .embedded-form .form-control:focus {
            border-color: #2563eb;
            outline: 0;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        }
        .embedded-form label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #374151;
            font-size: 0.9375rem;
            display: block;
        }
        .btn {
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
            font-size: 0.95rem;
        }
        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
        }
        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
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
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            .embedded-form {
                padding: 20px;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="embedded-form">
            <h4 class="form-heading">Enquire Now</h4>
            <x-multi-step-form form-type="embed" />
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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

                $.ajax({
                    url: "{{ route('form.submit') }}",
                    method: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        window.location.href = "{{ url('/thank_you') }}";
                        if (response.success) {
                        } else {
                            alert('Something went wrong. Please try again.');
                            $submitBtn.prop('disabled', false).text('Submit Enquiry');
                        }
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
</body>
</html>
