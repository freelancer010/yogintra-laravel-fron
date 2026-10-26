<?php

use App\Support\SocialMedia;

it('returns configured social links in the frontend display order', function () {
    $settings = (object) [
        'facebook' => 'https://facebook.com/custom-page',
        'instagram' => 'instagram.com/custom-profile',
        'linkedin' => '',
        'twitter' => null,
        'youtube' => 'https://youtube.com/@custom-channel',
        'telegram' => 'https://t.me/custom-profile',
    ];

    expect(SocialMedia::links($settings))->toMatchArray([
        'facebook' => [
            'label' => 'Facebook',
            'icon' => 'facebook',
            'url' => 'https://facebook.com/custom-page',
        ],
        'instagram' => [
            'label' => 'Instagram',
            'icon' => 'instagram',
            'url' => 'https://instagram.com/custom-profile',
        ],
        'youtube' => [
            'label' => 'YouTube',
            'icon' => 'youtube',
            'url' => 'https://youtube.com/@custom-channel',
        ],
        'telegram' => [
            'label' => 'Telegram',
            'icon' => 'telegram',
            'url' => 'https://t.me/custom-profile',
        ],
    ]);

    expect(SocialMedia::urls($settings))->toBe([
        'https://facebook.com/custom-page',
        'https://instagram.com/custom-profile',
        'https://youtube.com/@custom-channel',
        'https://t.me/custom-profile',
    ]);
});

it('omits empty and unsafe social link values', function () {
    $settings = (object) [
        'facebook' => 'javascript:alert(1)',
        'instagram' => 'not a valid host',
        'linkedin' => '   ',
        'twitter' => 'ftp://example.com/profile',
        'youtube' => null,
        'telegram' => null,
    ];

    expect(SocialMedia::links($settings))->toBe([]);
});
