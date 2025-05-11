<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'gallery';
    protected $primaryKey = 'gallery_id';
    public $timestamps = false;

    public static function getAllGallery()
    {
        return self::all();
    }

    public static function getAllCategory()
    {
        return \DB::table('gallery_category')->get();
    }
}
