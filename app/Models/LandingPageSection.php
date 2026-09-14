<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSection extends Model
{
    protected $fillable = [
        'landing_page_id', 'section_type', 'heading', 'content', 'image', 'image_alt',
        'button_text', 'button_url', 'background_color', 'background_mode', 'background_image', 'background_position', 'background_parallax', 'background_overlay_color', 'background_overlay_opacity', 'text_color', 'heading_size', 'description_color', 'description_size', 'text_align', 'element_styles', 'blocks', 'elements', 'grid_columns', 'card_layout', 'card_alignment', 'grid_gap', 'image_position', 'image_size', 'padding_x', 'padding_y', 'margin_x', 'margin_y', 'sort_order',
    ];
}
