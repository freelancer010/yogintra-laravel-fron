<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $table = 'blog_category';
    public $timestamps = false;

    protected $fillable = [
        'category_name',
        'category_slug',
        'category_keyword',
        'category_description',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blog_category');
    }
}
