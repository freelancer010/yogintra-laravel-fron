<?php

namespace App\Support;

class LandingPageCanvas
{
    /**
     * Remove the legacy trainer location row without rewriting the rest of the
     * builder HTML. Existing production copy and formatting remain untouched.
     */
    public static function withoutTrainerLocations(string $html): string
    {
        return preg_replace(
            '#<span\b[^>]*>\s*<i\b[^>]*class=(["\'])[^"\']*\bfa-map-marker\b[^"\']*\1[^>]*>\s*</i>.*?</span>#is',
            '',
            $html
        ) ?? $html;
    }
}
