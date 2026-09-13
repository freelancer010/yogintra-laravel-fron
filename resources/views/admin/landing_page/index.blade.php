@extends('layouts.admin')

@section('title', 'All Events')


@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6 d-flex align-items-center">
            <h1 class="m-0 text-dark">Landing pages</h1>
            <button type="button" class="btn btn-success btn-sm ml-3" data-toggle="modal" data-target="#newPageModal">
                <i class="fa fa-plus" aria-hidden="true"></i> Add Page
            </button>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Frontend Setting</a></li>
            <li class="breadcrumb-item active">Landing pages</li>
        </ol>
        </div>
    </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <div class="card card-default">
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
        <div class="table-responsive landing-page-table-scroll">
        <table id="example1" class="table table-bordered table-striped landing-page-table">
            <thead>
            <tr>
                <th class="landing-page-id">ID</th>
                <th>Image</th>
                <th>Page Name</th>
                <th>Page Slug</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pages as $index => $page)
            <tr>
                <td class="landing-page-id">{{ $index + 1 }}</td>
                <td>
                @if($page->page_image)
                    <img src="{{ asset($page->page_image) }}" width="70px">
                @endif
                </td>
                <td><strong>{{ $page->page_name }}</strong></td>
                <td>
                @php($publicUrl = url('/city/' . $page->page_slug))
                <a class="landing-page-url" href="{{ $publicUrl }}" target="_blank" rel="noopener">{{ $publicUrl }}</a>
                </td>
                <td class="landing-page-actions">
                  <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.landing-pages.edit', $page->page_id) }}" title="Edit {{ $page->page_name }}">
                    <i class="fas fa-edit" aria-hidden="true"></i><span class="sr-only">Edit</span>
                  </a>
                  <form method="POST" action="{{ route('admin.landing-pages.toggle-published', $page->page_id) }}" class="landing-page-publish-form">
                    @csrf
                    <input type="hidden" name="is_published" value="0">
                    <label class="landing-page-switch" title="{{ ($page->is_published ?? true) ? 'Hide from the public site' : 'Show on the public site' }}">
                      <input type="checkbox" name="is_published" value="1" {{ ($page->is_published ?? true) ? 'checked' : '' }} onchange="this.form.submit()">
                      <span aria-hidden="true"></span>
                      <span class="sr-only">{{ ($page->is_published ?? true) ? 'Published' : 'Hidden' }}</span>
                    </label>
                  </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
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
<style>
  .landing-page-table .landing-page-id { width: 54px; text-align: center; }
  .landing-page-table .landing-page-url { display: inline-block; max-width: 100%; overflow-wrap: anywhere; }
  .landing-page-actions { display: flex; align-items: center; gap: 8px; }
  .landing-page-actions .btn { min-width: 32px; min-height: 30px; padding: .34rem .48rem; margin: 0; }
  .landing-page-publish-form { margin: 0 !important; }
  .landing-page-switch { display: inline-flex; align-items: center; cursor: pointer; margin: 0; }
  .landing-page-switch input { position: absolute; opacity: 0; pointer-events: none; }
  .landing-page-switch span[aria-hidden] { position: relative; display: block; width: 34px; height: 19px; border-radius: 999px; background: #b7c3c8; transition: background .18s ease; }
  .landing-page-switch span[aria-hidden]::after { content: ''; position: absolute; top: 3px; left: 3px; width: 13px; height: 13px; border-radius: 50%; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.18); transition: transform .18s ease; }
  .landing-page-switch input:checked + span[aria-hidden] { background: var(--admin-accent); }
  .landing-page-switch input:checked + span[aria-hidden]::after { transform: translateX(15px); }
  .landing-page-switch input:focus-visible + span[aria-hidden] { outline: 3px solid rgba(15, 124, 135, .22); outline-offset: 2px; }
  @media (max-width: 767.98px) {
    .landing-page-table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .landing-page-table { min-width: 760px; }
  }
</style>
@endsection
