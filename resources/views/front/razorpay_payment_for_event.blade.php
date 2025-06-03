<!DOCTYPE html>
<html>
<head>
  <title>Event Payment</title>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
</head>
<body>
  <button id="rzp-button1" style="display:none;">Pay with Razorpay</button>

  <form name='razorpayform' action="{{ url('/rezorpay-payment-for-event') }}" method="POST">
      @csrf
      <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
      <input type="hidden" name="razorpay_signature" id="razorpay_signature">
  </form>

  <script>
    var options = {!! json_encode($data) !!};

    options.handler = function (response){
      document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
      document.getElementById('razorpay_signature').value = response.razorpay_signature;
      document.razorpayform.submit();
    };

    options.theme.image_padding = false;

    options.modal = {
      ondismiss: function(){
        window.location.href = document.referrer;
      },
      escape: true,
      backdropclose: false
    };

    var rzp = new Razorpay(options);
    $(document).ready(function() {
      $("#rzp-button1").click();
      rzp.open();
    });
  </script>
</body>
</html>