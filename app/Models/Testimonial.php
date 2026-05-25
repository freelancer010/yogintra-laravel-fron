<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';
    protected $primaryKey = 'test_id';
    protected $fillable = ['test_name', 'test_position', 'test_review', 'test_description', 'test_image'];
    public $timestamps = false;
}
