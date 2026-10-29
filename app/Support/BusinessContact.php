<?php

namespace App\Support;

final class BusinessContact
{
    /**
     * Normalize the public business contact details from Application Settings.
     * Both visible NAP content and JSON-LD use this same result.
     *
     * @return array<string, mixed>
     */
    public static function fromSetting(?object $setting): array
    {
        $streetAddress = self::text($setting?->app_address ?? null);
        $locality = self::text($setting?->app_address_locality ?? null);
        $region = self::text($setting?->app_address_region ?? null);
        $postalCode = self::text($setting?->app_postal_code ?? null);
        $country = strtoupper(self::text($setting?->app_address_country ?? null));
        $telephone = self::text($setting?->app_mobile ?? null);
        $email = self::text($setting?->app_email ?? null);

        if ($postalCode === '' && preg_match('/\b[1-9][0-9]{5}\b/', $streetAddress, $matches)) {
            $postalCode = $matches[0];
        }

        $addressParts = array_values(array_filter(
            [$streetAddress, $locality, $region, $postalCode],
            static fn (string $value): bool => $value !== ''
        ));
        $visibleAddress = '';

        foreach ($addressParts as $part) {
            if ($visibleAddress === '' || ! str_contains(mb_strtolower($visibleAddress), mb_strtolower($part))) {
                $visibleAddress .= ($visibleAddress === '' ? '' : ', ') . $part;
            }
        }

        $postalAddress = array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $streetAddress ?: null,
            'addressLocality' => $locality ?: null,
            'addressRegion' => $region ?: null,
            'postalCode' => $postalCode ?: null,
            'addressCountry' => $country ?: null,
        ], static fn ($value): bool => $value !== null && $value !== '');

        if (count($postalAddress) === 1) {
            $postalAddress = null;
        }

        $mapQuery = implode(', ', array_values(array_filter([
            $visibleAddress,
            $country,
        ], static fn (string $value): bool => $value !== '')));
        $telephoneDigits = preg_replace('/\D+/', '', $telephone) ?? '';
        $isUnqualifiedIndianNumber = $telephoneDigits !== ''
            && strlen($telephoneDigits) === 10
            && ! str_starts_with($telephone, '+')
            && ($country === '' || $country === 'IN');

        if ($isUnqualifiedIndianNumber) {
            $telephone = '+91-' . $telephoneDigits;
            $telephoneHref = '+91' . $telephoneDigits;
        } else {
            $telephoneHref = $telephoneDigits === ''
                ? null
                : (str_starts_with($telephone, '+') ? '+' : '') . $telephoneDigits;
        }

        return [
            'street_address' => $streetAddress,
            'locality' => $locality,
            'region' => $region,
            'postal_code' => $postalCode,
            'country' => $country,
            'visible_address' => $visibleAddress,
            'postal_address' => $postalAddress,
            'map_url' => $mapQuery === ''
                ? null
                : 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($mapQuery),
            'telephone' => $telephone,
            'telephone_href' => $telephoneHref,
            'email' => $email,
        ];
    }

    private static function text(mixed $value): string
    {
        $text = html_entity_decode(strip_tags((string) $value), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $text) ?? '');
    }
}
