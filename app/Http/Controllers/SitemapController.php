<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Front;
use App\Models\Service;
use App\Models\LandingPage;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Yoga;
use App\Models\Event;

class SitemapController extends Controller
{
    public function generate()
    {
        if (app()->environment('local')) {
            return redirect()->back()->with('message', 'Local environment detected, skipping sitemap generation.');
        }
        
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
        $debugMessages = [];

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
            $urls[] = $this->formatUrl(url('/service-details/' . $service->service_slug), '0.80');
        }

        // Landing Pages (from `page_slug`)
        $cities = DB::table('new_landing_page')->select('page_slug')->get();
        foreach ($cities as $city) {
            $urls[] = $this->formatUrl(url('/city/' . $city->page_slug), '0.80');
        }

        // Workshop Pages (from `event`)
        $workshops = Event::where('category', 'Workshop')->where('status', 'On')->orderByDesc('id')->get();
        foreach ($workshops as $workshop) {
            $urls[] = $this->formatUrl(url('/workshop/' . $workshop->link), '0.80');
        }

        // TTC Pages (from `event`)
        $ttcEvents = Event::where('category', 'TTC')->where('status', 'On')->orderByDesc('id')->get();
        foreach ($ttcEvents as $ttc) {
            $urls[] = $this->formatUrl(url('/teacher-training-course/' . $ttc->link), '0.80');
        }

        // Retreat Pages (from `event`)
        $retreats = Event::where('category', 'Retreat')->where('status', 'On')->orderByDesc('id')->get();
        foreach ($retreats as $retreat) {
            $urls[] = $this->formatUrl(url('/Retreat/' . $retreat->link), '0.80');
        }

        // Trainer URLs (from API)
        $trainers = $this->getAllTrainers();
        $trainerCount = 0;
        
        foreach ($trainers as $trainer) {
            if (isset($trainer['id']) && !empty($trainer['id'])) {
                try {
                    $urls[] = $this->formatUrl(url('/trainer/' . $trainer['id']), '0.60');
                    $trainerCount++;
                } catch (\Exception $e) {
                    $debugMessages[] = 'Error adding trainer URL /trainer/' . $trainer['id'] . ': ' . $e->getMessage();
                }
            }
        }
        
        $debugMessages[] = 'Added ' . $trainerCount . ' trainer URLs to sitemap';

        // Render and save
        $xml = view('sitemap.xml', compact('urls'))->render();
        file_put_contents(public_path('sitemap.xml'), $xml);

        // Verify the file was created and get statistics
        if (file_exists(public_path('sitemap.xml'))) {
            $sitemapContent = file_get_contents(public_path('sitemap.xml'));
            $urlCount = substr_count($sitemapContent, '<url>');
            $trainerUrlCount = substr_count($sitemapContent, '/trainer/');
            $debugMessages[] = 'Sitemap generated with ' . $urlCount . ' total URLs (' . $trainerUrlCount . ' trainer URLs)';
        }

        return redirect()->back()->with('success', 'Sitemap generated successfully! ' . implode(' | ', $debugMessages));
    }

    private function formatUrl($loc, $priority = '0.80', $lastmod = null)
    {
        return [
            'loc' => $loc,
            'lastmod' => $lastmod ? Carbon::parse($lastmod)->toAtomString() : Carbon::now()->toAtomString(),
            'priority' => $priority,
        ];
    }
    
    /**
     * Fetch all trainers from the API
     *
     * @return array
     */
    private function getAllTrainers()
    {
        try {
            // Use the same API endpoint as in the GenerateSitemap command
            $api = 'https://crm.yogintra.com/api';
            $data = ['data' => ''];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api . '/getTrainerSearchData');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                return [];
            }

            curl_close($ch);

            $trainers = json_decode($response, true);
            
            if (is_array($trainers)) {
                return $trainers;
            }
            
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }
}
