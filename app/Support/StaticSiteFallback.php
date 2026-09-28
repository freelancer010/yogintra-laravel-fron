<?php

namespace App\Support;

class StaticSiteFallback
{
    public static function settings(): object
    {
        return (object) [
            'app_name' => 'YogIntra',
            'app_meta_title' => 'Yoga Classes & Training in India | YogIntra',
            'app_meta_description' => 'YogIntra offers guided yoga, meditation and wellness classes online, at home and near you.',
            'app_keywords' => 'yoga, online yoga classes, home yoga sessions, wellness, YogIntra',
            'app_sticky_logo' => 'uploads/6522371db10e06501ab36d6f70Rectrangular-logo-2.png',
            'app_footer_logo' => 'uploads/6522371db10e06501ab36d6f70Rectrangular-logo-2.png',
            'fevicon' => 'assets/og-logo.webp',
            'footer_about_us' => 'YogIntra helps promote balanced physical, mental and spiritual wellbeing.',
            'hero_media_type' => 'slider',
            'hero_video' => null,
            'hero_video_thumbnail' => null,
            'hero_video_heading' => null,
            'hero_video_title' => null,
            'hero_video_sub_heading' => null,
            'hero_video_description' => null,
            'hero_video_btn_name' => null,
            'hero_video_btn_link' => null,
            'hero_video_text_direction' => 'left',
            'section3_background_image' => null,
            'section3_padding_y' => 70,
            'section3_heading' => 'Yoga services for every stage of your practice',
            'section3_description' => 'Choose a class that fits your goals, schedule and experience.',
            'section3_fixed_card_images' => '{}',
            'section3_card_bullets' => '{}',
            'section3_card_buttons' => '{}',
        ];
    }

    public static function visualSettings(): object
    {
        return (object) ['color_1' => '#087782', 'color_2' => '#e07f00'];
    }

    public static function sliders()
    {
        return collect([(object) [
            'slider_image' => 'assets/Mobile-Banner-new.webp',
            'slider_heading' => 'Yoga and meditation for busy people',
            'slider_sub_heading' => 'Personalised guidance for a healthier, more balanced life.',
            'slider_btn_name' => 'Explore classes',
            'slider_btn_link' => '/service',
        ]]);
    }

    public static function featureHeading(): object
    {
        return (object) [
            'of_image' => 'assets/pattern-chakras-alt-color.webp',
            'of_heading' => 'Build a practice that works for you',
            'of_sub_heading' => 'Thoughtful guidance, wherever you are',
        ];
    }

    public static function features()
    {
        return collect([
            (object) ['of_image' => 'assets/icon-thumb1-150x150.webp', 'of_heading' => 'Personal guidance', 'of_description' => 'Instructor-led sessions shaped around your needs.'],
            (object) ['of_image' => 'assets/icon-thumb4-150x150.jpg', 'of_heading' => 'Flexible practice', 'of_description' => 'Online and in-person options that fit your schedule.'],
        ]);
    }

    public static function serviceHeading(): object
    {
        return (object) [
            'os_image_image' => 'assets/icon-thumb1-150x150.webp',
            'os_image_sub_heading' => 'Find your practice',
            'os_image_heading' => 'Yoga for everyday wellbeing',
            'os_image_description' => 'Explore mindful movement, breathing, flexibility and relaxation with experienced guidance.',
        ];
    }

    public static function serviceItems()
    {
        return collect([
            (object) ['os_image' => 'assets/icon-thumb1-150x150.webp', 'os_heading' => 'Online Yoga'],
            (object) ['os_image' => 'assets/icon-thumb4-150x150.jpg', 'os_heading' => 'Home Yoga'],
            (object) ['os_image' => 'assets/icon-thumb2-150x150.jpg', 'os_heading' => 'Wellness'],
        ]);
    }
}
