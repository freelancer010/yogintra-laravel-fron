<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Front extends Model
{
    protected $table = 'slider';
    protected $primaryKey = 'slider_id';
    public $timestamps = false;

    public static function getAllSlider()
    {
        return self::where('slider_status', 1)->get();
    }

    public static function getOurFeaturesHeading()
    {
        return \DB::table('our_feature_heading')->where('of_id', 1)->first();
    }

    public static function getAllOurFeatures()
    {
        return \DB::table('our_feature')->get();
    }

    public static function getOurServiceImage()
    {
        return \DB::table('our_service_image')->where('os_image_id', 1)->first();
    }

    public static function getAllOurService()
    {
        return \DB::table('our_service')->get();
    }
}
