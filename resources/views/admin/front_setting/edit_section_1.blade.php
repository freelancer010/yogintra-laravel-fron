@extends('layouts.admin')

@section('content')
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Our Features</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Frontend Setting</a></li>
            <li class="breadcrumb-item active">Our Features</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-sm-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Edit Section</h3>
            </div>

            <form action="{{ route('admin.front.our_features.update', $features->of_id) }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="card-body">
                <div class="row">

                  <!-- Heading -->
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Heading <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="of_heading" placeholder="Enter Heading" required value="{{ $features->of_heading }}">
                    </div>
                  </div>

                  <!-- Description -->
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Description <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="of_description" placeholder="Enter Description" required>{{ $features->of_description }}</textarea>
                    </div>
                  </div>

                  <!-- Image Upload -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Image</label>
                      <input type="file" class="form-control" name="of_image">
                    </div>
                  </div>

                  <!-- Image Preview -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Image Preview</label><br>
                      <img src="{{ asset($features->of_image) }}" width="100px">
                    </div>
                  </div>

                  <!-- Submit Button -->
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
