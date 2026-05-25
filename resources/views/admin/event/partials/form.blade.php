<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>Category <span class="text-danger">*</span></label>
      <select name="category" class="form-control" required>
        <option value="">Select A Category</option>
        <option value="TTC" {{ old('category', $event->category ?? '') == 'TTC' ? 'selected' : '' }}>TTC</option>
        <option value="Retreat" {{ old('category', $event->category ?? '') == 'Retreat' ? 'selected' : '' }}>Retreat</option>
        <option value="Workshop" {{ old('category', $event->category ?? '') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
      </select>
    </div>
  </div>

  <div class="col-md-5">
    <div class="form-group">
      <label>Title <span class="text-danger">*</span></label>
      <input type="text" name="title" id="title" class="form-control" required placeholder="Enter Event Title" value="{{ old('title', $event->title ?? '') }}">
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label>Slug <span class="text-danger">*</span></label>
      <input type="text" name="link" id="link" class="form-control" required placeholder="Enter Event Slug" value="{{ old('link', $event->link ?? '') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Meta Keyword</label>
      <textarea name="keyword" class="form-control">{{ old('keyword', $event->keyword ?? '') }}</textarea>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Meta Description</label>
      <textarea name="description" class="form-control">{{ old('description', $event->description ?? '') }}</textarea>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label>Short Description</label>
      <textarea name="short_content" class="form-control">{{ old('short_content', $event->short_content ?? '') }}</textarea>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label>Full Description</label>
      <textarea name="content" class="form-control text-editor">{{ old('content', $event->content ?? '') }}</textarea>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Start Date & Time <span class="text-danger">*</span></label>
      <input type="datetime-local" name="date_time" class="form-control" required value="{{ old('date_time', isset($event) ? \Carbon\Carbon::parse($event->date_time)->format('Y-m-d\TH:i') : '') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>End Date & Time <span class="text-danger">*</span></label>
      <input type="datetime-local" name="end_date_time" class="form-control" required value="{{ old('end_date_time', isset($event) ? \Carbon\Carbon::parse($event->end_date_time)->format('Y-m-d\TH:i') : '') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Host By</label>
      <input type="text" name="event_host_by" class="form-control" placeholder="Enter Host Name" value="{{ old('event_host_by', $event->event_host_by ?? '') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label>Event Mode</label>
      <select name="event_mode" class="form-control">
        <option value="">Select Mode</option>
        <option value="1" {{ old('event_mode', $event->event_mode ?? '') == '1' ? 'selected' : '' }}>Free Event</option>
        <option value="2" {{ old('event_mode', $event->event_mode ?? '') == '2' ? 'selected' : '' }}>Paid Event</option>
      </select>
    </div>
  </div>

  <div class="col-md-6 event_price {{ old('event_mode', $event->event_mode ?? '') == '2' ? '' : 'd-none' }}">
    <div class="form-group">
      <label>Main Price</label>
      <input type="number" name="main_price" class="form-control" placeholder="Enter Main Price" value="{{ old('main_price', $event->main_price ?? '') }}">
    </div>
  </div>

  <div class="col-md-6 event_price {{ old('event_mode', $event->event_mode ?? '') == '2' ? '' : 'd-none' }}">
    <div class="form-group">
      <label>Discount Price</label>
      <input type="number" name="discount_price" class="form-control" placeholder="Enter Discount Price" value="{{ old('discount_price', $event->discount_price ?? '') }}">
    </div>
  </div>

    <div class="col-md-6">
    <div class="form-group">
      <label for="country">Country <span class="text-danger">*</span></label>
      <input type="text" name="country" id="country" class="form-control" placeholder="Enter Country" required value="{{ old('country', $event->country ?? '') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="state">State <span class="text-danger">*</span></label>
      <input type="text" name="state" id="state" class="form-control" placeholder="Enter state" required value="{{ old('state', $event->state ?? '') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="city">City <span class="text-danger">*</span></label>
      <input type="text" name="city" id="city" class="form-control" placeholder="Enter city" required value="{{ old('city', $event->city ?? '') }}">
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="pin_code">Pin Code <span class="text-danger">*</span></label>
      <input type="text" name="pin_code" id="pin_code" class="form-control" placeholder="Enter pin_code" value="{{ old('pin_code', $event->pin_code ?? '') }}">
    </div>
  </div>
  
  <div class="col-md-12">
    <div class="form-group">
      <label>Event Location <span class="text-danger">*</span></label>
      <input type="text" name="event_location" class="form-control" placeholder="Enter Event Location" value="{{ old('event_location', $event->event_location ?? '') }}" required>
    </div>
  </div>

  {{-- Ticket Type Table with checkboxes --}}
  <div class="col-md-12">
    <label>Ticket Options</label>
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
          <td><input type="checkbox" name="Indian_stu_checkbox" value="1" class="form-control" {{ old('Indian_stu_checkbox', $event->Indian_stu_checkbox ?? false) ? 'checked' : '' }}></td>
          <td><input type="text" name="ticket_indian" class="form-control" value="Indian Student" readonly></td>
          <td><input type="text" name="ticket_short_des_indian" class="form-control" value="{{ old('ticket_short_des_indian', $event->ticket_short_des_indian ?? '') }}"></td>
          <td><input type="number" name="ticket_price_indian" class="form-control" value="{{ old('ticket_price_indian', $event->ticket_price_indian ?? '') }}"></td>
          <td><input type="number" name="ticket_capacity_indian" class="form-control" value="{{ old('ticket_capacity_indian', $event->ticket_capacity_indian ?? '') }}"></td>
          <td><input type="number" name="ticket_d_qnty_indian" class="form-control" value="{{ old('ticket_d_qnty_indian', $event->ticket_d_qnty_indian ?? '') }}"></td>
          <td><input type="number" name="ticket_r_qnty_indian" class="form-control" value="{{ old('ticket_r_qnty_indian', $event->ticket_r_qnty_indian ?? '') }}"></td>
        </tr>
        <tr>
          <td><input type="checkbox" name="Foreign_stu_checkbox" value="1" class="form-control" {{ old('Foreign_stu_checkbox', $event->Foreign_stu_checkbox ?? false) ? 'checked' : '' }}></td>
          <td><input type="text" name="ticket_foreigner" class="form-control" value="Foreigner Student" readonly></td>
          <td><input type="text" name="ticket_short_des_foreigner" class="form-control" value="{{ old('ticket_short_des_foreigner', $event->ticket_short_des_foreigner ?? '') }}"></td>
          <td><input type="number" name="ticket_price_foreigner" class="form-control" value="{{ old('ticket_price_foreigner', $event->ticket_price_foreigner ?? '') }}"></td>
          <td><input type="number" name="ticket_capacity_foreigner" class="form-control" value="{{ old('ticket_capacity_foreigner', $event->ticket_capacity_foreigner ?? '') }}"></td>
          <td><input type="number" name="ticket_d_qnty_foreigner" class="form-control" value="{{ old('ticket_d_qnty_foreigner', $event->ticket_d_qnty_foreigner ?? '') }}"></td>
          <td><input type="number" name="ticket_r_qnty_foreigner" class="form-control" value="{{ old('ticket_r_qnty_foreigner', $event->ticket_r_qnty_foreigner ?? '') }}"></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <label>Extra Addon</label>
      <div id="addon-container">
        @php
          $addon_names = json_decode($event->addon_name ?? '[]', true);
          $addon_prices = json_decode($event->addon_price ?? '[]', true);
          $addon_checkboxes = json_decode($event->Extra_addon_checkbox ?? '{}', true);
        @endphp
        @foreach ($addon_names as $i => $addon)
          <div class="row mb-2 addon-field justify-content-between">
            <div class="col-sm-1">
              <input type="hidden" name="Extra_addon_checkbox[{{ $i }}]" value="">
              <input type="checkbox" class="form-control" value="1" name="Extra_addon_checkbox[{{ $i }}]" {{ old("Extra_addon_checkbox.$i", $addon_checkboxes[$i] ?? null) ? 'checked' : '' }}>
            </div>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="addon_name[]" placeholder="Addon Name" value="{{ old('addon_name.' . $i, $addon) }}">
            </div>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="addon_price[]" placeholder="Addon Price" value="{{ old('addon_price.' . $i, $addon_prices[$i] ?? '') }}">
            </div>
            <div class="col-sm-1">
              <button type="button" class="remove-addon btn btn-danger btn-sm">X</button>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="col-md-12">
    <div class="form-group mt-3">
      <label for="image">Front Image <span class="text-danger">*</span></label>
      <div class="mb-2">
        <input type="file" name="image" id="image" class="form-control-file" 
        @if(isset($mode) && $mode != 'edit')
        required 
        @endif
        accept="image/*" onchange="previewImage(event)">
        <small class="form-text text-muted">Max size: 2MB. Formats: JPG, PNG.</small>
      </div>
      <img 
        id="imagePreview" 
        src="https://via.placeholder.com/150x100?text=Preview" 
        class="img-thumbnail border-secondary" 
        style="display:none; max-height: 150px;"
        src="{{ isset($event->image) ? asset($event->image) : '' }}"
      >
    </div>
  </div>
</div>

@push('scripts')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/p96sr398x0evyp69lvm9o2ieiuyexn462e38v64kghyfl7zy/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  function addAddonField() {
    const container = document.getElementById("addon-container");
    const i = container.querySelectorAll('.addon-field').length;
    const field = document.createElement("div");
    field.className = "row mb-2 addon-field justify-content-between";
    field.innerHTML = `
      <div class="col-sm-1">
        <input type="hidden" name="Extra_addon_checkbox[\${i}]" value="">
        <input type="checkbox" class="form-control" name="Extra_addon_checkbox[\${i}]" value="1">
      </div>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="addon_name[]" placeholder="Addon Name">
      </div>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="addon_price[]" placeholder="Addon Price">
      </div>
      <div class="col-sm-1">
        <button type="button" class="remove-addon btn btn-danger btn-sm">X</button>
      </div>
    `;
    container.appendChild(field);
  }

  document.addEventListener("DOMContentLoaded", function () {
    const addButton = document.createElement("button");
    addButton.textContent = " + ";
    addButton.type = "button";
    addButton.className = "btn btn-success btn-sm mt-2 ml-3";
    addButton.onclick = addAddonField;
    document.getElementById("addon-container")?.appendChild(addButton);

    document.addEventListener("click", function (e) {
      if (e.target.classList.contains("remove-addon")) {
        e.target.closest(".addon-field")?.remove();
      }
    });

    document.getElementById("title")?.addEventListener("input", function () {
      const val = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
      document.getElementById("link").value = val;
    });

    document.querySelector("select[name='event_mode']")?.addEventListener("change", function () {
      const isPaid = this.value === '2';
      document.querySelectorAll(".event_price").forEach(el => el.classList.toggle("d-none", !isPaid));
    });

    // Image preview
    document.getElementById('imageInput')?.addEventListener('change', function (event) {
      const [file] = event.target.files;
      const preview = document.getElementById('imagePreview');
      if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
      } else {
        preview.src = '';
        preview.style.display = 'none';
      }
    });

    // TinyMCE Init - fully featured toolbar (removed hr and toc)
    tinymce.init({
      selector: 'textarea.text-editor',
      height: 500,
      plugins: 'image media link code table lists advlist fullscreen preview anchor insertdatetime searchreplace wordcount charmap emoticons codesample visualblocks visualchars',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media codesample | table charmap emoticons | code visualblocks fullscreen preview',
      images_upload_url: '{{ url("/admin/tinymce/upload") }}',
      automatic_uploads: true,
      images_upload_credentials: true,
      convert_urls: true,
      relative_urls: false,
      remove_script_host: false,
      file_picker_types: 'image',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      setup: function (editor) {
        editor.on('change', function () {
          editor.save();
        });
      }
    });
  });
</script>
@endpush