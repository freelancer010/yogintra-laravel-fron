@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Section 2</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Frontend Setting</a></li>
          <li class="breadcrumb-item active">Edit Section 2</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Edit Content</h3>
          </div>
          <!-- /.card-header -->
          <form action="{{ route('admin.front.section2.service.update', $service->os_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                   <div class="item form-group">
                      <label class="col-md-12 col-sm-12 col-xs-12"> Heading<span>*</span></label>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                         <input type="text" class="form-control" name="os_heading" placeholder="Enter Heading" required value="{{ $service->os_heading }}">
                      </div>
                   </div>
                </div>
                <div class="col-md-6">
                   <div class="item form-group">
                      <label class="col-md-12 col-sm-12 col-xs-12">Image </label>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                         <input type="file" class="form-control" name="os_image" placeholder="Enter Sub-Heading">
                      </div>
                   </div>
                </div>
                <div class="col-md-6">
                   <div class="item form-group">
                      <label class="col-md-12 col-sm-12 col-xs-12">Image Preview</label>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                         @if($service->os_image)
                            <img src="{{ asset($service->os_image) }}" width="100px">
                         @else
                            <p>No image uploaded</p>
                         @endif
                      </div>
                   </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                     <a href="{{ route('admin.front.section2') }}" class="btn btn-secondary">Back</a>
                     <button type="submit" class="btn btn-success" style="float: right">Update</button>
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
