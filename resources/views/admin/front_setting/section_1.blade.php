@extends('layouts.admin')

@section('content')
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

{{-- Heading Section --}}
<section class="content">
<div class="container-fluid">
    <div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">Heading Section</h3>
    </div>
    <form action="{{ route('admin.front.our_features.heading.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
        <div class="row">
            <div class="col-md-6">
            <label>Heading<span>*</span></label>
            <input type="text" class="form-control" name="of_heading" required value="{{ $feature_heading->of_heading }}">
            </div>
            <div class="col-md-6">
            <label>Sub Heading<span>*</span></label>
            <input type="text" class="form-control" name="of_sub_heading" required value="{{ $feature_heading->of_sub_heading }}">
            </div>
            <div class="col-md-6">
            <label>Image</label>
            <input type="file" class="form-control" name="of_image">
            </div>
            <div class="col-md-6">
            <label>Image Preview</label><br>
            <img src="{{ asset($feature_heading->of_image) }}" width="100px">
            </div>
            <div class="col-md-12 text-right mt-3">
            <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
        </div>
    </form>
    </div>
</div>
</section>

{{-- All Features List --}}
<section class="content">
<div class="container-fluid">
    <div class="card card-default">
    <div class="card-header">
        <h3 class="card-title">View All Features</h3>
        <div class="card-tools">
        <button data-toggle="modal" data-target="#addFeatureModal" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i> Add Features
        </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Heading</th>
            <th>Description</th>
            <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($our_feature as $index => $service)
            <tr>
            <td>{{ $index + 1 }}</td>
            <td><img src="{{ asset($service->of_image) }}" width="70px"></td>
            <td>{{ $service->of_heading }}</td>
            <td>{{ $service->of_description }}</td>
            <td>
                <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    Action
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ url('admin/front-setting/edit-our-features/'.$service->of_id) }}">
                    <i class="fas fa-edit"></i> Edit
                    </a>
                    <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ url('admin/front-setting/delete-our-features/'.$service->of_id) }}">
                    <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
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

{{-- Modal for Add New Feature --}}
<div class="modal fade" id="addFeatureModal" tabindex="-1" role="dialog" aria-labelledby="addFeatureLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('admin.front.our_features.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Feature</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Heading <span>*</span></label>
            <input type="text" name="of_heading" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Description <span>*</span></label>
            <textarea name="of_description" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label>Image <span>*</span></label>
            <input type="file" name="of_image" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
