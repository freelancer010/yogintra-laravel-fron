<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    protected $table = 'service_category';
    protected $primaryKey = 'service_id';
    public $timestamps = false;


    
    public static function getSixCategoryForHomePage()
    {
        return self::limit(6)->get();
    }

    
    public static function getServiceCategoryBySlug($slug)
    {
        return DB::table('service_category')->where('service_cat_slug', $slug)->first();
    }

    public static function getAllServiceByCategoryId($categoryId)
    {
        return DB::table('service')
            ->where('Service_category', $categoryId)
            ->get();
    }

    public static function getServiceBySlug($slug)
    {
        return DB::table('service as a')
            ->join('service_category as b', 'b.service_cat_id', '=', 'a.service_category')
            ->where('a.service_slug', $slug)
            ->select('a.*', 'b.service_cat_name', 'b.service_cat_slug')
            ->first();
    }

    public static function getServiceByCategoryAndSlug(string $categorySlug, string $serviceSlug)
    {
        $storedSlugs = array_values(array_unique([$serviceSlug, $serviceSlug . '-class']));

        return DB::table('service as a')
            ->join('service_category as b', 'b.service_cat_id', '=', 'a.service_category')
            ->where('b.service_cat_slug', $categorySlug)
            ->whereIn('a.service_slug', $storedSlugs)
            ->orderByRaw('CASE WHEN a.service_slug = ? THEN 0 ELSE 1 END', [$serviceSlug])
            ->select('a.*', 'b.service_cat_name', 'b.service_cat_slug')
            ->first();
    }

    public static function publicServiceSlug(string $serviceSlug): string
    {
        return preg_replace('/-class$/i', '', trim($serviceSlug)) ?: trim($serviceSlug);
    }
}
