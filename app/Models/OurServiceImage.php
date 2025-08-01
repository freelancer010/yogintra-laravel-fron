<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurServiceImage extends Model
{
    protected $table = 'our_service_image';
    protected $primaryKey = 'os_image_id';
    
    protected $fillable = [
        'os_image_heading',
        'os_image_sub_heading', 
        'os_image_description',
        'os_image_image'
    ];
}
