<div class="col-md-4">
  <div class="form_booking">
    <form id="booking-form" name="booking-form" action="#" method="post" enctype="multipart/form-data">
      <h3 class="title text-theme-colored text-center mb-15">Registration Form</h3>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="name">Name</label>
            <input id="name" type="text" placeholder="Enter Name" name="register_name" required class="form-control">
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" placeholder="Enter Email" name="register_email" class="form-control" required>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label for="phone">Phone</label>
            <input id="phone" type="text" placeholder="Enter Phone" name="register_phone" class="form-control" required>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label for="reg_ticket">Ticket</label>
            <select id="reg_ticket" onchange="get_price(this.value)" name="register_ticket" class="form-control" required>
              <option value="">Select Ticket</option>
              @if($event->Indian_stu_checkbox)
              <option value="1">Indian Student</option>
              @endif
              @if($event->Foreign_stu_checkbox)
              <option value="2">Foreigner Student</option>
              @endif
            </select>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label>Select Country:</label>
            <select class="form-control countries" id="country" name="register_country" required>
              <option value="">Select A Country</option>
            </select>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label>Select State:</label>
            <select class="form-control states" id="state" name="register_state" required>
              <option value="">Select your Country First</option>
            </select>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label>Select City:</label>
            <select class="form-control cities" id="city" name="register_city" required>
              <option value="">Select your state first</option>
            </select>
          </div>
        </div>

        @if ($event->addon_name && $event->Extra_addon_checkbox)
          @php
            $addonNames = json_decode($event->addon_name, true);
            $addonCheckboxes = json_decode($event->Extra_addon_checkbox, true);
            $addonPrices = json_decode($event->addon_price, true);
          @endphp
          @if (is_array($addonNames) && count($addonNames))
            <div class="col-sm-12">
              <div class="form-group">
                <label>Extra Addon</label>
              </div>
            </div>
            <div class="col-sm-12">
              @foreach ($addonNames as $index => $name)
                @if (isset($addonCheckboxes[$index]) && $addonCheckboxes[$index] === 'checked')
                  <div class="form-group mb-0">
                    <input type="checkbox" class="addon-checkbox" name="register_addon[]" value="{{ $index }}" data-price="{{ $addonPrices[$index] }}">
                    <label>{{ $name }} | ₹ {{ $addonPrices[$index] }}</label>
                  </div>
                @endif
              @endforeach
            </div>
          @endif
        @endif

        <div class="col-sm-12">
          <h4>Main Price : ₹<b id="ttl_p1">0</b></h4>
          <h4>Discount Price : ₹<b id="ttl_p2">0</b></h4>
          <h4>Total Price : ₹<b id="ttl_p">0</b></h4>
          <input type="hidden" id="tpl">
          <input type="hidden" id="tplMainAmt" name="ttl_amt">
          <input type="hidden" name="event_id" value="{{ $event->id }}">
          <input type="hidden" name="event_category" value="{{ $event->category }}">
          <input type="hidden" name="event_name" value="{{ $event->title }}">
        </div>

        <div class="col-sm-12">
          <div class="form-group text-center">
            <button class="btn btn-dark btn-theme-colored btn-sm btn-block mt-20 pt-10 pb-10 text-uppercase" type="submit">Register now</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
