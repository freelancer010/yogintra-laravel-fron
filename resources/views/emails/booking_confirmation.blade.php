<!doctype html>
<html lang="en-US">
@php
    use Illuminate\Support\Facades\Session;
    use App\Models\Setting;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    $app_setting = Setting::first();
    $event = DB::table('event')->where('id', Session::get('event_id'))->first();
@endphp

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Event Booking Confirmation</title>
    <meta name="description" content="Event Booking Confirmation Email">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style="font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <a href="{{ url('/') }}" title="logo" target="_blank">
                                <img width="190" src="{{ asset($app_setting->app_sticky_logo) }}" title="logo" alt="{{ $app_setting->app_name }}">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="left" cellpadding="0" cellspacing="0" style="max-width:670px; background:#fff; border-radius:3px; text-align:left; box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <main>
                                            <p>Hello {{ $bookingData['name'] }},</p>

                                            <p>
                                                Thank you for booking a seat for our upcoming event. We are thrilled to have you join us!
                                            </p>

                                            <p>
                                                <strong>Event Details:</strong><br>
                                                <strong>Event Name:</strong> {{ $event->title }}<br>
                                                <strong>Date:</strong> {{ Carbon::parse($event->date_time)->format('d-m-Y') }}<br>
                                                <strong>Time:</strong> {{ Carbon::parse($event->date_time)->format('h:i a') }}<br>
                                                <strong>Location:</strong> {{ $event->event_location }}
                                            </p>

                                            <p>
                                                Please keep this confirmation email for your records. If you have any questions or need further assistance, feel free to contact us at <a href="mailto:support@yogintra.com">support@yogintra.com</a>.
                                            </p>

                                            <p>
                                                We look forward to seeing you at the event!
                                            </p>

                                            <p>
                                                Best regards,<br>
                                                YogIntra
                                            </p>
                                        </main>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.74); line-height:18px; margin:0;">&copy; <strong>www.yogintra.com</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>