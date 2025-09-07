<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewSitemap extends Command
{
    protected $signature = 'sitemap:view {--format=pretty : Format output as pretty or raw}';
    protected $description = 'View the sitemap content directly from the command line';

    public function handle()
    {
        $sitemapPath = public_path('sitemap.xml');
        
        if (!File::exists($sitemapPath)) {
            $this->error('Sitemap file does not exist. Please generate it first with php artisan sitemap:generate');
            return 1;
        }
        
        $content = File::get($sitemapPath);
        $format = $this->option('format');
        
        if ($format === 'raw') {
            // Output raw XML
            $this->line($content);
        } else {
            // Pretty format with counts and colors
            $totalUrls = substr_count($content, '<url>');
            $trainerUrls = substr_count($content, '/trainer/');
            
            $this->info('===== Sitemap Content =====');
            $this->info("Total URLs: $totalUrls | Trainer URLs: $trainerUrls");
            $this->newLine();
            
            // Parse and prettify XML
            $dom = new \DOMDocument();
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($content);
            
            $prettyXml = $dom->saveXML();
            
            // Colorize the output
            $lines = explode("\n", $prettyXml);
            foreach ($lines as $line) {
                if (strpos($line, '<url>') !== false) {
                    $this->newLine();
                    $this->line("<fg=green>$line</>");
                } else if (strpos($line, '/trainer/') !== false) {
                    $this->line("<fg=yellow>$line</>");
                } else {
                    $this->line($line);
                }
            }
        }
        
        return 0;
    }
}
