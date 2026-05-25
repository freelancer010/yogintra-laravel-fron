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
            <h3 class="card-title border-0">View All Events</h3>
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
                  <th>SL</th>
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
                    <a href="{{ url('event/' . $event->link) }}" class="btn btn-primary btn-sm" target="_blank">
                      View Event&nbsp;<i class="fas fa-arrow-right"></i>
                    </a>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($event->date_time)->format('d-m-Y h:i A') }}</td>
                  <td>
                    <a href="{{ route('admin.event.status', ['id' => $event->id, 'status' => $event->status === 'On' ? 'Off' : 'On']) }}"
                      class="btn btn-sm {{ $event->status === 'On' ? 'btn-success' : 'btn-danger' }}"
                      onclick="return confirm('Are you sure you want to change status?')">
                      {{ $event->status }}
                    </a>
                  </td>
                  <td>
                    <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-info btn-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                      </button>
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
  </div>
</section>
@endsection
