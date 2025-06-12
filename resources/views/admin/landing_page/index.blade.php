@extends('layouts.admin')

@section('title', 'All Events')


@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Landing Pages</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Frontend Setting</a></li>
            <li class="breadcrumb-item active">All Landing Pages</li>
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
        <h3 class="card-title">View All Landing Pages</h3>
        <div class="card-tools">
            <a href="{{ route('admin.landing-pages.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Page
            </a>
        </div>
        <div class="card-tools">
            <!-- Uncomment below to enable add button -->
            {{-- <a href="{{ route('admin.landing-pages.create') }}" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i> Add Landing Page
            </a> --}}
        </div>
        </div>

        <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Page Name</th>
                <th>Page Slug</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pages as $index => $page)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                @if($page->page_image)
                    <img src="{{ asset($page->page_image) }}" width="70px">
                @endif
                </td>
                <td><strong>{{ $page->page_name }}</strong></td>
                <td>
                <a href="{{ url('/city/' . $page->page_slug) }}" target="_blank">Go To Page</a>
                </td>
                <td>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        Action
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.landing-pages.edit', $page->page_id) }}">
                        <i class="fas fa-edit"></i> Edit
                        </a>
                        <div class="dropdown-divider d-none"></div>
                        <a class="dropdown-item d-none" href="{{ route('admin.landing-pages.destroy', $page->page_id) }}" onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete
                        </a>
                    </div>
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
@endsection
