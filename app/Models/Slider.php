<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'slider'; // Make sure this matches your DB table name
    protected $primaryKey = 'slider_id'; // 👈 ADD THIS LINE

    public $timestamps = false; // optional if you don't use created_at / updated_at
}
