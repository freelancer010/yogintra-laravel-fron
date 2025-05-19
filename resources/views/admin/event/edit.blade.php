@extends('layouts.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Events</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Event</a></li>
                    <li class="breadcrumb-item active">Edit Events</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Edit Event Details</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.event.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> View All Event
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.event.partials.form', ['mode' => 'edit'])
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">Update Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
