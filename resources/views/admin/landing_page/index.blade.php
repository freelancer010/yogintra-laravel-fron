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
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#newPageModal">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Page
            </button>
        </div>
        <div class="card-tools">
            <!-- Uncomment below to enable add button -->
            {{-- <a href="{{ route('admin.landing-pages.create') }}" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i> Add Landing Page
            </a> --}}
        </div>
        </div>

        <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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

<div class="modal fade" id="newPageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" method="POST" action="{{ route('admin.landing-pages.start') }}">
      @csrf
      <div class="modal-header"><h5 class="modal-title">Create landing page</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
      <div class="modal-body">
        <p class="text-muted small">Start with the page essentials. You can add and edit sections in the visual builder next.</p>
        <div class="form-group"><label>Page name <span class="text-danger">*</span></label><input class="form-control" id="draft-page-name" name="page_name" required autofocus></div>
        <div class="form-group"><label>Page slug</label><input class="form-control" id="draft-page-slug" name="page_slug" pattern="[a-z0-9]+(?:-[a-z0-9]+)*" placeholder="online-yoga-mumbai"><small class="form-text text-muted">/city/your-slug</small></div>
        <div class="form-group mb-0"><label>SEO title</label><input class="form-control" name="page_meta_title" placeholder="Optional; defaults to page name"></div>
      </div>
      <div class="modal-footer"><button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button><button class="btn btn-success" type="submit">Create &amp; open builder</button></div>
    </form>
  </div>
</div>
<script>
document.getElementById('draft-page-name')?.addEventListener('input', function () {
  document.getElementById('draft-page-slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
});
</script>
@endsection
