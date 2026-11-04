<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

final class RobotsTxt
{
    private const OPENAI_SEARCH_BLOCK = "User-agent: OAI-SearchBot\nAllow: /";

    private const SITEMAP_DIRECTIVE = 'Sitemap: https://yogintra.com/sitemap.xml';

    public static function ensureSearchBotDirectives(?string $path = null): void
    {
        $path ??= public_path('robots.txt');
        $contents = File::exists($path) ? File::get($path) : '';
        $contents = str_replace(["\r\n", "\r"], "\n", $contents);

        if (!str_contains($contents, self::OPENAI_SEARCH_BLOCK)) {
            $contents = self::appendBlock($contents, self::OPENAI_SEARCH_BLOCK);
        }

        if (!preg_match('/^' . preg_quote(self::SITEMAP_DIRECTIVE, '/') . '$/mi', $contents)) {
            $contents = self::appendBlock($contents, self::SITEMAP_DIRECTIVE);
        }

        $contents = rtrim($contents) . "\n";

        if (!File::exists($path) || File::get($path) !== $contents) {
            File::put($path, $contents, true);
        }
    }

    private static function appendBlock(string $contents, string $block): string
    {
        $contents = rtrim($contents);

        return $contents === '' ? $block : $contents . "\n\n" . $block;
    }
}
