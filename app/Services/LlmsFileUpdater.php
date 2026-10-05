<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LlmsFileUpdater
{
    /** Refresh the City section without disturbing the curated sections. */
    public function refreshLandingPages(): void
    {
        $path = public_path('llms.txt');
        if (!File::exists($path)) {
            return;
        }

        $content = File::get($path);
        $baseUrl = 'https://yogintra.com';
        if (preg_match('#\[Homepage\]\((https?://[^/)]+)#i', $content, $match)) {
            $baseUrl = rtrim($match[1], '/');
        }

        $pages = DB::table('new_landing_page')
            ->where('is_published', true)
            ->whereNotNull('page_slug')
            ->where('page_slug', '!=', '')
            ->orderBy('page_name')
            ->get(['page_name', 'page_slug', 'page_meta_title']);

        $lines = $pages->map(function (object $page) use ($baseUrl): string {
            $name = $this->markdownText((string) ($page->page_name ?: $page->page_slug));
            $title = $this->markdownText((string) ($page->page_meta_title ?: $page->page_name));
            $slug = trim((string) $page->page_slug, '/');

            return '- [' . $name . '](' . $baseUrl . '/city/' . $slug . '): ' . $title;
        })->implode(PHP_EOL);

        $citySection = '## City' . PHP_EOL . PHP_EOL . $lines . PHP_EOL . PHP_EOL;
        $updated = preg_replace(
            '/## City\R[\s\S]*?(?=## |\z)/',
            $citySection,
            $content,
            1,
            $replacements
        );

        if (!$replacements) {
            $updated = rtrim($content) . PHP_EOL . PHP_EOL . $citySection;
        }

        if (is_string($updated) && $updated !== $content) {
            File::replace($path, $updated);
        }
    }

    private function markdownText(string $value): string
    {
        $value = trim(preg_replace('/\s+/', ' ', strip_tags($value)) ?? '');

        return str_replace(['\\', '[', ']', '(', ')'], ['\\\\', '\\[', '\\]', '\\(', '\\)'], $value);
    }
}
