@extends('layouts.admin')

@section('content')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Update Gallery</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Gallery</a></li>
            <li class="breadcrumb-item active">Update Gallery</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Update Gallery</h3>
              <div class="card-tools">
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-primary btn-sm">
                  <i class="fa fa-eye"></i> View Gallery Item
                </a>
              </div>
            </div>

            <form action="{{ route('admin.gallery.update', $gallery->gallery_id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Gallery Category <span class="text-danger">*</span></label>
                      <select class="form-control" name="gallery_category" required>
                        <option value="">Select</option>
                        @foreach($all_category as $category)
                          <option value="{{ $category->g_cat_id }}" {{ $category->g_cat_id == $gallery->gallery_category ? 'selected' : '' }}>{{ $category->g_cat_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Gallery Mode <span class="text-danger">*</span></label>
                      <select class="form-control" name="gallery_is_video_or_image" id="mode" onchange="onchnage(this.value)" required>
                        <option value="">Select</option>
                        <option value="2" {{ $gallery->gallery_is_video_or_image == 2 ? 'selected' : '' }}>Video</option>
                        <option value="1" {{ $gallery->gallery_is_video_or_image == 1 ? 'selected' : '' }}>Image</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12" id="img">
                    <div class="form-group">
                      <label>Upload Image</label>
                      <div class="d-flex align-items-center">
                        <div>
                          @if(!empty($gallery->gallery_image) && file_exists(public_path($gallery->gallery_image)))
                            <img id="gallery_image_preview" src="{{ asset($gallery->gallery_image) }}" width="120" height="120" class="rounded-circle shadow border" style="object-fit:cover;">
                          @elseif(!empty($gallery->gallery_image))
                            <img id="gallery_image_preview" src="/{{ $gallery->gallery_image }}" width="120" height="120" class="rounded-circle shadow border" style="object-fit:cover;">
                          @else
                            <img id="gallery_image_preview" src="https://via.placeholder.com/120?text=No+Image" width="120" height="120" class="rounded-circle shadow border" style="object-fit:cover;">
                          @endif
                        </div>
                        <div class="ml-4">
                          <label for="image" class="btn btn-primary btn-sm mb-2">
                            <i class="fa fa-upload"></i> Choose Image
                          </label>
                          <input type="file" name="gallery_image" class="d-none" id="image" accept="image/*">
                          <div id="selected_file_name" class="text-muted small mt-2"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12" id="v_url">
                    <div class="form-group">
                      <label>Youtube Video URL <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="gallery_video" id="video">{{ $gallery->gallery_video }}</textarea>
                    </div>
                  </div>

                  <div class="col-md-12" id="add_btn">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            @if(!empty($gallery->gallery_image))
              <input type="hidden" name="existing_gallery_image" value="{{ $gallery->gallery_image }}">
            @endif

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script>
  function showFields(mode) {
    if (mode == 1 || mode == '1') {
      $('#img').show();
      $('#v_url').hide();
      $('#add_btn').show();
      $("#video").prop('required', false);
      // REMOVE or COMMENT OUT the next line for edit forms:
      // $("#image").prop('required', true);
    } else if (mode == 2 || mode == '2') {
      $('#img').hide();
      $('#v_url').show();
      $('#add_btn').show();
      $("#video").prop('required', true);
      $("#image").prop('required', false);
    } else {
      $('#img').hide();
      $('#v_url').hide();
      $('#add_btn').hide();
      $("#video").prop('required', false);
      $("#image").prop('required', false);
    }
  }

  $(document).ready(function () {
    // Hide all conditional fields initially
    $('#img').hide();
    $('#v_url').hide();
    $('#add_btn').hide();

    // Show the correct fields based on the selected mode
    let mode = $('#mode').val();
    showFields(mode);

    // When mode changes
    $('#mode').on('change', function() {
      showFields($(this).val());
    });

    // Live preview for image upload
    $('#image').on('change', function(event) {
      const [file] = event.target.files;
      if (file) {
        $('#gallery_image_preview').attr('src', URL.createObjectURL(file));
        $('#selected_file_name').text(file.name);
      } else {
        $('#selected_file_name').text('');
      }
    });
  });
</script>
@endpush