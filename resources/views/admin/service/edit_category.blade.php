@extends('layouts.admin')

@section('content')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h4>Edit Service Category</h4>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Service</a></li>
            <li class="breadcrumb-item active">Edit Service Category</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      @include('admin.partials.flash')
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Update Service Category</h3>
            </div>
            <form action="{{ route('admin.service.update_category', $category->service_cat_id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="card-body">
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Category Name <span class="text-danger">*</span></label>
                      <input type="text" name="service_cat_name" class="form-control" required value="{{ $category->service_cat_name }}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Page Title</label>
                      <input type="text" name="page_title" class="form-control" value="{{ $category->page_title }}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Page Meta Title</label>
                      <input type="text" name="page_meta_title" class="form-control" value="{{ $category->page_meta_title }}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Page Slug</label>
                      <input type="text" name="page_Slug" class="form-control" value="{{ $category->page_Slug }}">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Page Meta Keywords <small>(Comma separated)</small></label>
                      <textarea name="page_keywords" class="form-control">{{ $category->page_keywords }}</textarea>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Page Meta Description</label>
                      <textarea name="page_meta_description" class="form-control">{{ $category->page_meta_description }}</textarea>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Category Image</label>
                      <div class="d-flex align-items-center">
                        <div>
                          <img id="category_image_preview" src="{{ asset($category->service_cat_image) }}" width="100" class="rounded border" style="object-fit:cover; height:100px;">
                        </div>
                        <div class="ml-3">
                          <label for="service_cat_image_input" class="btn btn-primary mb-0">
                            <i class="fa fa-upload"></i> Choose Image
                          </label>
                          <input type="file" name="service_cat_image" class="form-control d-none" id="service_cat_image_input" accept="image/*">
                          <div id="selected_file_name" class="text-muted small mt-2"></div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group text-right">
                      <button type="submit" class="btn btn-success">Update</button>
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
@endsection

@push('scripts')
<script>
document.getElementById('service_cat_image_input').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('category_image_preview').src = URL.createObjectURL(file);
        document.getElementById('selected_file_name').textContent = file.name;
    } else {
        document.getElementById('selected_file_name').textContent = '';
    }
});
</script>
@endpush