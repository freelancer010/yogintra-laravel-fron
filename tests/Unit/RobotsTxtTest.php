<?php

namespace Tests\Unit;

use App\Support\RobotsTxt;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class RobotsTxtTest extends TestCase
{
    public function test_it_preserves_existing_rules_and_adds_search_bot_directives(): void
    {
        $path = storage_path('framework/testing/robots-' . uniqid() . '.txt');
        File::ensureDirectoryExists(dirname($path));
        File::put($path, "User-agent: *\nDisallow: /admin\n");

        RobotsTxt::ensureSearchBotDirectives($path);

        $contents = File::get($path);

        $this->assertStringContainsString("User-agent: *\nDisallow: /admin", $contents);
        $this->assertStringContainsString("User-agent: OAI-SearchBot\nAllow: /", $contents);
        $this->assertStringContainsString('Sitemap: https://yogintra.com/sitemap.xml', $contents);

        File::delete($path);
    }

    public function test_it_does_not_duplicate_directives_when_run_repeatedly(): void
    {
        $path = storage_path('framework/testing/robots-' . uniqid() . '.txt');
        File::ensureDirectoryExists(dirname($path));
        File::put($path, "User-agent: OAI-SearchBot\nAllow: /\n\nSitemap: https://yogintra.com/sitemap.xml\n");

        RobotsTxt::ensureSearchBotDirectives($path);
        RobotsTxt::ensureSearchBotDirectives($path);

        $contents = File::get($path);

        $this->assertSame(1, substr_count($contents, 'User-agent: OAI-SearchBot'));
        $this->assertSame(1, substr_count($contents, 'Sitemap: https://yogintra.com/sitemap.xml'));

        File::delete($path);
    }
}
