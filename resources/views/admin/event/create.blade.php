@extends('layouts.admin')

@section('title', 'Add Event')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Add Event</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item">Event</li>
          <li class="breadcrumb-item active">Add Event</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Add New Event</h3>
        <div class="card-tools">
          <a href="{{ route('admin.event.index') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-eye"></i> View All Events
          </a>
        </div>
      </div>
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger font-weight-bold">
            {{ $errors->first() }}
          </div>
        @endif

        <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('admin.event.partials.form')
          <button type="submit" class="btn btn-success">Save</button>
        </form>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
      const output = document.getElementById('imagePreview');
      output.src = reader.result;
      output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
@endpush
@endsection