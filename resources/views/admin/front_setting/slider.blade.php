@extends('layouts.admin') {{-- Update this if your layout file is named differently --}}

@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">All Slider</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Front Setting</a></li>
            <li class="breadcrumb-item active">All Slider</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">View All Slider</h3>
          <div class="card-tools">
            <a href="{{ url('admin/front-setting/add-new-slider') }}" class="btn btn-success btn-sm">
              <i class="fa fa-plus"></i> Add Slider
            </a>
          </div>
        </div>

        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Background Image</th>
                <th>Details</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sliders as $index => $slider)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  <img src="{{ asset($slider->slider_image) }}" width="50px" alt="slider img">
                </td>
                <td>
                  H.: <strong>{{ $slider->slider_heading }}</strong><br>
                  S.H.: <strong>{{ $slider->slider_sub_heading }}</strong><br>
                  B. Name: <strong>{{ $slider->slider_btn_name }}</strong><br>
                  B. Link: <strong>{{ $slider->slider_btn_link }}</strong>
                </td>
                <td class="text-right py-0 align-middle">
                  <div class="btn-group-sm">
                    <a href="{{ url('admin/front-setting/edit-slider/' . $slider->slider_id) }}" class="btn btn-info">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ url('admin/front-setting/delete-slider/' . $slider->slider_id) }}"
                      onclick="return confirm('Are you sure?')" class="btn btn-danger mt-3">
                      <i class="fas fa-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div> <!-- /.card-body -->
      </div> <!-- /.card -->
    </div> <!-- /.container-fluid -->
  </section>
@endsection
