<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurFeature extends Model
{
    protected $table = 'our_feature'; // or the actual table name you use
    protected $primaryKey = 'of_id';
    public $timestamps = false;

    protected $fillable = [
        'of_heading',
        'of_description',
        'of_image',
    ];
}
