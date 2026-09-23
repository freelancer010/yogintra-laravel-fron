document.addEventListener('DOMContentLoaded', function() {
            // Get form elements - only target the form inside the popup
            const form = document.querySelector('#messagePopup #multi-step-form');
            if (!form) return; // Exit if form is not in popup
            
            const steps = form.querySelectorAll('.form-step');
            const progressBar = form.querySelector('.progress-bar');
            const stepIndicators = form.querySelectorAll('.step-indicators .step');

            // Function to show step
            function showStep(stepNumber) {
                steps.forEach(step => {
                    step.classList.remove('active');
                    if(step.dataset.step === stepNumber.toString()) {
                        step.classList.add('active');
                    }
                });

                // Update progress bar
                // progressBar.style.width = ((stepNumber - 1) * 50) + '%';

                // Update step indicators
                stepIndicators.forEach(indicator => {
                    indicator.classList.remove('active');
                    if(parseInt(indicator.dataset.step) <= stepNumber) {
                        indicator.classList.add('active');
                    }
                });
            }

            // Uppercase transform for specific popup inputs
            function transformToUppercaseElement(el) {
                try {
                    const caret = el.selectionStart;
                    const val = el.value || '';
                    const newVal = val.toUpperCase();
                    el.value = newVal;
                    try { el.setSelectionRange(caret, caret); } catch (e) {}
                } catch (e) {
                    // ignore if element doesn't support selectionRange
                    el.value = (el.value || '').toUpperCase();
                }
            }

            ['#name', '#country', '#state', '#city', '#certification'].forEach(function(selector) {
                const input = form.querySelector(selector);
                if (input) {
                    input.addEventListener('input', function() { transformToUppercaseElement(this); });
                    input.addEventListener('keyup', function() { transformToUppercaseElement(this); });
                }
            });

            // Next button handler - only for popup form
            form.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const currentStep = this.closest('.form-step');
                    const nextStep = parseInt(currentStep.dataset.step) + 1;
                    
                    // Validate current step
                    const inputs = currentStep.querySelectorAll('input[required], select[required], textarea[required]');
                    let isValid = true;
                    
                    inputs.forEach(input => {
                        // Remove previous validation classes
                        input.classList.remove('is-invalid');
                        const feedback = input.parentNode.querySelector('.invalid-feedback');
                        if(feedback) feedback.remove();
                        
                        if(!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                            
                            // Add error message
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'invalid-feedback';
                            errorDiv.textContent = 'This field is required.';
                            input.parentNode.appendChild(errorDiv);
                        } else if(input.type === 'email') {
                            // Email validation
                            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                            if(!emailRegex.test(input.value)) {
                                input.classList.add('is-invalid');
                                isValid = false;
                                
                                // Add error message
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'invalid-feedback';
                                errorDiv.textContent = 'Please enter a valid email address.';
                                input.parentNode.appendChild(errorDiv);
                            }
                        } else if(input.type === 'number' && input.name === 'number') {
                            // Phone validation
                            const phoneRegex = /^\d{8,15}$/;
                            if(!phoneRegex.test(input.value)) {
                                input.classList.add('is-invalid');
                                isValid = false;
                                
                                // Add error message
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'invalid-feedback';
                                errorDiv.textContent = 'Enter a valid phone number (8–15 digits).';
                                input.parentNode.appendChild(errorDiv);
                            }
                        }
                    });

                    if(isValid) {
                        showStep(nextStep);
                    }
                });
            });

            // Previous button handler - only for popup form
            form.querySelectorAll('.prev-step').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const currentStep = this.closest('.form-step');
                    const prevStep = parseInt(currentStep.dataset.step) - 1;
                    showStep(prevStep);
                });
            });

            // Note: Form submission is handled here for popup form
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate final step
                const finalStep = form.querySelector('.form-step.active');
                const inputs = finalStep.querySelectorAll('input[required], select[required], textarea[required]');
                let isValid = true;
                
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                    const feedback = input.parentNode.querySelector('.invalid-feedback');
                    if(feedback) feedback.remove();
                    
                    if(!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'This field is required.';
                        input.parentNode.appendChild(errorDiv);
                    }
                });

                if(!isValid) return;

                // Get submit button
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Submitting...';

                // Prepare form data
                const formData = new FormData(form);
                formData.set('form_type', 'embed');

                // Submit via AJAX (robust error handling)
                // Clear previous form-level errors
                (function clearFormError(){
                    const prev = form.querySelector('.form-error');
                    if(prev) prev.remove();
                })();

                fetch(document.body.dataset.contactFormEndpoint, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const text = await response.text().catch(() => '');
                    // If response not OK, surface status and any returned text
                    if (!response.ok) {
                        if (response.status === 419) {
                            throw new Error('Session expired or CSRF token missing. Please reload the page and try again.');
                        }
                        const snippet = text ? (text.length > 500 ? text.substring(0, 500) + '...' : text) : response.statusText;
                        throw new Error('Server error ' + response.status + ': ' + snippet);
                    }

                    // Ensure JSON
                    const contentType = response.headers.get('content-type') || '';
                    if (!contentType.includes('application/json')) {
                        const snippet = text ? (text.length > 500 ? text.substring(0, 500) + '...' : text) : contentType;
                        throw new Error('Expected JSON response but got: ' + snippet);
                    }

                    // Parse JSON
                    try {
                        return JSON.parse(text);
                    } catch (err) {
                        throw new Error('Invalid JSON response from server.');
                    }
                })
                .then(data => {
                    // Success path
                    showSuccessInPopup(data.message || 'Submitted successfully.');
                    // Reset form and close after 3 seconds
                    setTimeout(() => {
                        form.reset();
                        showStep(1);
                        toggleMessagePopup();
                    }, 3000);
                })
                .catch(error => {
                    console.error('Form submit error:', error);
                    // Show friendly error message inside the popup near the form
                    const errMsg = error && error.message ? error.message : 'Submission failed. Please try again.';
                    let errDiv = form.querySelector('.form-error');
                    if (!errDiv) {
                        errDiv = document.createElement('div');
                        errDiv.className = 'form-error alert alert-danger';
                        errDiv.style.marginBottom = '15px';
                        form.insertBefore(errDiv, form.firstChild);
                    }
                    errDiv.textContent = errMsg;
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
            
            // Add real-time email validation - only for popup form
            const emailInput = form.querySelector('input[type="email"]');
            if(emailInput) {
                emailInput.addEventListener('input', function() {
                    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                    const feedback = this.parentNode.querySelector('.invalid-feedback');
                    
                    // Remove previous validation
                    this.classList.remove('is-invalid');
                    if(feedback) feedback.remove();
                    
                    // Clean the input - remove unwanted characters
                    let value = this.value.replace(/[^a-zA-Z0-9.@_-]/g, '');
                    this.value = value;
                    
                    // Validate if not empty
                    if(value && !emailRegex.test(value)) {
                        this.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'Please enter a valid email address.';
                        this.parentNode.appendChild(errorDiv);
                    }
                });
            }
            
            // Add real-time phone validation - only for popup form
            const phoneInput = form.querySelector('input[name="number"]');
            if(phoneInput) {
                phoneInput.addEventListener('input', function() {
                    const phoneRegex = /^\d{8,15}$/;
                    const feedback = this.parentNode.querySelector('.invalid-feedback');
                    
                    // Remove previous validation
                    this.classList.remove('is-invalid');
                    if(feedback) feedback.remove();
                    
                    // Validate if not empty
                    if(this.value && !phoneRegex.test(this.value)) {
                        this.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.textContent = 'Enter a valid phone number (8–15 digits).';
                        this.parentNode.appendChild(errorDiv);
                    }
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Show tooltip after a short delay
            setTimeout(function() {
                document.querySelector('.tooltip-popup').classList.add('show');
                document.getElementById('messageIcon').style.animation = 'pulseAnimation 2s infinite';
            }, 2000);

            // Hide tooltip when clicking anywhere
            document.addEventListener('click', function() {
                document.querySelector('.tooltip-popup').classList.remove('show');
            });
        });

        // Add click handler for message icon and any elements with open-message-popup class
        document.getElementById('messageIcon').addEventListener('click', toggleMessagePopup);
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('open-message-popup') || e.target.closest('.open-message-popup')) {
                toggleMessagePopup();
                e.preventDefault();
            }
        });

        function toggleMessagePopup() {
            const popup = document.getElementById('messagePopup');
            const icon = document.getElementById('messageIcon');
            
            if (popup.style.display === 'block') {
                popup.style.display = 'none';
            } else {
                popup.style.display = 'block';
                // Stop the pulse animation when popup is opened
                icon.style.animation = 'none';
            }
        }

        // Function to show success message in popup
        function showSuccessInPopup(message) {
            const popupContent = document.querySelector('#messagePopup .popup-content');
            popupContent.innerHTML = `
                <div class="success-message">
                    <div class="success-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <h4>Thank You!</h4>
                    <p>${message || 'Your enquiry has been submitted successfully. We\'ll get back to you soon.'}</p>
                </div>
            `;
        }
