<?php

namespace App\Support;

final class SocialMedia
{
    private const NETWORKS = [
        'facebook' => ['label' => 'Facebook', 'icon' => 'facebook'],
        'instagram' => ['label' => 'Instagram', 'icon' => 'instagram'],
        'linkedin' => ['label' => 'LinkedIn', 'icon' => 'linkedin'],
        'twitter' => ['label' => 'Twitter', 'icon' => 'twitter'],
        'youtube' => ['label' => 'YouTube', 'icon' => 'youtube'],
        'telegram' => ['label' => 'Telegram', 'icon' => 'telegram'],
    ];

    /**
     * Return safe, non-empty social profiles configured in Application Setting.
     *
     * Values saved without a scheme are normalized to HTTPS so older settings
     * continue to work. Invalid and unsafe values are omitted from public HTML.
     */
    public static function links(?object $settings): array
    {
        if ($settings === null) {
            return [];
        }

        $links = [];

        foreach (self::NETWORKS as $field => $metadata) {
            $url = self::normalizeUrl($settings->{$field} ?? null);

            if ($url === null) {
                continue;
            }

            $links[$field] = [...$metadata, 'url' => $url];
        }

        return $links;
    }

    public static function urls(?object $settings): array
    {
        return array_values(array_column(self::links($settings), 'url'));
    }

    private static function normalizeUrl(mixed $value): ?string
    {
        $url = trim((string) $value);

        if ($url === '') {
            return null;
        }

        if (preg_match('#^[a-z][a-z0-9+.-]*:#i', $url) && ! preg_match('#^https?://#i', $url)) {
            return null;
        }

        if (! preg_match('#^https?://#i', $url)) {
            $url = 'https://' . ltrim($url, '/');
        }

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https'], true) ? $url : null;
    }
}
