<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurService extends Model
{
    protected $table = 'our_service';
    protected $primaryKey = 'os_id';
    public $timestamps = false; // Disable automatic timestamps
    
    protected $fillable = [
        'os_heading',
        'os_image'
    ];
}
