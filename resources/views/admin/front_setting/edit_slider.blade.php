@extends('layouts.admin')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Edit Slider</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Main Page Setting</a></li>
          <li class="breadcrumb-item active">Edit Slider</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Edit Slider</h3>
            <div class="card-tools">
              <a href="{{ route('admin.front.slider') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-eye" aria-hidden="true"></i> View Slider
              </a>
            </div>
          </div>

          <form action="{{ route('admin.front.slider.update', $slider->slider_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Slider Heading</label>
                    <input class="form-control" name="slider_heading" placeholder="Enter Slider Heading" value="{{ $slider->slider_heading }}">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Slider Sub Heading</label>
                    <input class="form-control" name="slider_sub_heading" placeholder="Enter Slider Sub Heading" value="{{ $slider->slider_sub_heading }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Slider Button Name</label>
                    <input class="form-control" name="slider_btn_name" placeholder="Enter Slider Button Name" value="{{ $slider->slider_btn_name }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Slider Button Link</label>
                    <input class="form-control" name="slider_btn_link" placeholder="Enter Slider Button Link" value="{{ $slider->slider_btn_link }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Slider Background Image <span class="required">*</span> (Size 1920px X 1280px)</label>
                    <input type="file" class="form-control" name="slider_image">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Slider Text Direction <span class="required">*</span></label>
                    <select class="form-control" name="slider_text_direction" required>
                      <option value="left" {{ $slider->slider_text_direction == 'left' ? 'selected' : '' }}>Left</option>
                      <option value="right" {{ $slider->slider_text_direction == 'right' ? 'selected' : '' }}>Right</option>
                      <option value="center" {{ $slider->slider_text_direction == 'center' ? 'selected' : '' }}>Center</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Preview Image</label><br>
                    <img style="border: 1px solid black" src="{{ asset($slider->slider_image) }}" width="150px;">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group text-right">
                    <button name="submit" type="submit" class="btn btn-success">Update</button>
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
