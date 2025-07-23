@extends('layouts.admin')

@section('content')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h4>Service Category</h4>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Service</a></li>
            <li class="breadcrumb-item active">Service Category</li>
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
          <h3 class="card-title">View All Category</h3>
          <div class="card-tools">
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addCategoryModal">
              <i class="fa fa-plus"></i> Add Category
            </button>
          </div>
        </div>
        <div class="card-body">
          <table id="categoryTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($categories as $key => $category)
              <tr>
                <td>{{ $key + 1 }}</td>
                <td><img src="{{ asset($category->service_cat_image) }}" width="50"></td>
                <td>{{ $category->service_cat_name }}</td>
                <td>{{ $category->service_cat_slug }}</td>
                <td>
                  <a href="{{ route('admin.service.edit_category', $category->service_cat_id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <form action="{{ route('admin.service.delete_category', $category->service_cat_id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                      <i class="fas fa-trash"></i> Delete
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.service.add_category') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="service_cat_name" required>
          </div>
          <div class="form-group">
            <label>Page Title</label>
            <input type="text" class="form-control" name="page_title">
          </div>
          <div class="form-group">
            <label>Page Meta Title</label>
            <input type="text" class="form-control" name="page_meta_title">
          </div>
          <div class="form-group">
            <label>Page Slug</label>
            <input type="text" class="form-control" name="page_Slug">
          </div>
          <div class="form-group">
            <label>Page Meta Keywords <small>(Comma separated)</small></label>
            <textarea class="form-control" name="page_keywords"></textarea>
          </div>
          <div class="form-group">
            <label>Page Meta Description</label>
            <textarea class="form-control" name="page_meta_description"></textarea>
          </div>
          <div class="form-group">
            <label>Image <span class="text-danger">*</span></label>
            <input type="file" class="form-control" name="service_cat_image" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(function () {
    $('#categoryTable').DataTable();
  });
</script>
@endpush
