<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSection extends Model
{
    protected $fillable = [
        'landing_page_id', 'section_type', 'heading', 'content', 'image', 'image_alt',
        'button_text', 'button_url', 'background_color', 'image_position', 'padding_y', 'margin_y', 'sort_order',
    ];
}
