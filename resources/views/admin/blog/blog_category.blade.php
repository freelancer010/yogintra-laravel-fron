@extends('layouts.admin')

@section('title', 'Blog Category')

@section('content')
<!-- Content Wrapper. Contains page content -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h4>Blog Category</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Blog</a></li>
                <li class="breadcrumb-item active">Blog Category</li>
            </ol>
        </div>
        </div>
    </div>
</section>

<!-- Add Form -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-sm-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Add Blog Category</h3>
                </div>
                <form action="{{ route('admin.blog_category.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="category_name" class="form-control" placeholder="Enter Category Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category Meta Keywords</label>
                                <textarea name="category_keyword" class="form-control" placeholder="Enter Meta Keywords"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category Meta Description</label>
                                <textarea name="category_description" class="form-control" placeholder="Enter Meta Description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success">Add</button>
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

<!-- View Table -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">View All Categories</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Keywords</th>
                    <th>Description</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($get_all_blog_category as $i => $category)
                    <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $category->category_slug }}</td>
                    <td>{{ $category->category_keyword }}</td>
                    <td>{{ $category->category_description }}</td>
                    <td>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Action</button>
                                <div class="dropdown-menu">
                                    <a class="text-success dropdown-item" href="{{ url('admin/blog/blog-category/edit/' . $category->id) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="text-danger dropdown-item" onclick="return confirm('Are you sure?')" href="{{ route('admin.blog_category.delete', $category->id) }}">
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

@push('scripts')
<script>
   $(function () {
      $("#example1").DataTable();
   });
</script>
@endpush