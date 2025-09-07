<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class DiagnoseSitemap extends Command
{
    protected $signature = 'sitemap:diagnose';
    protected $description = 'Diagnose sitemap generation issues and test API connection';

    public function handle()
    {
        $this->info('===== Sitemap Diagnostic Tool =====');
        
        // Check if sitemap file exists
        $sitemapPath = public_path('sitemap.xml');
        if (File::exists($sitemapPath)) {
            $this->info('✅ Sitemap file exists at: ' . $sitemapPath);
            $size = round(File::size($sitemapPath) / 1024, 2) . ' KB';
            $lastModified = date('Y-m-d H:i:s', File::lastModified($sitemapPath));
            
            $this->line("   - File size: $size");
            $this->line("   - Last modified: $lastModified");
            
            // Check sitemap content
            $content = File::get($sitemapPath);
            $totalUrls = substr_count($content, '<url>');
            $trainerUrls = substr_count($content, '/trainer/');
            
            $this->line("   - Total URLs: $totalUrls");
            $this->line("   - Trainer URLs: $trainerUrls");
            
            if ($trainerUrls === 0) {
                $this->warn('⚠️ No trainer URLs found in the sitemap!');
            }
        } else {
            $this->error('❌ Sitemap file does not exist!');
        }
        
        $this->newLine();
        $this->info('===== Testing API Connection =====');
        
        // Test API Connection
        $this->line("Connecting to API: https://crm.yogintra.com/api/getTrainerSearchData");
        
        try {
            // Initialize cURL session
            $ch = curl_init();
            
            // Set options
            curl_setopt($ch, CURLOPT_URL, 'https://crm.yogintra.com/api/getTrainerSearchData');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['data' => '']));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            
            // Execute cURL request
            $start = microtime(true);
            $response = curl_exec($ch);
            $time = round(microtime(true) - $start, 2);
            
            // Check for errors
            if (curl_errno($ch)) {
                $this->error("❌ cURL Error: " . curl_error($ch));
                $this->error("Error Code: " . curl_errno($ch));
            } else {
                $this->info("✅ API connection successful in $time seconds");
                
                // Get HTTP status code
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $this->line("HTTP Status Code: $httpCode");
                
                // Parse response
                $trainers = json_decode($response, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->error("❌ JSON Error: " . json_last_error_msg());
                    $this->line("Raw Response (first 500 chars):");
                    $this->line(substr($response, 0, 500) . "...");
                } else {
                    if (is_array($trainers)) {
                        $this->info("✅ Successfully received " . count($trainers) . " trainers.");
                        
                        if (count($trainers) > 0) {
                            $this->line("First 3 trainers:");
                            $i = 0;
                            foreach ($trainers as $trainer) {
                                if ($i >= 3) break;
                                $this->line("- ID: " . ($trainer['id'] ?? 'N/A') . ", Name: " . ($trainer['name'] ?? 'N/A'));
                                $i++;
                            }
                        } else {
                            $this->warn("⚠️ API returned empty trainer array");
                        }
                    } else {
                        $this->error("❌ API response is not an array. Type received: " . gettype($trainers));
                    }
                }
            }
            
            curl_close($ch);
            
            // Test writing to cache
            $this->newLine();
            $this->info('===== Testing Cache =====');
            try {
                Cache::put('sitemap_test', 'test_value', 60);
                if (Cache::has('sitemap_test')) {
                    $this->info("✅ Cache system is working properly");
                    Cache::forget('sitemap_test');
                } else {
                    $this->error("❌ Cache system is not working");
                }
            } catch (\Exception $e) {
                $this->error("❌ Cache Error: " . $e->getMessage());
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Exception: " . $e->getMessage());
        }
        
        $this->newLine();
        $this->info('===== Recommendations =====');
        if (!File::exists($sitemapPath)) {
            $this->line("1. Run 'php artisan sitemap:generate' to generate the sitemap");
        } elseif (isset($trainerUrls) && $trainerUrls === 0) {
            $this->line("1. Check API connection (see above results)");
            $this->line("2. Make sure CURL extensions are enabled on your server");
            $this->line("3. Try running 'php scripts/refresh-sitemap.sh' to clear caches and regenerate sitemap");
            $this->line("4. Check for any network restrictions that might block API requests");
        } else {
            $this->line("Everything appears to be working correctly!");
        }
        
        return 0;
    }
}
