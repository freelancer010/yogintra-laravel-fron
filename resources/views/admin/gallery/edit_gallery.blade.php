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
                      <input class="form-control" type="file" name="gallery_image" id="image">
                    </div>
                  </div>

                  <div class="col-md-12" id="pre_img">
                    <div class="form-group">
                      <label>Preview Upload Image</label>
                      <div>
                        <img src="{{ asset($gallery->gallery_image) }}" width="100px">
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

          </div>
        </div>
      </div>
    </div>
  </section>

<script>
  $(document).ready(function () {
    onchnage({{ $gallery->gallery_is_video_or_image }});
  });

  function onchnage(e) {
    if (e == 1) {
      $('#v_url').hide();
      $('#add_btn').show();
      $('#img').show();
      $('#pre_img').show();
      $("#video").prop('required', false);
    } else {
      $('#img').hide();
      $('#add_btn').show();
      $('#pre_img').hide();
      $('#v_url').show();
      $("#video").prop('required', true);
      $("#image").prop('required', false);
    }
  }
</script>

<style>
  #img, #v_url, #add_btn, #pre_img {
    display: none;
  }
</style>
@endsection
