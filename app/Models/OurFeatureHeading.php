<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurFeatureHeading extends Model
{
    protected $table = 'our_feature_heading';
    protected $primaryKey = 'of_id';
    public $timestamps = false;

    protected $fillable = [
        'of_heading', 'of_sub_heading', 'of_image',
        'extra_image_image_1', 'extra_image_image_2', 'extra_image_image_3'
    ];
}