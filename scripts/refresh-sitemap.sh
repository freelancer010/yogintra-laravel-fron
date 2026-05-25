#!/bin/bash

# Change to project root directory
cd $(dirname "$0")/..

echo "Clearing application cache..."
php artisan cache:clear

echo "Clearing config cache..."
php artisan config:clear

echo "Clearing route cache..."
php artisan route:clear

echo "Clearing view cache..."
php artisan view:clear

echo "Generating sitemap..."
php artisan sitemap:generate

echo "All done! Sitemap has been refreshed."

# Check if sitemap.xml exists
if [ -f "public/sitemap.xml" ]; then
    echo "Sitemap file exists: $(du -h public/sitemap.xml | cut -f1)"
    echo "Total URLs: $(grep -c "<url>" public/sitemap.xml)"
    echo "Trainer URLs: $(grep -c "/trainer/" public/sitemap.xml)"
else
    echo "ERROR: sitemap.xml file not found!"
fi
