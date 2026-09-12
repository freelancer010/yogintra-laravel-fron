<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $table = 'new_landing_page';
    protected $primaryKey = 'page_id';
    protected $fillable = ['page_name', 'page_slug'];
    public $timestamps = false;

    public function sections()
    {
        return $this->hasMany(LandingPageSection::class, 'landing_page_id', 'page_id')
            ->orderBy('sort_order');
    }
}
