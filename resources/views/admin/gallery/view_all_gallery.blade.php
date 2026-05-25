@extends('layouts.admin')

@section('content')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h4>All Gallery</h4>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Gallery</a></li>
            <li class="breadcrumb-item active">All Gallery</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      @include('admin.partials.flash')
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">View All Gallery</h3>
          <div class="card-tools">
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addGalleryModal">
              <i class="fa fa-plus"></i> Add Gallery
            </button>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image / Video</th>
                <th>Category</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($all_data as $index => $data)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  @if($data->gallery_is_video_or_image == 1)
                    <img src="{{ asset($data->gallery_image) }}" width="70px">
                  @else
                    {!! preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","<iframe width='70' height='40' src='//www.youtube.com/embed/$1' frameborder='0' allowfullscreen></iframe>", $data->gallery_video) !!}
                  @endif
                </td>
                <td>{{ $data->g_cat_name }}</td>
                <td>
                  <div class="btn-group">
                    <a class="dropdown-item" href="{{ route('admin.gallery.edit', $data->gallery_id) }}">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('admin.gallery.delete', $data->gallery_id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-trash"></i> Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

<div class="modal fade" id="addGalleryModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Gallery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>Select A Mode <span class="text-danger">*</span></label>
            <select onchange="get_mode(this.value)" class="form-control" name="gallery_is_video_or_image" required>
              <option value="">Select</option>
              <option value="1">Image</option>
              <option value="2">Video</option>
            </select>
          </div>
          <div class="form-group">
            <label>Select A Category <span class="text-danger">*</span></label>
            <select class="form-control" name="gallery_category" required>
              <option value="">Select</option>
              @foreach ($all_category as $category)
                <option value="{{ $category->g_cat_id }}">{{ $category->g_cat_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group" id="image_section">
            <label>Upload Image <span class="text-danger">*</span></label>
            <input id="image_filed" type="file" class="form-control" name="gallery_image">
          </div>
          <div class="form-group" id="video_section">
            <label>Youtube Url <span class="text-danger">*</span></label>
            <input id="image_video" type="text" class="form-control" name="gallery_video" placeholder="Enter Youtube Url">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function get_mode(e) {
    if (e == 1) {
      document.getElementById('image_section').style.display = 'block';
      document.getElementById('video_section').style.display = 'none';
    } else {
      document.getElementById('image_section').style.display = 'none';
      document.getElementById('video_section').style.display = 'block';
    }
  }
</script>
<style>
  #image_section, #video_section {
    display: none;
  }
</style>
@endsection
