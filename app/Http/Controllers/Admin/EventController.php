<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

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
            'title'          => 'required|string|max:255',
            'link'           => 'required|string|max:255',
            'category'       => 'required|string',
            'image' => 'nullable|image|max:2048',
            'date_time' => 'required|date',
            'end_date_time' => 'required|date',
            'event_mode' => 'nullable|in:1,2',
            'event_location' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/events'), $filename);
            $imagePath = 'uploads/events/' . $filename;
        }

        $data = [
            'title' => $request->input('title'),
            'link' => strtolower(str_replace(" ", "-", $request->input('link'))),
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
            'head_code' => $request->input('head_code', ''),

            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pin_code' => $request->input('pin_code'),

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

            'Indian_stu_checkbox' => $request->has('Indian_stu_checkbox') ? 1 : 0,
            'Foreign_stu_checkbox' => $request->has('Foreign_stu_checkbox') ? 1 : 0,

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
            'category' => 'required|string',
            'date_time' => 'required|date',
            'end_date_time' => 'required|date',
            'event_location' => 'required|string',
        ]);

        $data = [
            'title' => $request->input('title'),
            'link' => strtolower(str_replace(" ", "-", $request->input('link'))),
            'category' => $request->input('category'),
            'keyword' => $request->input('keyword', ''),
            'description' => $request->input('description', ''),
            'short_content' => $request->input('short_content', ''),
            'content' => $request->input('content', ''),
            'date_time' => $request->input('date_time'),
            'end_date_time' => $request->input('end_date_time'),
            'event_mode' => $request->input('event_mode', 1),
            'main_price' => $request->input('main_price', 0),
            'discount_price' => $request->input('discount_price', 0),
            'event_location' => $request->input('event_location'),
            'event_host_by' => $request->input('event_host_by', ''),
            // 'event_host_plat' => $request->input('event_host_plat', ''),
            // 'event_build_mode' => $request->input('event_build_mode', ''),
            'head_code' => $request->input('head_code', ''),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'pin_code' => $request->input('pin_code'),

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

            'Indian_stu_checkbox' => $request->has('Indian_stu_checkbox') ? 1 : 0,
            'Foreign_stu_checkbox' => $request->has('Foreign_stu_checkbox') ? 1 : 0,

            'Extra_addon_checkbox' => json_encode($request->input('Extra_addon_checkbox', [])),
            'addon_name' => json_encode(array_filter($request->input('addon_name', []))),
            'addon_price' => json_encode(array_filter($request->input('addon_price', []))),
        ];

        if ($request->hasFile('image')) {
            if ($event->image && file_exists(public_path($event->image))) {
                @unlink(public_path($event->image));
            }
            $image = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/events'), $filename);
            $data['image'] = 'uploads/events/' . $filename;
        }

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


    public function submitEventForm(Request $request)
    {
        $data = $request->only([
            'register_name', 'register_email', 'register_phone',
            'register_ticket', 'ttl_amt', 'event_id', 'register_country',
            'register_state', 'register_city', 'event_name',
            'event_category', 'register_addon'
        ]);

        Session::flush();

        foreach ($data as $key => $value) {
            Session::put($key, is_array($value) ? json_encode($value) : $value);
        }

        return response()->json(['success' => true]);
    }

    public function paymentForEvent22()
    {
        $setting = DB::table('application_setting')->first();
        $api = new Api($setting->rozar_key_id, $setting->rozar_key_secret);
        $order_id = date('Ymd') . rand(1000, 9999);
        $mainAmount = Session::get('register_ttl_amt');

        $razorpayOrder = $api->order->create([
            'receipt' => $order_id,
            'amount' => $mainAmount * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        $razorpayOrderId = $razorpayOrder['id'];
        Session::put('razorpay_order_id', $razorpayOrderId);

        $raz_pay_data = $this->rozrPayPrepareDataPrdPayForEvent($razorpayOrder['amount'], $razorpayOrderId, $order_id);

        return View::make('rezorpay_payment_for_event', ['data' => $raz_pay_data]);
    }

    public function paymentForEvent()
    {

        // $api = new Api($key_id, $key_secret);

        $setting = DB::table('application_setting')->first();
        $key_id = $setting->rozar_key_id;
        $key_secret = $setting->rozar_key_secret;
        $api = new Api($setting->rozar_key_id, $setting->rozar_key_secret);

        $order_id = now()->format('Ymd') . rand(1000, 9999);
        $mainAmount = (int) Session::get('register_ttl_amt');

        dd($mainAmount);
        // If it's 0 or less, show an error or redirect
        if ($mainAmount < 1) {
            return redirect()->back()->with('error', 'Invalid order amount.');
        }

        $razorpayOrder = $api->order->create([
            'receipt'         => 'ORD_' . now()->format('YmdHis'),
            'amount'          => $mainAmount * 100, // converting to paise
            'currency'        => 'INR',
            'payment_capture' => 1
        ]);


        $razorpayOrderId = $razorpayOrder['id'];
        Session::put('razorpay_order_id', $razorpayOrderId);

        $data = [
            "key" => $key_id,
            "amount" => $razorpayOrder['amount'],
            "name" => $order_id,
            "description" => "Event Registration",
            "image" => asset('uploads/logo.png'),
            "prefill" => [
                "name" => Session::get('register_name'),
                "email" => Session::get('register_email'),
                "contact" => Session::get('register_phone')
            ],
            "notes" => [
                "merchant_order_id" => rand(),
            ],
            "theme" => [
                "color" => "#F37254"
            ],
            "order_id" => $razorpayOrderId,
        ];

        return view('front.razorpay_payment_for_event', compact('data'));
    }

    public function handlePayment(Request $request)
    {
        $paymentId = $request->razorpay_payment_id;
        $signature = $request->razorpay_signature;
        $orderId = Session::get('razorpay_order_id');

        // You can verify payment here using Razorpay's signature verification logic
        // and then save the booking/payment info in your database

        // For now, redirect to success page
        return redirect()->route('payment.success')->with('success', 'Payment completed successfully.');
    }


    public function rezorpayPaymentForEvent(Request $request)
    {
        $success = true;
        $error = "Payment failed";

        $key_id = config('services.razorpay.key');
        $key_secret = config('services.razorpay.secret');

        if (!empty($request->razorpay_payment_id)) {
            $api = new Api($key_id, $key_secret);

            try {
                $attributes = [
                    'razorpay_order_id' => Session::get('razorpay_order_id'),
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ];

                $api->utility->verifyPaymentSignature($attributes);

            } catch(\Razorpay\Api\Errors\SignatureVerificationError $e) {
                $success = false;
                $error = $e->getMessage();
            }
        }

        if ($success) {
            // Save booking in DB
            DB::table('event_booking')->insert([
                'booking_name' => Session::get('register_name'),
                'booking_email_id' => Session::get('register_email'),
                'booking_phone_no' => Session::get('register_phone'),
                'booking_addon' => Session::get('register_addon'),
                'booking_ticket' => Session::get('register_ticket'),
                'booking_price' => Session::get('register_ttl_amt'),
                'booking_event_id' => Session::get('register_event_id'),
                'booking_pay_id' => $request->razorpay_payment_id,
                'booking_date' => now()
            ]);

            // TODO: Send Email if required

            return redirect()->route('event.thankyou');
        } else {
            return response()->json(['error' => $error], 400);
        }
    }


    public function eventThankYou()
    {
        return view('front.thank_you');
    }

}
