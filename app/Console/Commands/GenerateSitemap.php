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
            '/trainers',
            '/contact',
            '/blog',
            '/retreat',
            '/workshop',
            '/teacher-training-course',
            '/yoga-center',
            '/become-yoga-trainer',
        ];

        foreach ($staticUrls as $url) {
            $sitemap->add(Url::create($url)->setLastModificationDate(now()));
        }

        // Dynamic blogs
        $blogs = Blog::where('status', 1)->get();
        foreach ($blogs as $blog) {
            $sitemap->add(
                Url::create("/blog/{$blog->blog_slug}")
                    ->setLastModificationDate(Carbon::parse($blog->created_at))
            );
        }

        // Dynamic trainer profiles
        $trainers = $this->getAllTrainers();
        
        $trainerCount = 0;
        foreach ($trainers as $trainer) {
            if (isset($trainer['id']) && !empty($trainer['id'])) {
                try {
                    $sitemap->add(
                        Url::create("/trainer/{$trainer['id']}")
                            ->setLastModificationDate(now())
                            ->setPriority(0.6)
                    );
                    $trainerCount++;
                } catch (\Exception $e) {
                    $this->error('Error adding trainer URL /trainer/' . $trainer['id'] . ': ' . $e->getMessage());
                }
            }
        }
        
        $this->info('Added ' . $trainerCount . ' trainer URLs to sitemap');

        // Save to public path
        try {
            $sitemap->writeToFile(public_path('sitemap.xml'));
            
            // Verify the file was created and get statistics
            if (file_exists(public_path('sitemap.xml'))) {
                $sitemapContent = file_get_contents(public_path('sitemap.xml'));
                $urlCount = substr_count($sitemapContent, '<url>');
                $trainerUrlCount = substr_count($sitemapContent, '/trainer/');
                $this->info('Sitemap generated successfully with ' . $urlCount . ' total URLs (' . $trainerUrlCount . ' trainer URLs)');
            } else {
                $this->error('Sitemap file was not created!');
            }
        } catch (\Exception $e) {
            $this->error('Error writing sitemap: ' . $e->getMessage());
        }
    }

    /**
     * Fetch all trainers from the API
     *
     * @return array
     */
    private function getAllTrainers()
    {
        try {
            // Use the same API endpoint as HomeController
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
                $this->error('cURL Error: ' . curl_error($ch));
                curl_close($ch);
                return [];
            }

            curl_close($ch);

            $trainers = json_decode($response, true);
            
            if (is_array($trainers)) {
                $this->info('Found ' . count($trainers) . ' trainers for sitemap');
                return $trainers;
            }
            
            $this->error('Invalid response format from trainer API');
            return [];
        } catch (\Exception $e) {
            $this->error('Error fetching trainers: ' . $e->getMessage());
            return [];
        }
    }
}
