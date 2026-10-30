<?php

namespace App\Support;

final class LandingPageHeadCode
{
    /**
     * Keep complete head tags unchanged, but make pasted raw JSON-LD valid.
     *
     * Browsers move unwrapped JSON text out of <head> and into <body>, where
     * it becomes visible above the landing-page canvas. Normalizing it only
     * at render time preserves the exact value saved by the page builder.
     */
    public static function normalize(?string $code): string
    {
        $code = trim((string) $code);
        if ($code === '') {
            return '';
        }

        $json = html_entity_decode($code, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $schema = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($schema) || ! self::isSchema($schema)) {
            return $code;
        }

        $encoded = json_encode(
            $schema,
            JSON_UNESCAPED_SLASHES
                | JSON_UNESCAPED_UNICODE
                | JSON_HEX_TAG
                | JSON_HEX_AMP
                | JSON_HEX_APOS
                | JSON_HEX_QUOT
        );

        return '<script type="application/ld+json">' . $encoded . '</script>';
    }

    private static function isSchema(array $value): bool
    {
        if (array_key_exists('@context', $value) || array_key_exists('@type', $value)) {
            return true;
        }

        foreach ($value as $item) {
            if (is_array($item) && (array_key_exists('@context', $item) || array_key_exists('@type', $item))) {
                return true;
            }
        }

        return false;
    }
}
