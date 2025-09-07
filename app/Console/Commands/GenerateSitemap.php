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
        $this->info('Processing ' . count($trainers) . ' trainers for sitemap');
        
        foreach ($trainers as $trainer) {
            if (isset($trainer['id']) && !empty($trainer['id'])) {
                $trainerUrl = "https://yogintra.com/trainer/{$trainer['id']}";
                $this->info('Adding trainer URL: ' . $trainerUrl);
                $sitemap->add(
                    Url::create("/trainer/{$trainer['id']}")
                        ->setLastModificationDate(now())
                        ->setPriority(0.6)
                );
            }
        }

        // Save to public path
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
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

            $this->info('Fetching trainers from: ' . $api . '/getTrainerSearchData');

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

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $this->info('API Response HTTP Code: ' . $httpCode);
            $this->info('API Response Length: ' . strlen($response));

            $trainers = json_decode($response, true);
            
            if (is_array($trainers)) {
                $this->info('Found ' . count($trainers) . ' trainers for sitemap');
                
                // Debug: Show first trainer
                if (count($trainers) > 0) {
                    $firstTrainer = $trainers[0];
                    $this->info('First trainer ID: ' . (isset($firstTrainer['id']) ? $firstTrainer['id'] : 'NO ID'));
                    $this->info('First trainer keys: ' . implode(', ', array_keys($firstTrainer)));
                }
                
                return $trainers;
            }
            
            $this->error('Invalid response format - not an array');
            $this->info('Response preview: ' . substr($response, 0, 200));
            return [];
        } catch (\Exception $e) {
            $this->error('Error fetching trainers: ' . $e->getMessage());
            return [];
        }
    }
}
