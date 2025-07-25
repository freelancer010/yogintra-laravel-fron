@extends('layouts.admin')

@section('content')
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h4>All Service</h4>
            </div>
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item"><a href="#">Service</a></li>
                  <li class="breadcrumb-item active">All Service</li>
               </ol>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         @include('admin.partials.flash')
         <div class="card card-default">
            <div class="card-header">
               <h3 class="card-title">View All Service</h3>
               <div class="card-tools">
                  <a href="{{ route('admin.service.create') }}" class="btn btn-success btn-sm">
                  <i class="fa fa-plus"></i> Add Service</a>
               </div>
            </div>
            <div class="card-body">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Capacity</th>
                        <th>Duration (Hrs.)</th>
                        <th>Category</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($services as $service)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ asset($service->service_image) }}" width="50px"></td>
                        <td>{{ $service->service_name }}</td>
                        <td>Rs. {{ $service->service_price }}</td>
                        <td>{{ $service->service_capacity }}</td>
                        <td>{{ $service->service_duration }}</td>
                        <td>{{ $service->service_cat_name }}</td>
                        <td>
                           <a href="{{ route('admin.service.edit', $service->service_id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                           <form action="{{ route('admin.service.destroy', $service->service_id) }}" method="POST" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                           </form>
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
