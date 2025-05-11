<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog';
    protected $primaryKey = 'blog_id';
    public $timestamps = false;

    public static function getAllBlogsForHomePage()
    {
        return self::orderBy('blog_id', 'desc')->get();
    }

    public static function getAllBlogCategory()
    {
        return \DB::table('blog_category')->get();
    }

    public static function getBlogBySlug($slug)
    {
        return self::where('blog_slug', $slug)->first();
    }
}
