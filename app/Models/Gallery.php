<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gallery extends Model
{
    protected $table = 'gallery';
    protected $primaryKey = 'gallery_id';
    public $timestamps = false;

    /**
     * Fetch all gallery items with joined category name.
     */
    public static function getAllGallery()
    {
        return DB::table('gallery as a')
            ->leftJoin('gallery_category as b', 'b.g_cat_id', '=', 'a.gallery_category')
            ->select('a.*', 'b.g_cat_name')
            ->get();
    }

    /**
     * Fetch all gallery categories.
     */
    public static function getAllCategory()
    {
        return DB::table('gallery_category')->get();
    }

    /**
     * Add new gallery category.
     */
    public static function addCategory($name)
    {
        return DB::table('gallery_category')->insert([
            'g_cat_name' => $name
        ]);
    }

    /**
     * Update gallery category.
     */
    public static function updateCategory($id, $name)
    {
        return DB::table('gallery_category')
            ->where('g_cat_id', $id)
            ->update(['g_cat_name' => $name]);
    }

    /**
     * Delete category if no gallery items are linked to it.
     */
    public static function deleteCategory($id)
    {
        $count = DB::table('gallery')->where('gallery_category', $id)->count();

        if ($count > 0) {
            return false;
        }

        return DB::table('gallery_category')->where('g_cat_id', $id)->delete();
    }
}
