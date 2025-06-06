<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'comment',
        'post_id',
        'ip',
        'status',
        'date'
    ];
}
