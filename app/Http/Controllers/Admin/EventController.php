<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('admin.event.index', [
            'title' => 'View All Event',
            'get_all_event' => DB::table('event')->get(), // or Event::all()
        ]);
    }

    public function create()
    {
        return view('admin.event.create', [
            'title' => 'Add New Event'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // Add other validations
        ]);

        $success = DB::table('event')->insert([
            'title' => $request->input('title'),
            // Add other fields
        ]);

        return $success
            ? redirect()->route('admin.event.index')->with('success', 'Event Successfully Added')
            : back()->with('error', 'Event Add Failed');
    }

    public function edit($id)
    {
        $event = DB::table('event')->find($id);
        return view('admin.event.edit', [
            'title' => 'Edit Event',
            'event' => $event
        ]);
    }

    public function update(Request $request, $id)
    {
        $updated = DB::table('event')->where('id', $id)->update([
            'title' => $request->input('title'),
            // Add other fields
        ]);

        return $updated
            ? redirect()->route('admin.event.index')->with('success', 'Event Successfully Updated')
            : back()->with('error', 'Event Update Failed');
    }

    public function destroy($id)
    {
        $deleted = DB::table('event')->where('id', $id)->delete();
        return $deleted
            ? redirect()->route('admin.event.index')->with('success', 'Event Successfully Deleted')
            : back()->with('error', 'Event Delete Failed');
    }

    public function toggleStatus($id, $status)
    {
        $updated = DB::table('event')->where('id', $id)->update(['status' => $status]);
        return $updated
            ? redirect()->route('admin.event.index')->with('success', 'Event Status Changed')
            : back()->with('error', 'Status Change Failed');
    }

    public function bookings()
    {
        $bookings = DB::table('event_bookings')->get();
        return view('admin.event.bookings', [
            'title' => 'All Event Booking',
            'all_booking' => $bookings
        ]);
    }
}
