<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    use HasFactory;

    protected $table = 'widgets';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'content',
        'widget_order'
    ];
}
