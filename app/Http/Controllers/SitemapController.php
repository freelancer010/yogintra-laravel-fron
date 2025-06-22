<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SitemapController extends Controller
{
    public function generate()
    {
        $staticUrls = [
            '/',
            '/about',
            '/gallery',
            '/trainers',
            '/contact',
            '/blog',
            '/retreat',
            '/workshop',
            '/teacher-training-course',
            '/yoga-center',
            '/become-yoga-trainer',
        ];

        $urls = [];

        // Static pages
        foreach ($staticUrls as $url) {
            $urls[] = $this->formatUrl(url($url));
        }

        // Blog URLs (from `blog_slug`)
        $blogs = DB::table('blog')->where('status', 1)->select('blog_slug', 'created_at')->get();
        foreach ($blogs as $blog) {
            $urls[] = $this->formatUrl(url('/blog/' . $blog->blog_slug), '0.64', $blog->created_at);
        }

        // Service URLs (from `service_slug`)
        $services = DB::table('service')->select('service_slug')->get();
        foreach ($services as $service) {
            $urls[] = $this->formatUrl(url('/service/' . $service->service_slug), '0.80');
        }

        // Landing Pages (from `page_slug`)
        $cities = DB::table('new_landing_page')->select('page_slug')->get();
        foreach ($cities as $city) {
            $urls[] = $this->formatUrl(url('/city/' . $city->page_slug), '0.80');
        }

        // Render and save
        $xml = view('sitemap.xml', compact('urls'))->render();
        file_put_contents(public_path('sitemap.xml'), $xml);

        return response()->json(['message' => 'Sitemap generated successfully!']);
    }

    private function formatUrl($loc, $priority = '0.80', $lastmod = null)
    {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod ? Carbon::parse($lastmod)->toAtomString() : Carbon::now()->toAtomString(),
            'priority' => $priority,
        ];
    }
}
