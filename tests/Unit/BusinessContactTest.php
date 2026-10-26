<?php

use App\Support\BusinessContact;

test('it builds visible and structured contact data from application settings', function () {
    $contact = BusinessContact::fromSetting((object) [
        'app_address' => 'D-408 Shivlila Apt, Mumbra Devi Colony Road, Diva East',
        'app_address_locality' => 'Thane',
        'app_address_region' => 'Maharashtra',
        'app_postal_code' => '400612',
        'app_address_country' => 'in',
        'app_mobile' => '+91 98672 91573',
        'app_email' => 'support@yogintra.com',
    ]);

    expect($contact['visible_address'])
        ->toBe('D-408 Shivlila Apt, Mumbra Devi Colony Road, Diva East, Thane, Maharashtra, 400612')
        ->and($contact['postal_address'])->toMatchArray([
            '@type' => 'PostalAddress',
            'streetAddress' => 'D-408 Shivlila Apt, Mumbra Devi Colony Road, Diva East',
            'addressLocality' => 'Thane',
            'addressRegion' => 'Maharashtra',
            'postalCode' => '400612',
            'addressCountry' => 'IN',
        ])
        ->and($contact['telephone_href'])->toBe('+919867291573')
        ->and($contact['map_url'])->toContain('google.com/maps/search/');
});

test('it extracts an Indian postal code from an existing full address', function () {
    $contact = BusinessContact::fromSetting((object) [
        'app_address' => 'Diva East, Thane-400612',
        'app_mobile' => '',
        'app_email' => '',
    ]);

    expect($contact['postal_code'])->toBe('400612')
        ->and($contact['visible_address'])->toBe('Diva East, Thane-400612')
        ->and($contact['postal_address']['postalCode'])->toBe('400612');
});
