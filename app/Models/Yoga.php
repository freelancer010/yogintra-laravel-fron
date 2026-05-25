<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Yoga extends Model
{
    protected $table = 'yoga_center';
    protected $primaryKey = 'center_id';
    public $timestamps = false;

    // ✅ Get all published centers
    public static function getAll()
    {
        return DB::table('yoga_center')->orderByDesc('center_id')->get();
    }

    // ✅ Get single center by slug
    public static function getBySlug($slug)
    {
        return DB::table('yoga_center')->where('center_slug', $slug)->first();
    }

    // ✅ Get single center by ID
    public static function getById($id)
    {
        return DB::table('yoga_center')->where('center_id', $id)->first();
    }

    // ✅ Add new center (optional – for admin side)
    public static function add($data)
    {
        return DB::table('yoga_center')->insert($data);
    }

    // ✅ Update existing center (optional – for admin side)
    public static function updateById($id, $data)
    {
        return DB::table('yoga_center')->where('center_id', $id)->update($data);
    }

    // ✅ Delete a center
    public static function deleteById($id)
    {
        return DB::table('yoga_center')->where('center_id', $id)->delete();
    }
}
