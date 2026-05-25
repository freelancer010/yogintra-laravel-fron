<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    use HasFactory;
    
    protected $table = 'application_setting';
    protected $primaryKey = 'app_id';
    public $timestamps = false;
    protected $fillable = [
        'app_name', 'app_keywords', 'app_meta_title', 'app_meta_description',
        'app_description', 'app_sticky_logo', 'app_footer_logo', 'app_address',
        'app_email', 'app_mobile', 'footer_about_us', 'facebook', 'twitter',
        'fevicon', 'rozar_key_id', 'rozar_key_secret', 'head_code', 'youtube',
        'instagram', 'telegram', 'linkedin', 'google_client_id',
        'google_client_secret', 'mail_host', 'mail_port', 'mail_username',
        'mail_password', 'map_iframe'
    ];
}

class Blog extends Model
{
    use HasFactory;
    
    protected $table = 'blog';
    protected $primaryKey = 'blog_id';
    public $timestamps = false;
    protected $fillable = [
        'blog_category', 'blog_title', 'blog_slug', 'blog_content',
        'blog_meta_keywords', 'blog_meta_description', 'blog_short_description',
        'blog_image', 'blog_view', 'breaking', 'blog_author', 'blog_like',
        'blog_dislike', 'blog_love', 'blog_wow', 'blog_funny', 'blog_angry',
        'created_at', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category', 'id');
    }
}

class BlogCategory extends Model
{
    use HasFactory;
    
    protected $table = 'blog_category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'category_name', 'category_slug', 'category_keyword', 'category_description', 'category_status'
    ];
}

class Event extends Model
{
    use HasFactory;
    
    protected $table = 'event';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'category', 'title', 'link', 'keyword', 'description', 'image',
        'short_content', 'content', 'active', 'date_time', 'end_date_time',
        'event_mode', 'main_price', 'discount_price', 'country', 'state', 'city',
        'pin_code', 'event_location', 'head_code', 'event_host_by', 'addon_name',
        'addon_price', 'ticket_indian', 'ticket_short_des_indian', 'ticket_price_indian',
        'ticket_capacity_indian', 'ticket_d_qnty_indian', 'ticket_r_qnty_indian',
        'ticket_foreigner', 'ticket_short_des_foreigner', 'ticket_price_foreigner',
        'ticket_capacity_foreigner', 'ticket_d_qnty_foreigner', 'ticket_r_qnty_foreigner',
        'Indian_stu_checkbox', 'Foreign_stu_checkbox', 'Extra_addon_checkbox', 'status'
    ];
}

class EventBooking extends Model
{
    use HasFactory;
    
    protected $table = 'event_booking';
    protected $primaryKey = 'booking_id';
    public $timestamps = false;
    protected $fillable = [
        'booking_name', 'booking_email_id', 'booking_phone_no', 'booking_addon',
        'booking_ticket', 'booking_price', 'booking_event_id', 'booking_pay_id', 'booking_date'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'booking_event_id', 'id');
    }
}

// class User extends Model
// {
//     use HasFactory;
    
//     protected $table = 'users';
//     protected $primaryKey = 'user_id';
//     public $timestamps = false;
//     protected $fillable = [
//         'user_name', 'user_mobile', 'user_email', 'user_password', 'user_role',
//         'user_photo', 'user_is_online', 'user_token', 'is_employee', 'user_status', 'user_created_at'
//     ];
// }
