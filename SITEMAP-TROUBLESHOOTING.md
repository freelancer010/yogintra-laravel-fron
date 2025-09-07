# Sitemap Troubleshooting Guide

This document provides instructions for troubleshooting sitemap generation issues, especially when trainer URLs are missing from the sitemap.

## Quick Solutions

1. **Regenerate the sitemap from the admin dashboard**
   - Go to the admin dashboard
   - Click the "Generate Sitemap" button
   - Check the preview card to see if trainer URLs are now included

2. **Clear all caches and regenerate**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   php artisan sitemap:generate
   ```

3. **Use the diagnostic tool**
   ```bash
   php artisan sitemap:diagnose
   ```

## Common Issues

### 1. Missing Trainer URLs in Sitemap

**Symptoms:**
- Sitemap is generated successfully, but no `/trainer/` URLs are included
- Sitemap preview shows "0 Trainer URLs" with a warning badge

**Possible Causes:**
- API connection issue
- SSL certificate verification problems
- Firewall or network restrictions
- Server environment differences between local and production

**Solutions:**
- Run the diagnostic tool: `php artisan sitemap:diagnose`
- Test the API connection: `php scripts/test-api-connection.php`
- Temporarily disable SSL verification in the SitemapController.php file
- Check server logs for any connection errors

### 2. Sitemap Not Updating

**Symptoms:**
- The sitemap's "Last Updated" timestamp doesn't change after regeneration
- Changes to the website content aren't reflected in the sitemap

**Possible Causes:**
- File permission issues
- Cache issues
- Server configuration

**Solutions:**
- Check file permissions for the `public/sitemap.xml` file
- Run the refresh script: `php scripts/refresh-sitemap.sh`
- Manually delete the sitemap file and regenerate it

## Production Environment Troubleshooting

If issues persist in production but work fine in local environment:

1. **Check SSL Settings**
   - Production environments often have stricter SSL requirements
   - The sitemap generator has been modified to ignore SSL verification for the API call

2. **Test API Connection**
   - Connect to your production server
   - Run `php scripts/test-api-connection.php` to see detailed output
   - Check if the API returns trainer data correctly

3. **File Permission Issues**
   - Make sure the web server user has write permissions to `public/sitemap.xml`
   - Run `chmod 664 public/sitemap.xml` to set proper permissions

4. **Environment Differences**
   - Check if the production environment has all required PHP extensions
   - Ensure CURL is enabled: `php -m | grep curl`

## Command Reference

| Command | Description |
|---------|-------------|
| `php artisan sitemap:generate` | Generate the sitemap via command line |
| `php artisan sitemap:diagnose` | Run diagnostic tests on the sitemap and API |
| `php scripts/refresh-sitemap.sh` | Clear all caches and generate sitemap |
| `php scripts/test-api-connection.php` | Test the trainer API connection |

## Still Having Issues?

If you've tried all the above solutions and still have problems:

1. Check the web server error logs
2. Verify the API endpoint is accessible from your server
3. Test with a simple CURL command: `curl -d "data=" https://crm.yogintra.com/api/getTrainerSearchData`
4. Contact technical support with the diagnostic output
