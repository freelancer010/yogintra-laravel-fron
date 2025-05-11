<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service_category';
    protected $primaryKey = 'service_cat_id';
    public $timestamps = false;

    public static function getSixCategoryForHomePage()
    {
        return self::limit(6)->get();
    }
}
