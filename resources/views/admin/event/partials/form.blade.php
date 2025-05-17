<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>Category <span class="text-danger">*</span></label>
      <select name="category" class="form-control" required>
        <option value="">Select A Category</option>
        <option value="TTC" {{ old('category') == 'TTC' ? 'selected' : '' }}>TTC</option>
        <option value="Retreat" {{ old('category') == 'Retreat' ? 'selected' : '' }}>Retreat</option>
        <option value="Workshop" {{ old('category') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
      </select>
    </div>
  </div>

  <div class="col-md-5">
    <div class="form-group">
      <label>Title <span class="text-danger">*</span></label>
      <input type="text" name="title" id="title" class="form-control" required placeholder="Enter Event Title" value="{{ old('title') }}">
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label>Slug <span class="text-danger">*</span></label>
      <input type="text" name="link" id="link" class="form-control" required placeholder="Enter Event Slug" value="{{ old('link') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Meta Keyword</label>
      <textarea name="keyword" class="form-control" placeholder="Enter Meta Keywords">{{ old('keyword') }}</textarea>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Meta Description</label>
      <textarea name="description" class="form-control" placeholder="Enter Meta Description">{{ old('description') }}</textarea>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label>Short Description</label>
      <textarea name="short_content" class="form-control" placeholder="Enter Event Short Description">{{ old('short_content') }}</textarea>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label>Full Description</label>
      <textarea name="content" class="form-control text-editor" placeholder="Enter Full Description">{{ old('content') }}</textarea>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Start Date & Time <span class="text-danger">*</span></label>
      <input type="datetime-local" name="date_time" class="form-control" required value="{{ old('date_time') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>End Date & Time <span class="text-danger">*</span></label>
      <input type="datetime-local" name="end_date_time" class="form-control" required value="{{ old('end_date_time') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Host By</label>
      <input type="text" name="event_host_by" class="form-control" placeholder="Enter Host Name" value="{{ old('event_host_by') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Event Mode</label>
      <select name="event_mode" class="form-control">
        <option value="">Select Mode</option>
        <option value="1" {{ old('event_mode') == '1' ? 'selected' : '' }}>Free Event</option>
        <option value="2" {{ old('event_mode') == '2' ? 'selected' : '' }}>Paid Event</option>
      </select>
    </div>
  </div>

  <div class="col-md-6 event_price d-none">
    <div class="form-group">
      <label>Main Price</label>
      <input type="number" name="main_price" class="form-control" placeholder="Enter Main Price" value="0">
    </div>
  </div>

  <div class="col-md-6 event_price d-none">
    <div class="form-group">
      <label>Discount Price</label>
      <input type="number" name="discount_price" class="form-control" placeholder="Enter Discount Price" value="0">
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label>Country <span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="country" value="{{ old('country') }}" required>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label>State <span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="state" value="{{ old('state') }}" required>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label>City <span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
    </div>
  </div>

  <div class="col-md-3">
    <div class="form-group">
      <label>Pin Code <span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="pin_code" value="{{ old('pin_code') }}" required>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label>Event Location <span class="text-danger">*</span></label>
      <input type="text" name="event_location" class="form-control" placeholder="Enter Event Location" value="{{ old('event_location') }}" required>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label>Event Header Code</label>
      <textarea name="head_code" class="form-control" placeholder="Enter Header Code">{{ old('head_code') }}</textarea>
    </div>
  </div>
</div>


<div class="row">
  <!-- Existing fields are already above -->

  <!-- Ticket Table -->
  <div class="col-md-12">
    <div class="form-group">
      <label>Ticket Options</label>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Checkbox</th>
              <th>Ticket</th>
              <th>Short Des.</th>
              <th>Price</th>
              <th>Capacity</th>
              <th>Default Qty.</th>
              <th>Reserve Qty.</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="checkbox" name="Indian_stu_checkbox" value="checked" class="form-control" {{ old('Indian_stu_checkbox') ? 'checked' : '' }}></td>
              <td><input type="text" name="ticket_indian" class="form-control" value="Indian Student" readonly></td>
              <td><input type="text" name="ticket_short_des_indian" class="form-control" value="{{ old('ticket_short_des_indian') }}"></td>
              <td><input type="number" name="ticket_price_indian" class="form-control" value="{{ old('ticket_price_indian') }}"></td>
              <td><input type="number" name="ticket_capacity_indian" class="form-control" value="{{ old('ticket_capacity_indian') }}"></td>
              <td><input type="number" name="ticket_d_qnty_indian" class="form-control" value="{{ old('ticket_d_qnty_indian') }}"></td>
              <td><input type="number" name="ticket_r_qnty_indian" class="form-control" value="{{ old('ticket_r_qnty_indian') }}"></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="Foreign_stu_checkbox" value="checked" class="form-control" {{ old('Foreign_stu_checkbox') ? 'checked' : '' }}></td>
              <td><input type="text" name="ticket_foreigner" class="form-control" value="Foreigner Student" readonly></td>
              <td><input type="text" name="ticket_short_des_foreigner" class="form-control" value="{{ old('ticket_short_des_foreigner') }}"></td>
              <td><input type="number" name="ticket_price_foreigner" class="form-control" value="{{ old('ticket_price_foreigner') }}"></td>
              <td><input type="number" name="ticket_capacity_foreigner" class="form-control" value="{{ old('ticket_capacity_foreigner') }}"></td>
              <td><input type="number" name="ticket_d_qnty_foreigner" class="form-control" value="{{ old('ticket_d_qnty_foreigner') }}"></td>
              <td><input type="number" name="ticket_r_qnty_foreigner" class="form-control" value="{{ old('ticket_r_qnty_foreigner') }}"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Extra Addon -->
  <div class="col-md-12">
    <div class="form-group">
      <label>Extra Addon</label>
      <div id="addon-container">
        <div class="addon-field row">
          <div class="col-sm-2">
            <input type="checkbox" class="form-control" name="Extra_addon_checkbox[]" value="checked">
          </div>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="addon_name[]" placeholder="Addon Name">
          </div>
          <div class="col-sm-3">
            <input type="text" class="form-control" name="addon_price[]" placeholder="Addon Price">
          </div>
          <div class="col-sm-1">
            <button type="button" id="add-addon" class="btn btn-success btn-sm">+</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function addAddonField() {
    const container = document.getElementById("addon-container");
    const field = document.createElement("div");
    field.className = "addon-field row mt-2";
    field.innerHTML = `
      <div class=\"col-sm-2\">
        <input type=\"checkbox\" class=\"form-control\" name=\"Extra_addon_checkbox[]\" value=\"checked\">
      </div>
      <div class=\"col-sm-6\">
        <input type=\"text\" class=\"form-control\" name=\"addon_name[]\" placeholder=\"Addon Name\">
      </div>
      <div class=\"col-sm-3\">
        <input type=\"text\" class=\"form-control\" name=\"addon_price[]\" placeholder=\"Addon Price\">
      </div>
      <div class=\"col-sm-1\">
        <button type=\"button\" class=\"remove-addon btn btn-danger btn-sm\">X</button>
      </div>`;
    container.appendChild(field);
  }

  document.getElementById("add-addon").addEventListener("click", addAddonField);
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-addon")) {
      e.target.closest(".addon-field").remove();
    }
  });

  // Event mode toggle
  document.querySelector("select[name='event_mode']").addEventListener("change", function() {
    const priceFields = document.querySelectorAll(".event_price");
    if (this.value === '2') {
      priceFields.forEach(el => el.classList.remove('d-none'));
    } else {
      priceFields.forEach(el => el.classList.add('d-none'));
    }
  });

  // Auto slug generation
  document.getElementById("title").addEventListener("input", function () {
    const val = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    document.getElementById("link").value = val;
  });
</script>
@endpush
