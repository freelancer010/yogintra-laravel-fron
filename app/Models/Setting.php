<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'application_setting';
    protected $primaryKey = 'app_id';
    public $timestamps = false;

    public static function getAllAppSetting()
    {
        return self::where('app_id', 1)->first();
    }
}
