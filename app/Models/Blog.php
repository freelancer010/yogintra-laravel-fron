<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blog';
    protected $primaryKey = 'blog_id';
    public $timestamps = false;

    protected $fillable = [
        'blog_title', 'blog_slug', 'blog_author', 'blog_short_description',
        'blog_meta_keywords', 'blog_meta_description', 'blog_content',
        'blog_category', 'blog_image', 'created_at', 'status', 'blog_view', 
        'blog_like', 'blog_dislike', 'blog_love', 'blog_wow', 'blog_funny', 
        'blog_angry'
    ];

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
    
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category');
    }
}
