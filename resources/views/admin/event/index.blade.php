@extends('layouts.admin')

@section('title', 'All Events')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">All Events</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item">Event</li>
          <li class="breadcrumb-item active">All Events</li>
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
          <div class="card-header mt-3 px-5">
            <h3 class="card-title border-0">All Events data</h3>
            <div class="card-tools">
              <a href="{{ url('admin/event/add_new_event') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Add New Event
              </a>
            </div>
          </div>

          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#ID</th>
                  <th>Title</th>
                  <th>Slug</th>
                  <th>Date & Time</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($get_all_event as $i => $event)
                  <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $event->title }}</td>
                    <td>
                      <a href="{{ url('event/' . $event->link) }}" class="btn btn-primary btn-sm" target="_blank">Go to Event&nbsp;<i class="fas fa-arrow-right" ></i></a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($event->date_time)->format('d-m-Y h:i A') }}</td>
                    <td>
                      <a href="{{ url('admin/event/event_status/' . $event->id . '/' . ($event->status === 'On' ? 'Off' : 'On')) }}"
                         class="btn btn-sm {{ $event->status === 'On' ? 'btn-success' : 'btn-danger' }}">
                        <span class="text-white">{{ $event->status }}</span>
                      </a>
                    </td>
                    <td>
                      <a href="{{ url('admin/event/edit_event/' . $event->id) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-edit"></i>
                      </a>
                      <a href="{{ url('admin/event/delete_event/' . $event->id) }}"
                         onclick="return confirm('Are you sure?')"
                         class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
