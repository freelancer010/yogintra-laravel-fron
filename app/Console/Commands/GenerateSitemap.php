<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Blog; // adjust based on your Blog model location
use App\Models\Workshop; // if needed
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate dynamic sitemap';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Static pages
        $staticUrls = [
            '/',
            '/about',
            '/gallery',
            '/contact',
            '/blog',
            '/workshop',
        ];

        foreach ($staticUrls as $url) {
            $sitemap->add(Url::create($url)->setLastModificationDate(now()));
        }

        // Dynamic blogs
        $blogs = Blog::where('blog_status', 1)->get();
        foreach ($blogs as $blog) {
            $sitemap->add(
                Url::create("/blog/{$blog->blog_slug}")
                    ->setLastModificationDate(Carbon::parse($blog->updated_at))
            );
        }

        // Save to public path
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
