<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'id'; // default in Laravel, but stating for clarity
    public $timestamps = false;

    // ✅ Get all latest events (like CI's get_all_latest_event)
    public static function getLatestEvents($limit = 12)
    {
        return self::whereDate('date_time', '>=', now())
                    ->orderByDesc('id')
                    ->limit($limit)
                    ->get();
    }

    // ✅ Get all events by category for homepage (like get_all_event_for_home_page)
    public static function getAllEventsForHomePage($category)
    {
        return self::where('category', $category)
                    ->where('status', 'On')
                    ->orderByDesc('id')
                    ->get();
    }

    // ✅ Get all events
    public static function getAllEvents()
    {
        return self::orderByDesc('id')->get();
    }

    // ✅ Get event by slug (like get_event_by_slug)
    public static function getBySlug($slug)
    {
        return self::where('link', $slug)->first();
    }

    // ✅ Get event by ID
    public static function getById($id)
    {
        return self::find($id);
    }

    // ✅ Delete with image file (like delete_event)
    public static function deleteWithImage($id)
    {
        $event = self::find($id);
        if ($event && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));
        }
        return $event?->delete();
    }

    // ✅ Join for booking info (like get_all_event_booking)
    public static function getAllEventBookings()
    {
        return DB::table('event_booking as a')
            ->join('event as b', 'b.id', '=', 'a.booking_event_id')
            ->select('a.*', 'b.title', 'b.category', 'b.addon_name')
            ->get();
    }
}
