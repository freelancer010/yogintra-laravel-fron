<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yoga extends Model
{
    protected $table = 'yoga_center';
    protected $primaryKey = 'center_id';
    public $timestamps = false;
}
