<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $table = 'new_landing_page'; // Ensure correct table name
    protected $fillable = ['page_name', 'page_slug'];
    public $timestamps = false; // If no timestamps exist
}
