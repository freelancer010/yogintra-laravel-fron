@php
    use Illuminate\Support\Facades\DB;
    $all_service = DB::table('service_category')->get();
@endphp

<form id="multi-step-form"
    @if (isset($form_type)) class="{{ $form_type == 'landing' ? 'booking-form form-home bg-black-333 p-30' : '' }}" @endif
    method="post">
    <!-- Step 1: Personal Information -->
    @if (isset($form_type) && $form_type == 'landing')
        <h3 class="mt-0 text-white mb-20">Make An Appointment</h3>
    @endif
    @csrf
    <div class="form-step active" id="step-1">
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
            <input type="text" class="form-control" id="email" name="email" required placeholder="Enter your email here...">
        </div>
        <button class="btn btn-primary next" type="button">Next</button>
    </div>

    <!-- Step 2: Location -->
    <div class="form-step" id="step-2">
        <div class="form-group">
            <label for="country">Select Country:</label>
            <input type="text" class="form-control countries" id="country" name="country" required
                placeholder="Enter your Country" />
        </div>
        <div class="form-group">
            <label for="state">Select State:</label>
            <input type="text" class="form-control states" id="state" name="state" required
                placeholder="Enter your State" />
        </div>
        <div class="form-group">
            <label for="city">Select City:</label>
            <input type="text" class="form-control cities" id="city" name="city" required
                placeholder="Enter your city" />
        </div>
        <button class="btn btn-primary prev" type="button">Previous</button>
        <button class="btn btn-primary next" type="button">Next</button>
    </div>

    <!-- Step 3: Service Information -->
    <div class="form-step" id="step-3">
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
        <div class="form-group d-none">
            <label for="call-time">Call Request Time From:</label>
            <input type="time" class="form-control" id="call-time" name="call-from">
        </div>
        <div class="form-group d-none">
            <label for="call-time-2">To:</label>
            <input type="time" class="form-control" id="call-time-2" name="call-to">
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>
        <button class="btn btn-primary prev" type="button">Previous</button>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</form>

<style>
    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }
</style>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('input').on('input', function() {
                this.value = this.value.toUpperCase();
            });
            $("#multi-step-form").submit(function(e) {
                e.preventDefault();
                var form = $(this);

                $.ajax({
                    type: "POST",
                    url: "{{ route('form.submit') }}", // Use Laravel route
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        window.location = "{{ url('/thank_you') }}"; // Redirect on success
                        // if (data.status === 'success') {
                        // } else {
                        //     alert('Data Submission Failed');
                        // }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('An error occurred while submitting.');
                    }
                });
            });

            var currentStep = 1;

            $(".next").click(function() {
                if (validateStep(currentStep)) {
                    $("#step-" + currentStep).removeClass("active");
                    currentStep++;
                    $("#step-" + currentStep).addClass("active");
                }
            });

            $(".prev").click(function() {
                $("#step-" + currentStep).removeClass("active");
                currentStep--;
                $("#step-" + currentStep).addClass("active");
            });

            function validateStep(step) {
                let isValid = true;
                $(".form-group").removeClass("has-error");
                $(".error-message").remove();

                if (step === 1) {
                    let name = $("#name").val();
                    let phone = $("#phone").val();
                    let email = $("#email").val();

                    if (!name) {
                        isValid = false;
                        $("#name").closest(".form-group").addClass("has-error").append(
                            '<div class="error-message">Please enter your name.</div>');
                    }
                    if (!phone || !/^\d{8,15}$/.test(phone)) {
                        isValid = false;
                        $("#phone")
                            .closest(".form-group")
                            .addClass("has-error")
                            .append('<div class="error-message">Enter a valid phone number (8–15 digits).</div>');
                    }
                    if (!email) {
                        isValid = false;
                        $("#email").closest(".form-group").addClass("has-error").append(
                            '<div class="error-message">Please enter your email address.</div>');
                    }
                } else if (step === 2) {
                    let country = $("#country").val();
                    let state = $("#state").val();
                    let city = $("#city").val();

                    if (!country) {
                        isValid = false;
                        $("#country").closest(".form-group").addClass("has-error").append(
                            '<div class="error-message">Please select your country.</div>');
                    }
                    if (!state) {
                        isValid = false;
                        $("#state").closest(".form-group").addClass("has-error").append(
                            '<div class="error-message">Please select your state.</div>');
                    }
                    if (!city) {
                        isValid = false;
                        $("#city").closest(".form-group").addClass("has-error").append(
                            '<div class="error-message">Please select your city.</div>');
                    }
                } else if (step === 3) {
                    let message = $("#message").val();
                    if (!message) {
                        isValid = false;
                        $("#message").closest(".form-group").addClass("has-error").append(
                            '<div class="error-message">Please enter a message.</div>');
                    }
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
    </script>
@endpush
