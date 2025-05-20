<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'category' => 'required|string',
            'image' => 'required|image|max:2048',
            'date_time' => 'required|date',
            'end_date_time' => 'required|date',
            'event_mode' => 'nullable|in:1,2',
            'main_price' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
            'event_location' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pin_code' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/events', 'public');
        }

        $data = [
            'title' => $request->input('title'),
            'link' => Str::slug($request->input('link')),
            'category' => $request->input('category'),
            'keyword' => $request->input('keyword', ''),
            'description' => $request->input('description', ''),
            'short_content' => $request->input('short_content', ''),
            'content' => $request->input('content', ''),
            'image' => $imagePath,
            'date_time' => $request->input('date_time'),
            'end_date_time' => $request->input('end_date_time'),
            'event_mode' => $request->input('event_mode', 1),
            'main_price' => $request->input('main_price', 0),
            'discount_price' => $request->input('discount_price', 0),
            'event_location' => $request->input('event_location'),
            'event_host_by' => $request->input('event_host_by', ''),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pin_code' => $request->input('pin_code'),
            'head_code' => $request->input('head_code', ''),

            // Ticket fields (with safe defaults)
            'ticket_indian' => $request->input('ticket_indian', 'Indian Student'),
            'ticket_short_des_indian' => $request->input('ticket_short_des_indian', ''),
            'ticket_price_indian' => $request->input('ticket_price_indian', 0),
            'ticket_capacity_indian' => $request->input('ticket_capacity_indian', 0),
            'ticket_d_qnty_indian' => $request->input('ticket_d_qnty_indian', 0),
            'ticket_r_qnty_indian' => $request->input('ticket_r_qnty_indian', 0),

            'ticket_foreigner' => $request->input('ticket_foreigner', 'Foreigner Student'),
            'ticket_short_des_foreigner' => $request->input('ticket_short_des_foreigner', ''),
            'ticket_price_foreigner' => $request->input('ticket_price_foreigner', 0),
            'ticket_capacity_foreigner' => $request->input('ticket_capacity_foreigner', 0),
            'ticket_d_qnty_foreigner' => $request->input('ticket_d_qnty_foreigner', 0),
            'ticket_r_qnty_foreigner' => $request->input('ticket_r_qnty_foreigner', 0),

            // Checkboxes
            'Indian_stu_checkbox' => $request->has('Indian_stu_checkbox') ? 1 : 0,
            'Foreign_stu_checkbox' => $request->has('Foreign_stu_checkbox') ? 1 : 0,

            // Addon handling
            'Extra_addon_checkbox' => json_encode($request->input('Extra_addon_checkbox', [])),
            'addon_name' => json_encode(array_filter($request->input('addon_name', []))),
            'addon_price' => json_encode(array_filter($request->input('addon_price', []))),

            'status' => 'On',
        ];

        $success = DB::table('event')->insert($data);

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
        $event = DB::table('event')->where('id', $id)->first();
        if (!$event) {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'date_time' => 'required|date',
            'end_date_time' => 'required|date',
        ]);

        // Prepare data
        $data = [
            'title' => $request->title,
            'link' => strtolower(str_replace(' ', '-', $request->link)),
            'keyword' => $request->keyword,
            'description' => $request->description,
            'short_content' => $request->short_content,
            'content' => $request->content,
            'date_time' => $request->date_time,
            'end_date_time' => $request->end_date_time,
            'event_mode' => $request->event_mode,
            'main_price' => $request->main_price,
            'discount_price' => $request->discount_price,
            'event_location' => $request->event_location,
            'head_code' => $request->head_code ?? '',
            'event_host_by' => $request->event_host_by,
            'category' => $request->category,
            'country' => $request->country ?? '',
            'state' => $request->state ?? '',
            'city' => $request->city ?? '',
            'pin_code' => $request->pin_code ?? '',

            // Ticket - Indian
            'ticket_indian' => $request->ticket_indian ?? '',
            'ticket_short_des_indian' => $request->ticket_short_des_indian ?? '',
            'ticket_price_indian' => $request->ticket_price_indian ?? '',
            'ticket_capacity_indian' => $request->ticket_capacity_indian ?? '',
            'ticket_d_qnty_indian' => $request->ticket_d_qnty_indian ?? '',
            'ticket_r_qnty_indian' => $request->ticket_r_qnty_indian ?? '',

            // Ticket - Foreigner
            'ticket_foreigner' => $request->ticket_foreigner ?? '',
            'ticket_short_des_foreigner' => $request->ticket_short_des_foreigner ?? '',
            'ticket_price_foreigner' => $request->ticket_price_foreigner ?? '',
            'ticket_capacity_foreigner' => $request->ticket_capacity_foreigner ?? '',
            'ticket_d_qnty_foreigner' => $request->ticket_d_qnty_foreigner ?? '',
            'ticket_r_qnty_foreigner' => $request->ticket_r_qnty_foreigner ?? '',

            // Checkboxes
            'Indian_stu_checkbox' => $request->has('Indian_stu_checkbox') ? 1 : 0 ?? '',
            'Foreign_stu_checkbox' => $request->has('Foreign_stu_checkbox') ? 1 : 0 ?? '',

            // JSON fields
            'Extra_addon_checkbox' => json_encode($request->Extra_addon_checkbox ?? []),
            'addon_name' => json_encode($request->addon_name ?? []),
            'addon_price' => json_encode($request->addon_price ?? []),
        ];

        // Handle file upload
        if ($request->hasFile('image')) {
            if ($event->image && file_exists(public_path($event->image))) {
                @unlink(public_path($event->image));
            }

            $file = $request->file('image');
            $filename = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), basename($filename));

            $data['image'] = $filename;
        }

        // Update DB
        DB::table('event')->where('id', $id)->update($data);

        return redirect()->route('admin.event.index')->with('success', 'Event successfully updated!');
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

    public function booking()
    {
        $all_booking = DB::table('event_booking as a')
            ->select('a.*', 'b.title', 'b.category', 'b.addon_name')
            ->join('event as b', 'b.id', '=', 'a.booking_event_id')
            ->orderByDesc('a.booking_date') // ✅ Replace 'id' with actual column name
            ->get();

        return view('admin.event.all_event_booking', [
            'title' => 'All Event Booking',
            'all_booking' => $all_booking,
        ]);
    }
}
